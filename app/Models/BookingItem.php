<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'service_id',
        'service_name',
        'staff_id',
        'staff_name',
        'quantity',
        'unit_price',
        'duration',
        'options_total',
        'subtotal',
        'discount_amount',
        'total',
        'promotion_id',
        'promotion_code',
        'staff_payout_percentage',
        'staff_payout_amount',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'duration' => 'integer',
        'options_total' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total' => 'decimal:2',
        'staff_payout_percentage' => 'decimal:2',
        'staff_payout_amount' => 'decimal:2',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

    public function options()
    {
        return $this->hasMany(BookingItemOption::class);
    }

    /**
     * Calculer le subtotal en fonction des options
     */
    public function calculateSubtotal(): float
    {
        $optionsTotal = $this->options->sum('total');
        return ($this->unit_price + $optionsTotal) * $this->quantity;
    }

    /**
     * Calculer le total final après discount
     */
    public function calculateTotal(): float
    {
        return max(0, $this->subtotal - $this->discount_amount);
    }

    /**
     * Calculer la durée totale incluant les options
     */
    public function calculateTotalDuration(): int
    {
        $optionsDuration = $this->options->sum(function ($option) {
            return $option->duration * $option->quantity;
        });
        return ($this->duration + $optionsDuration) * $this->quantity;
    }

    /**
     * Calculer le payout du staff
     */
    public function calculateStaffPayout(): float
    {
        if (!$this->staff_id || !$this->staff_payout_percentage) {
            return 0;
        }
        // Le payout est calculé uniquement sur le prix du service (pas les options)
        $serviceTotal = $this->unit_price * $this->quantity;
        return round(($serviceTotal * $this->staff_payout_percentage) / 100, 2);
    }
}
