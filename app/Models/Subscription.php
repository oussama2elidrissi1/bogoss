<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'duration',
        'benefits',
        'color',
        'popular',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'benefits' => 'array',
        'popular' => 'boolean',
    ];
}
