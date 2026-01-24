<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\BookingItem;
use App\Models\BookingItemOption;
use App\Models\Client;
use App\Models\Promotion;
use App\Models\Service;
use App\Models\ServiceOption;
use App\Models\Staff;
use Illuminate\Support\Facades\DB;

class BookingService
{
    /**
     * Créer une réservation complète avec ses items et options
     */
    public function createBooking(array $data, Client $client): Booking
    {
        return DB::transaction(function () use ($data, $client) {
            // 1. Créer la réservation principale
            $booking = Booking::create([
                'client_id' => $client->id,
                'client_name' => $client->name,
                'date' => $data['date'],
                'time' => $data['time'],
                'notes' => $data['notes'] ?? null,
                'status' => 'pending',
                'payment_status' => 'pending',
                'subtotal' => 0,
                'discount_total' => 0,
                'total' => 0,
                'total_duration' => 0,
            ]);

            // 2. Créer les items de la réservation
            foreach ($data['items'] as $itemData) {
                $this->createBookingItem($booking, $itemData);
            }

            // 3. Mettre à jour les totaux
            $booking->updateTotals();

            return $booking->load(['items.options', 'items.service', 'items.staff']);
        });
    }

    /**
     * Créer un item de réservation avec ses options
     */
    private function createBookingItem(Booking $booking, array $itemData): BookingItem
    {
        $service = Service::findOrFail($itemData['service_id']);
        $quantity = $itemData['quantity'] ?? 1;
        $staff = !empty($itemData['staff_id']) ? Staff::find($itemData['staff_id']) : null;

        // Récupérer les promotions actives
        $promotion = $this->findBestPromotion($service);
        $discountAmount = $this->calculateDiscount($service, $promotion);

        // Calculer le payout du staff
        $staffPayoutPercentage = 0;
        if ($staff) {
            $staffPayoutPercentage = $service->staff()
                ->where('staff_id', $staff->id)
                ->first()
                ?->pivot
                ?->payout_percentage ?? 0;
        }

        // Créer l'item
        $item = BookingItem::create([
            'booking_id' => $booking->id,
            'service_id' => $service->id,
            'service_name' => $service->name,
            'staff_id' => $staff?->id,
            'staff_name' => $staff?->name,
            'quantity' => $quantity,
            'unit_price' => $service->price,
            'duration' => $service->duration,
            'options_total' => 0,
            'subtotal' => $service->price * $quantity,
            'discount_amount' => $discountAmount * $quantity,
            'total' => ($service->price - $discountAmount) * $quantity,
            'promotion_id' => $promotion?->id,
            'promotion_code' => $promotion?->code,
            'staff_payout_percentage' => $staffPayoutPercentage,
            'staff_payout_amount' => 0, // Sera recalculé après les options
            'notes' => $itemData['notes'] ?? null,
        ]);

        // Ajouter les options
        if (!empty($itemData['options'])) {
            foreach ($itemData['options'] as $optionData) {
                $this->addOptionToItem($item, $optionData);
            }

            // Recalculer les totaux de l'item après ajout des options
            $this->recalculateItemTotals($item);
        }

        return $item;
    }

    /**
     * Ajouter une option à un item
     */
    private function addOptionToItem(BookingItem $item, array $optionData): BookingItemOption
    {
        $option = ServiceOption::findOrFail($optionData['option_id']);
        $quantity = $optionData['quantity'] ?? 1;

        // Vérifier que l'option appartient bien au service
        if ($option->service_id !== $item->service_id) {
            throw new \InvalidArgumentException(
                "L'option '{$option->name}' n'appartient pas au service '{$item->service_name}'"
            );
        }

        // Vérifier la quantité max
        if ($quantity > $option->max_quantity) {
            throw new \InvalidArgumentException(
                "La quantité demandée pour '{$option->name}' dépasse le maximum autorisé ({$option->max_quantity})"
            );
        }

        return BookingItemOption::create([
            'booking_item_id' => $item->id,
            'service_option_id' => $option->id,
            'option_name' => $option->name,
            'quantity' => $quantity,
            'unit_price' => $option->price,
            'duration' => $option->duration,
            'total' => $option->price * $quantity,
        ]);
    }

