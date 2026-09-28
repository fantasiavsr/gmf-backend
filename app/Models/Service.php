<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name',
        'description',
        'included',
        'price',
        'billingPeriod',
        'duration',
        'members',
    ];

    protected $casts = [
        'included' => 'array',
        'members' => 'integer',
    ];
}
