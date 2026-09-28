<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PricingPlan extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'billingPeriod',
        'benefits',
        'duration',
    ];

    protected $casts = [
        'benefits' => 'array',
    ];
}
