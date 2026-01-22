<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'role',
        'specialties',
        'email',
        'phone',
        'join_date',
        'rating',
        'completed_services',
        'availability',
        'image',
    ];

    protected $casts = [
        'role' => 'array',
        'specialties' => 'array',
        'availability' => 'array',
        'join_date' => 'date',
        'rating' => 'decimal:1',
        'completed_services' => 'integer',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'service_staff')
            ->withPivot('payout_percentage')
            ->withTimestamps();
    }
}
