<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingItemOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_item_id',
        'service_option_id',
        'option_name',
        'quantity',
        'unit_price',
        'duration',
        'total',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'duration' => 'integer',
        'total' => 'decimal:2',
    ];

    public function bookingItem()
    {
        return $this->belongsTo(BookingItem::class);
    }

    public function serviceOption()
    {
        return $this->belongsTo(ServiceOption::class);
    }
}
