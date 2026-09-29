<?php

namespace Database\Seeders;

use App\Models\DocumentType;
use Illuminate\Database\Seeder;

class DocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DocumentType::create([
            'name' => 'Welder Qualification Test Record',
            'category' => 'WQT',
            'description' => 'Welder Qualification Test Record (WQT) - AWS standard certification',
            'is_public' => true,
        ]);
    }
}
