<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'discount',
        'type',
        'valid_from',
        'valid_until',
        'applicable_services',
        'status',
        'code',
    ];

    protected $casts = [
        'discount' => 'decimal:2',
        'valid_from' => 'date',
        'valid_until' => 'date',
        'applicable_services' => 'array',
    ];
}
