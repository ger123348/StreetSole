<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductStock;
use App\Models\Order;
use App\Models\User;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard(Request $request, $role = null)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $user = Auth::user();
        
        if ($role && $user->role !== $role) {
            return redirect()->route('dashboard', ['role' => $user->role]);
        }
        
        $activeRole = $role ?? $user->role;
        
        if ($activeRole === 'admin') {
            return $this->adminDashboard();
        }
        
        return $this->userDashboard();
    }
    
    public function adminDashboard()
    {
        $user = Auth::user();
        
        // Ambil produk dengan relasi stocks
        $products = Product::with('stocks')->get();
        $users = User::all();
        $orders = Order::with('user')->orderBy('created_at', 'desc')->get();
        $reviews = Review::with(['user', 'product'])->orderBy('created_at', 'desc')->get();
        
        $data = [
            'user' => $user,
            'totalSales' => Order::sum('total') ?? 0,
            'pendingOrders' => Order::where('status', 'paid')->count(),
            'totalProducts' => Product::count(),
            'recentOrders' => Order::with('user')->latest()->take(5)->get(),
            'products' => $products,
            'users' => $users,
            'orders' => $orders,
            'reviews' => $reviews,
        ];
        
        return view('dashboard_admin', $data);
    }
    
    public function userDashboard()
    {
        $user = Auth::user();
        $products = Product::where('status', 'aktif')->get();
        
        $formattedProducts = [];
        
        foreach ($products as $product) {
            $stocks = ProductStock::where('product_id', $product->id)->get();
            $stockArray = [];
            foreach ($stocks as $stock) {
                $stockArray[$stock->size] = $stock->quantity;
            }
            
            $formattedProducts[] = [
                'id' => $product->id,
                'name' => $product->name,
                'brand' => $product->brand,
                'category' => $product->category,
                'price' => $product->price,
                'priceFormatted' => 'Rp ' . number_format($product->price, 0, ',', '.'),
                'rating' => $product->rating ?? 4.5,
                'stock' => $stockArray,
                'imageColor' => $product->image_color ?? '#1a1a2e',
                'desc' => $product->description ?? 'Produk berkualitas dari StreetSole',
            ];
        }
        
        return view('dashboard', [
            'user' => $user,
            'products' => $formattedProducts
        ]);
    }
}