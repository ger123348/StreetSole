<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // Buat order baru
            $order = Order::create([
                'order_number' => 'SS' . time(),
                'user_id' => Auth::id(),
                'status' => 'paid',
                'subtotal' => $request->subtotal,
                'shipping_cost' => 25000,
                'discount' => 50000,
                'total' => $request->total,
                'payment_method' => $request->payment_method,
                'selected_bank' => $request->selected_bank,
                'shipping_first_name' => $request->first_name,
                'shipping_last_name' => $request->last_name,
                'shipping_phone' => $request->phone,
                'shipping_address' => $request->address,
                'shipping_city' => $request->city,
                'shipping_zip' => $request->zip,
                'shipping_lat' => $request->lat ?? null,
                'shipping_lng' => $request->lng ?? null,
            ]);

            // Simpan item pesanan
            foreach ($request->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'product_name' => $item['name'],
                    'product_brand' => $item['brand'],
                    'product_category' => $item['category'],
                    'product_price' => $item['price'],
                    'image_color' => $item['imageColor'],
                    'size' => $item['size'],
                    'quantity' => $item['qty'],
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'order' => $order,
                'message' => 'Pesanan berhasil dibuat'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan pesanan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function index()
    {
        $orders = Order::with('items')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($orders);
    }
}