    /**
     * Recalculer les totaux d'un item après ajout d'options
     */
    private function recalculateItemTotals(BookingItem $item): void
    {
        $item->refresh();
        
        $optionsTotal = $item->options->sum('total');
        $subtotal = ($item->unit_price + $optionsTotal) * $item->quantity;
        $total = $subtotal - $item->discount_amount;
        
        // Calculer le payout du staff (uniquement sur le service, pas les options)
        $staffPayoutAmount = 0;
        if ($item->staff_id && $item->staff_payout_percentage > 0) {
            $serviceTotal = $item->unit_price * $item->quantity;
            $staffPayoutAmount = round(($serviceTotal * $item->staff_payout_percentage) / 100, 2);
        }

        $item->update([
            'options_total' => $optionsTotal,
            'subtotal' => $subtotal,
            'total' => $total,
            'staff_payout_amount' => $staffPayoutAmount,
        ]);
    }

    /**
     * Trouver la meilleure promotion pour un service
     */
    private function findBestPromotion(Service $service): ?Promotion
    {
        $today = now()->toDateString();
        $promotions = Promotion::query()
            ->where('status', 'active')
            ->whereDate('valid_from', '<=', $today)
            ->whereDate('valid_until', '>=', $today)
            ->get();

        $bestPromotion = null;
        $bestDiscount = 0;

        foreach ($promotions as $promotion) {
            if (!$this->isPromotionApplicable($promotion, $service)) {
                continue;
            }

            $discount = $this->calculateDiscount($service, $promotion);
            if ($discount > $bestDiscount) {
                $bestDiscount = $discount;
                $bestPromotion = $promotion;
            }
        }

        return $bestPromotion;
    }

    /**
     * Vérifier si une promotion est applicable à un service
     */
    private function isPromotionApplicable(Promotion $promotion, Service $service): bool
    {
        $applicable = is_array($promotion->applicable_services)
            ? $promotion->applicable_services
            : json_decode($promotion->applicable_services ?? '[]', true);
        $applicable = is_array($applicable) ? $applicable : [];

        foreach ($applicable as $item) {
            if (is_numeric($item) && (int) $item === (int) $service->id) {
                return true;
            }
            if (is_string($item) && ($item === $service->category || $item === (string) $service->id)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Calculer le montant de réduction
     */
    private function calculateDiscount(Service $service, ?Promotion $promotion): float
    {
        if (!$promotion) {
            return 0;
        }

        $amount = 0;
        if ($promotion->type === 'percentage') {
            $amount = ((float) $service->price) * ((float) $promotion->discount) / 100;
        } else {
            $amount = (float) $promotion->discount;
        }

        return max(0, min($amount, (float) $service->price));
    }

    /**
     * Calculer les totaux d'une réservation avant création (pour preview)
     */
    public function calculateCartTotals(array $items): array
    {
        $subtotal = 0;
        $discountTotal = 0;
        $totalDuration = 0;
        $itemsBreakdown = [];

        foreach ($items as $itemData) {
            $service = Service::findOrFail($itemData['service_id']);
            $quantity = $itemData['quantity'] ?? 1;
            
            $itemSubtotal = $service->price * $quantity;
            $optionsTotal = 0;
            $optionsDuration = 0;

            // Calculer les options
            if (!empty($itemData['options'])) {
                foreach ($itemData['options'] as $optionData) {
                    $option = ServiceOption::findOrFail($optionData['option_id']);
                    $optionQty = $optionData['quantity'] ?? 1;
                    $optionsTotal += $option->price * $optionQty;
                    $optionsDuration += $option->duration * $optionQty;
                }
            }

            $itemSubtotal += $optionsTotal;
            
            // Calculer la promotion
            $promotion = $this->findBestPromotion($service);
            $itemDiscount = $this->calculateDiscount($service, $promotion) * $quantity;
            
            $itemTotal = $itemSubtotal - $itemDiscount;
            $itemDuration = ($service->duration + $optionsDuration) * $quantity;

            $subtotal += $itemSubtotal;
            $discountTotal += $itemDiscount;
            $totalDuration += $itemDuration;

            $itemsBreakdown[] = [
                'service_id' => $service->id,
                'service_name' => $service->name,
                'quantity' => $quantity,
                'unit_price' => (float) $service->price,
                'options_total' => $optionsTotal,
                'subtotal' => $itemSubtotal,
                'discount' => $itemDiscount,
                'total' => $itemTotal,
                'duration' => $itemDuration,
                'promotion' => $promotion ? [
                    'code' => $promotion->code,
                    'type' => $promotion->type,
                    'discount' => (float) $promotion->discount,
                ] : null,
            ];
        }

        return [
            'subtotal' => round($subtotal, 2),
            'discount_total' => round($discountTotal, 2),
            'total' => round($subtotal - $discountTotal, 2),
            'total_duration' => $totalDuration,
            'items' => $itemsBreakdown,
        ];
    }
}
