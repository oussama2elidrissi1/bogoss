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

    public function staff()
    {
        return $this->belongsToMany(Staff::class, 'service_staff')
            ->withPivot('payout_percentage')
            ->withTimestamps();
    }
}
