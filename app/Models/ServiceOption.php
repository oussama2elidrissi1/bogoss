<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'name',
        'description',
        'price',
        'duration',
        'is_required',
        'available',
        'max_quantity',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'duration' => 'integer',
        'is_required' => 'boolean',
        'available' => 'boolean',
        'max_quantity' => 'integer',
        'sort_order' => 'integer',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function bookingItemOptions()
    {
        return $this->hasMany(BookingItemOption::class);
    }
}
