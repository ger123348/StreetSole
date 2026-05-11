<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Urutan PENTING: User → Product → Order → Review
        $this->call([
            UserSeeder::class,      // 1. Buat user dulu
            ProductSeeder::class,   // 2. Buat produk
            OrderSeeder::class,     // 3. Buat order (butuh user_id)
            OrderItemSeeder::class,
            ReviewSeeder::class,    // 4. Buat review (butuh user_id, order_id, product_id)
        ]);
    }
}