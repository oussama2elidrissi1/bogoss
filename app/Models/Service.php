<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'duration',
        'price',
        'description',
        'image',
        'available',
    ];

    protected $casts = [
        'duration' => 'integer',
        'price' => 'decimal:2',
        'available' => 'boolean',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function bookingItems()
    {
        return $this->hasMany(BookingItem::class);
    }

    public function options()
    {
        return $this->hasMany(ServiceOption::class)->orderBy('sort_order');
    }

    public function availableOptions()
    {
        return $this->hasMany(ServiceOption::class)
            ->where('available', true)
            ->orderBy('sort_order');
    }

    public function requiredOptions()
    {
        return $this->hasMany(ServiceOption::class)
            ->where('is_required', true)
            ->where('available', true)
            ->orderBy('sort_order');
    }

    public function staff()
    {
        return $this->belongsToMany(Staff::class, 'service_staff')
            ->withPivot('payout_percentage')
            ->withTimestamps();
    }
}
