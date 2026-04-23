<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::firstOrCreate(
            ['email' => 'admin@ruangrasa.com'],
            [
                'name' => 'Admin Ruang Rasa',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );

        // Create Patient User
        User::firstOrCreate(
            ['email' => 'patient@test.com'],
            [
                'name' => 'Test Patient',
                'password' => Hash::make('password'),
                'is_admin' => false,
            ]
        );
    }
}
