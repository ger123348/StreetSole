<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil data yang sudah ada
        $user = User::find(2) ?? User::first();
        $order = Order::first();
        $product = Product::find(1) ?? Product::first();

        if ($user && $order && $product) {
            Review::create([
                'user_id' => $user->id,
                'order_id' => $order->id,
                'product_id' => $product->id,
                'rating' => 5,
                'comment' => 'Kualitas luar biasa! Recommended banget untuk sneaker lovers.',
            ]);

            Review::create([
                'user_id' => $user->id,
                'order_id' => $order->id,
                'product_id' => $product->id,
                'rating' => 4,
                'comment' => 'Desain timeless, nyaman dipakai seharian.',
            ]);
        }
    }
}