<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Store;
use App\Models\User;

class StoreSeeder extends Seeder
{
    public function run(): void
    {
        // Start owners from ID 3 (since 1 is admin, 2 is driver).
        $storeData = [
            [
                'name' => 'Pollos Copacabana',
                'lat' => -16.50000000,
                'lng' => -68.15000000,
                'image_url' => 'https://example.com/images/pollos_copacabana.jpg',
                'user_id' => 3
            ],
            [
                'name' => 'Burger King',
                'lat' => -16.50500000,
                'lng' => -68.14500000,
                'image_url' => 'https://example.com/images/burger_king.jpg',
                'user_id' => 4
            ],
            [
                'name' => 'Pizza Eli',
                'lat' => -16.51000000,
                'lng' => -68.14000000,
                'image_url' => 'https://example.com/images/pizza_eli.jpg',
                'user_id' => 5
            ],
            [
                'name' => 'Subway',
                'lat' => -16.51500000,
                'lng' => -68.13500000,
                'image_url' => 'https://example.com/images/subway.jpg',
                'user_id' => 6
            ],
            [
                'name' => 'Dumbo',
                'lat' => -16.52000000,
                'lng' => -68.13000000,
                'image_url' => 'https://example.com/images/dumbo.jpg',
                'user_id' => 7
            ],
        ];

        foreach ($storeData as $data) {
            Store::create($data);
        }
    }
}
