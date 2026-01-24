<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_reference',
        'client_id',
        'client_name',
        'date',
        'time',
        'subtotal',
        'discount_total',
        'total',
        'total_duration',
        'status',
        'payment_status',
        'payment_method',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
        'subtotal' => 'decimal:2',
        'discount_total' => 'decimal:2',
        'total' => 'decimal:2',
        'total_duration' => 'integer',
        'created_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        
        // Générer une référence unique lors de la création
        static::creating(function ($booking) {
            if (empty($booking->booking_reference)) {
                $booking->booking_reference = 'BK-' . strtoupper(uniqid());
            }
        });
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function items()
    {
        return $this->hasMany(BookingItem::class);
    }

    /**
     * Calculer les totaux de la réservation
     */
    public function calculateTotals(): array
    {
        $subtotal = $this->items->sum('subtotal');
        $discountTotal = $this->items->sum('discount_amount');
        $total = $this->items->sum('total');
        $totalDuration = $this->items->sum(function ($item) {
            return $item->calculateTotalDuration();
        });

        return [
            'subtotal' => round($subtotal, 2),
            'discount_total' => round($discountTotal, 2),
            'total' => round($total, 2),
            'total_duration' => $totalDuration,
        ];
    }

    /**
     * Mettre à jour les totaux de la réservation
     */
    public function updateTotals(): void
    {
        $totals = $this->calculateTotals();
        $this->update($totals);
    }
}
