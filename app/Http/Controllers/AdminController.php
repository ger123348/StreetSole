<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductStock;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    private function checkAdmin()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
    }
    
    // TAMBAH PRODUK
    public function addProduct(Request $request)
    {
        $this->checkAdmin();
        
        $product = Product::create([
            'name' => $request->name,
            'brand' => $request->brand,
            'category' => $request->category,
            'price' => $request->price,
            'description' => $request->description,
            'status' => 'aktif',
        ]);
        
        // Buat stok default (size 42)
        ProductStock::create([
            'product_id' => $product->id,
            'size' => '42',
            'quantity' => $request->stock ?? 0,
        ]);
        
        return response()->json(['success' => true, 'id' => $product->id]);
    }
    
    // UPDATE STOK (via ProductStock)
    public function updateStock(Request $request, $stockId)
    {
        $this->checkAdmin();
        
        $stock = ProductStock::find($stockId);
        if (!$stock) {
            return response()->json(['success' => false, 'message' => 'Stok tidak ditemukan']);
        }
        
        $stock->quantity = (int) $request->quantity;
        $stock->save();
        
        return response()->json(['success' => true]);
    }
    
    // TOGGLE STATUS PRODUK
    public function toggleProductStatus(Request $request, $id)
    {
        $this->checkAdmin();
        
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['success' => false]);
        }
        
        $product->status = $request->status;
        $product->save();
        
        return response()->json(['success' => true]);
    }
    
    // HAPUS PRODUK
    public function deleteProduct($id)
    {
        $this->checkAdmin();
        
        $product = Product::find($id);
        if ($product) {
            // Stok akan terhapus otomatis karena cascade
            $product->delete();
        }
        
        return response()->json(['success' => true]);
    }
    
    // UPDATE STATUS PESANAN
    public function updateOrderStatus(Request $request, $orderId)
    {
        $this->checkAdmin();
        
        $order = Order::where('order_number', $orderId)->orWhere('id', $orderId)->first();
        if ($order) {
            $order->status = $request->status;
            $order->save();
        }
        
        return response()->json(['success' => true]);
    }
    
    // TOGGLE STATUS USER
    public function toggleUserStatus(Request $request, $id)
    {
        $this->checkAdmin();
        
        $user = User::find($id);
        if ($user && $user->role !== 'admin') {
            $user->status = $request->status;
            $user->save();
        }
        
        return response()->json(['success' => true]);
    }
}