<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingItemResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'service' => [
                'id' => $this->service_id,
                'name' => $this->service_name,
            ],
            'staff' => $this->staff_id ? [
                'id' => $this->staff_id,
                'name' => $this->staff_name,
            ] : null,
            'quantity' => $this->quantity,
            'unit_price' => (float) $this->unit_price,
            'duration' => $this->duration,
            'pricing' => [
                'options_total' => (float) $this->options_total,
                'subtotal' => (float) $this->subtotal,
                'discount_amount' => (float) $this->discount_amount,
                'total' => (float) $this->total,
            ],
            'promotion' => $this->promotion_id ? [
                'id' => $this->promotion_id,
                'code' => $this->promotion_code,
            ] : null,
            'staff_payout' => $this->staff_id ? [
                'percentage' => (float) $this->staff_payout_percentage,
                'amount' => (float) $this->staff_payout_amount,
            ] : null,
            'options' => BookingItemOptionResource::collection($this->whenLoaded('options')),
            'notes' => $this->notes,
        ];
    }
}
