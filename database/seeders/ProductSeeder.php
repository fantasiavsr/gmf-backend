<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::firstOrCreate(['sku' => 'WH-001'], [
            'name' => 'Wireless Headphones',
            'type' => 'Electronics',
            'price' => '$349',
            'available' => 24,
            'status' => 'active',
            'description' => 'Premium wireless headphones with noise cancellation.',
        ]);

        Product::firstOrCreate(['sku' => 'LB-002'], [
            'name' => 'Leather Backpack',
            'type' => 'Accessories',
            'price' => '$129',
            'available' => 0,
            'status' => 'inactive',
            'description' => 'Handcrafted leather backpack with laptop sleeve.',
        ]);

        Product::firstOrCreate(['sku' => 'UC-003'], [
            'name' => 'USB-C Hub',
            'type' => 'Electronics',
            'price' => '$79',
            'available' => 156,
            'status' => 'active',
            'description' => '7-in-1 USB-C hub with HDMI and card reader.',
        ]);

        Product::firstOrCreate(['sku' => 'CM-004'], [
            'name' => 'Coffee Maker',
            'type' => 'Appliances',
            'price' => '$199',
            'available' => 8,
            'status' => 'active',
            'description' => 'Programmable drip coffee maker with thermal carafe.',
        ]);

        Product::firstOrCreate(['sku' => 'DL-005'], [
            'name' => 'Desk Lamp',
            'type' => 'Furniture',
            'price' => '$89',
            'available' => 42,
            'status' => 'active',
            'description' => 'Adjustable LED desk lamp with wireless charging base.',
        ]);

        Product::firstOrCreate(['sku' => 'PS-006'], [
            'name' => 'Phone Stand',
            'type' => 'Accessories',
            'price' => '$29',
            'available' => 203,
            'status' => 'active',
            'description' => 'Minimalist aluminum phone stand for desk.',
        ]);
    }
}
