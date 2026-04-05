<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin Delivery',
            'email' => 'admin@satelite.com',
            'phone' => '70000000',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // Driver
        User::create([
            'name' => 'Juan Perez (Driver)',
            'email' => 'driver1@satelite.com',
            'phone' => '71111111',
            'password' => Hash::make('password123'),
            'role' => 'driver',
        ]);

        // Owners
        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'name' => "Dueño Tienda $i",
                'email' => "owner$i@satelite.com",
                'phone' => "7222220$i",
                'password' => Hash::make('password123'),
                'role' => 'cliente', // Or admin / special role, but owner is currently handled via user_id relationship
            ]);
        }
        
        // Client
        User::create([
            'name' => 'Cliente Feliz',
            'email' => 'cliente@satelite.com',
            'phone' => '73333333',
            'password' => Hash::make('password123'),
            'role' => 'cliente',
        ]);
    }
}
