<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['name' => 'Nike Air Force 1', 'brand' => 'Nike', 'category' => 'sneakers', 'price' => 1200000, 'description' => 'Ikon jalanan yang timeless', 'image_color' => '#1a1a2e', 'rating' => 4.9],
            ['name' => 'Adidas Stan Smith', 'brand' => 'Adidas', 'category' => 'sneakers', 'price' => 980000, 'description' => 'Desain timeless', 'image_color' => '#1e3a2f', 'rating' => 4.7],
            ['name' => 'Vans Old Skool', 'brand' => 'Vans', 'category' => 'sneakers', 'price' => 750000, 'description' => 'Classic skate shoe', 'image_color' => '#2c2c2c', 'rating' => 4.6],
            ['name' => 'Pantofel Kulit Pria', 'brand' => 'Lokal', 'category' => 'formal', 'price' => 350000, 'description' => 'Pantofel elegan untuk formal', 'image_color' => '#5c3a21', 'rating' => 4.4],
            ['name' => 'Crocs Classic Clog', 'brand' => 'Crocs', 'category' => 'crocs', 'price' => 399000, 'description' => 'Nyaman dan ringan', 'image_color' => '#74b9ff', 'rating' => 4.5],
        ];

        foreach ($products as $product) {
            DB::table('products')->insert($product);
        }
    }
}