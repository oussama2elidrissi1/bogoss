<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'contact_name',
        'contact_email',
        'contact_phone',
        'commission_rate',
        'active',
    ];

    protected $casts = [
        'commission_rate' => 'decimal:2',
        'active' => 'boolean',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'partner_users');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
