<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::find(2);
        
        if (!$user) {
            $user = User::first();
        }
        
        if ($user) {
            Order::create([
                'order_number' => 'SS' . date('Ymd') . '001',
                'user_id' => $user->id,
                'status' => 'delivered',
                'subtotal' => 1200000,
                'shipping_cost' => 25000,
                'discount' => 50000,
                'total' => 1200000 + 25000 - 50000,
                'payment_method' => 'transfer',
                'selected_bank' => 'bca',
                'shipping_first_name' => $user->first_name ?? 'Test',
                'shipping_last_name' => $user->last_name ?? 'User',
                'shipping_phone' => '08123456789',
                'shipping_address' => 'Jl. Contoh No. 123',
                'shipping_city' => 'Jakarta',
                'shipping_zip' => '12345',
            ]);
        }
    }
}