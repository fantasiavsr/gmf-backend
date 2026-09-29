<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use RuntimeException;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        if (app()->environment('production')) {
            throw new RuntimeException('Demo user accounts must not be seeded in production.');
        }

        User::updateOrCreate(
            ['email' => 'admin@gmf.local'],
            [
                'name' => 'GMF Administrator',
                'password' => 'GMFadmin123!',
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin@mail.com'],
            [
                'name' => 'Admin',
                'password' => 'adminadmin',
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@gmf.local'],
            [
                'name' => 'GMF User',
                'password' => 'GMFuser123!',
                'role' => 'user',
            ]
        );
    }
}