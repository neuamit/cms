<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class PricingPlan extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'pricing_plans';

    protected $fillable = ['key', 'label', 'amount', 'months'];
}