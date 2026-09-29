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
        DocumentType::firstOrCreate(['category' => 'WQT'], [
            'name' => 'Welder Qualification Test Record',
            'description' => 'Welder Qualification Test Record (WQT) - AWS standard certification',
            'is_public' => true,
        ]);
    }
}
