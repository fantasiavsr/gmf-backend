<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Wireless Headphones',
            'type' => 'Electronics',
            'sku' => 'WH-001',
            'price' => '$349',
            'available' => 24,
            'status' => 'active',
            'description' => 'Premium wireless headphones with noise cancellation.',
        ]);

        Product::create([
            'name' => 'Leather Backpack',
            'type' => 'Accessories',
            'sku' => 'LB-002',
            'price' => '$129',
            'available' => 0,
            'status' => 'inactive',
            'description' => 'Handcrafted leather backpack with laptop sleeve.',
        ]);

        Product::create([
            'name' => 'USB-C Hub',
            'type' => 'Electronics',
            'sku' => 'UC-003',
            'price' => '$79',
            'available' => 156,
            'status' => 'active',
            'description' => '7-in-1 USB-C hub with HDMI and card reader.',
        ]);

        Product::create([
            'name' => 'Coffee Maker',
            'type' => 'Appliances',
            'sku' => 'CM-004',
            'price' => '$199',
            'available' => 8,
            'status' => 'active',
            'description' => 'Programmable drip coffee maker with thermal carafe.',
        ]);

        Product::create([
            'name' => 'Desk Lamp',
            'type' => 'Furniture',
            'sku' => 'DL-005',
            'price' => '$89',
            'available' => 42,
            'status' => 'active',
            'description' => 'Adjustable LED desk lamp with wireless charging base.',
        ]);

        Product::create([
            'name' => 'Phone Stand',
            'type' => 'Accessories',
            'sku' => 'PS-006',
            'price' => '$29',
            'available' => 203,
            'status' => 'active',
            'description' => 'Minimalist aluminum phone stand for desk.',
        ]);
    }
}
