<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'type',
        'sku',
        'price',
        'available',
        'status',
        'description',
    ];

    protected $casts = [
        'available' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
