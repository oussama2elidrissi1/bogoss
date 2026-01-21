<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventory';

    protected $fillable = [
        'name',
        'category',
        'quantity',
        'min_quantity',
        'unit',
        'price',
        'supplier',
        'last_restocked',
        'status',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'min_quantity' => 'integer',
        'price' => 'decimal:2',
        'last_restocked' => 'date',
    ];
}
