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
        
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }
        
        $product = Product::create([
            'name' => $request->name,
            'brand' => $request->brand,
            'category' => $request->category,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $imagePath,
            'status' => 'aktif',
        ]);
        
        // Handle Stocks
        if ($request->has('stocks')) {
            $stocks = json_decode($request->stocks, true);
            foreach ($stocks as $s) {
                ProductStock::create([
                    'product_id' => $product->id,
                    'size' => $s['size'],
                    'quantity' => $s['quantity'],
                ]);
            }
        } else {
            // Default stock if none provided
            ProductStock::create([
                'product_id' => $product->id,
                'size' => '42',
                'quantity' => $request->stock ?? 0,
            ]);
        }
        
        return response()->json(['success' => true, 'id' => $product->id]);
    }
    
    // UPDATE PRODUK (Info + Image + Stocks)
    public function updateProduct(Request $request, $id)
    {
        $this->checkAdmin();
        
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan']);
        }
        
        $product->name = $request->name;
        $product->brand = $request->brand;
        $product->category = $request->category;
        $product->price = $request->price;
        $product->description = $request->description;
        
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $product->image = $path;
        }
        
        $product->save();
        
        if ($request->has('stocks')) {
            $stocks = json_decode($request->stocks, true);
            $existingSizes = [];
            
            foreach ($stocks as $s) {
                $existingSizes[] = $s['size'];
                ProductStock::updateOrCreate(
                    ['product_id' => $product->id, 'size' => $s['size']],
                    ['quantity' => $s['quantity']]
                );
            }
            
            // Optional: Delete sizes not in the request
            // ProductStock::where('product_id', $product->id)->whereNotIn('size', $existingSizes)->delete();
        }
        
        return response()->json(['success' => true]);
    }
    
    // DELETE STOCK SIZE
    public function deleteStockSize(Request $request, $id)
    {
        $this->checkAdmin();
        $stock = ProductStock::where('product_id', $id)->where('size', $request->size)->first();
        if ($stock) {
            $stock->delete();
        }
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