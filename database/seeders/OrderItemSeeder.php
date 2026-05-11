<?php

namespace Database\Seeders;

use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderItemSeeder extends Seeder
{
    public function run(): void
    {
        $order = Order::first();
        $product = Product::first();

        if ($order && $product) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_brand' => $product->brand,
                'product_category' => $product->category,
                'product_price' => $product->price,
                'image_color' => $product->image_color,
                'size' => '42',
                'quantity' => 1,
            ]);
        }
    }
}