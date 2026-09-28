<?php

namespace Database\Seeders;

use App\Models\PricingPlan;
use Illuminate\Database\Seeder;

class PricingPlanSeeder extends Seeder
{
    public function run(): void
    {
        PricingPlan::create([
            'name' => 'Starter',
            'description' => 'A focused plan for individuals and small teams getting started.',
            'price' => '$29',
            'billingPeriod' => 'month',
            'benefits' => ['Core features', 'Email support', '1 team member'],
            'duration' => 'Monthly',
        ]);

        PricingPlan::create([
            'name' => 'Professional',
            'description' => 'Advanced tools for growing teams that need more flexibility.',
            'price' => '$79',
            'billingPeriod' => 'month',
            'benefits' => ['All Starter benefits', 'Advanced analytics', 'Up to 10 members'],
            'duration' => 'Monthly',
        ]);

        PricingPlan::create([
            'name' => 'Enterprise',
            'description' => 'A tailored plan with dedicated support for larger organizations.',
            'price' => '$199',
            'billingPeriod' => 'year',
            'benefits' => ['Unlimited features', 'Priority support', 'Dedicated success manager'],
            'duration' => 'Annual',
        ]);
    }
}
