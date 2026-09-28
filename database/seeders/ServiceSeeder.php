<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        Service::create([
            'name' => 'Brand Strategy',
            'description' => 'A focused strategy engagement to clarify your positioning and direction.',
            'included' => ['Discovery workshop', 'Brand positioning', 'Strategic roadmap'],
            'price' => '$2,400',
            'billingPeriod' => 'usage',
            'duration' => '3-4 weeks',
            'members' => 2,
        ]);

        Service::create([
            'name' => 'Web Design',
            'description' => 'Thoughtful digital experiences designed around your audience and goals.',
            'included' => ['UX direction', 'Visual design system', 'Responsive prototypes'],
            'price' => '$4,800',
            'billingPeriod' => 'usage',
            'duration' => '6-8 weeks',
            'members' => 3,
        ]);

        Service::create([
            'name' => 'Ongoing Support',
            'description' => 'Flexible design support for teams that need an experienced partner on call.',
            'included' => ['Monthly design hours', 'Priority requests', 'Design reviews'],
            'price' => '$1,200',
            'billingPeriod' => 'month',
            'duration' => 'Monthly',
            'members' => 1,
        ]);
    }
}
