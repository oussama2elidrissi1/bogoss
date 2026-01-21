<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'partner_id',
        'partner_name',
        'client_name',
        'service_id',
        'service',
        'staff_id',
        'staff_name',
        'date',
        'time',
        'duration',
        'price',
        'commission_rate',
        'commission_amount',
        'staff_payout_percentage',
        'staff_payout_amount',
        'status',
        'notes',
        'commission_paid_at',
    ];

    protected $casts = [
        'date' => 'date',
        'duration' => 'integer',
        'price' => 'decimal:2',
        'commission_rate' => 'decimal:2',
        'commission_amount' => 'decimal:2',
        'staff_payout_percentage' => 'decimal:2',
        'staff_payout_amount' => 'decimal:2',
        'commission_paid_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }
}
