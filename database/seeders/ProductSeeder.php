<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Store;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $stores = Store::all();

        foreach ($stores as $store) {
            Product::create([
                'store_id' => $store->id,
                'name' => 'Combo Especial ' . $store->id,
                'description' => 'Un delicioso combo para compartir',
                'price' => 45.50,
                'image_url' => 'https://example.com/images/combo.jpg'
            ]);

            Product::create([
                'store_id' => $store->id,
                'name' => 'Bebida Mediana ' . $store->id,
                'description' => 'Bebida refrescante de 500ml',
                'price' => 10.00,
                'image_url' => 'https://example.com/images/bebida.jpg'
            ]);

            Product::create([
                'store_id' => $store->id,
                'name' => 'Postre Sorpresa ' . $store->id,
                'description' => 'Un toque dulce para terminar',
                'price' => 15.00,
                'image_url' => 'https://example.com/images/postre.jpg'
            ]);
        }
    }
}
