<?php

namespace Database\Seeders;

use App\Models\PricingPlan;
use Illuminate\Database\Seeder;

class PricingPlanSeeder extends Seeder
{
    public function run(): void
    {
        PricingPlan::updateOrCreate(['key' => 'monthly'], ['label' => 'Monthly', 'amount' => 999, 'months' => 1]);
        PricingPlan::updateOrCreate(['key' => 'yearly'], ['label' => 'Yearly', 'amount' => 9999, 'months' => 12]);
    }
}