<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;

class OrderController extends Controller
{
    public function __construct()
    {
        // Set Midtrans configuration
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
        
        // Prevent cURL from hanging on IPv6 and set timeouts
        // MUST include CURLOPT_HTTPHEADER to prevent PHP 8 'Undefined array key' error in Midtrans SDK
        Config::$curlOptions = [
            CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => [],
        ];
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $orderNumber = 'SS' . time();

            // Buat order baru
            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => Auth::id(),
                'status' => 'paid', // Keep existing field compatibility
                'payment_status' => 'pending',
                'subtotal' => $request->subtotal,
                'shipping_cost' => 25000,
                'discount' => 50000,
                'total' => $request->total,
                'payment_method' => $request->payment_method ?? 'midtrans',
                'selected_bank' => $request->selected_bank ?? null,
                'shipping_first_name' => $request->first_name,
                'shipping_last_name' => $request->last_name ?? null,
                'shipping_phone' => $request->phone,
                'shipping_address' => $request->address,
                'shipping_city' => $request->city,
                'shipping_zip' => $request->zip ?? null,
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

            // Create Midtrans Transaction
            $params = [
                'transaction_details' => [
                    'order_id' => $orderNumber,
                    'gross_amount' => $request->total,
                ],
                'customer_details' => [
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => Auth::user()->email ?? '',
                    'phone' => $request->phone,
                ]
            ];

            $snapToken = Snap::getSnapToken($params);

            // Save snap token to order
            $order->update([
                'snap_token' => $snapToken
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'order' => $order,
                'snap_token' => $snapToken,
                'message' => 'Pesanan berhasil dibuat'
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();
            
            // Log the error for debugging
            \Illuminate\Support\Facades\Log::error('Order Store Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            
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