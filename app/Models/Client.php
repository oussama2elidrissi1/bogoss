<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'join_date',
        'subscription',
        'total_spent',
        'visits',
        'last_visit',
        'preferences',
        'notes',
    ];

    protected $casts = [
        'join_date' => 'date',
        'last_visit' => 'date',
        'preferences' => 'array',
        'total_spent' => 'decimal:2',
        'visits' => 'integer',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
