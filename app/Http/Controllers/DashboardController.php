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

            $reviewCount = Review::where('product_id', $product->id)->count();
            $avgRating = Review::where('product_id', $product->id)->avg('rating');
            
            $formattedProducts[] = [
                'id' => $product->id,
                'name' => $product->name,
                'brand' => $product->brand,
                'category' => $product->category,
                'price' => $product->price,
                'priceFormatted' => 'Rp ' . number_format($product->price, 0, ',', '.'),
                'rating' => $avgRating ? round($avgRating, 1) : 0,
                'reviewCount' => $reviewCount,
                'stock' => $stockArray,
                'imageColor' => $product->image_color ?? '#1a1a2e',
                'image' => $product->image ?? null,
                'desc' => $product->description ?? 'Produk berkualitas dari StreetSole',
            ];
        }
        
        $orders = Order::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        $reviews = Review::where('user_id', $user->id)->with('product')->get();

        // Stats for About page
        $totalProducts = Product::where('status', 'aktif')->count();
        $totalCustomers = User::where('role', 'pembeli')->count();
        $totalBrands = Product::where('status', 'aktif')->distinct('brand')->count('brand');

        return view('dashboard', [
            'user' => $user,
            'products' => $formattedProducts,
            'orders' => $orders,
            'reviews' => $reviews,
            'totalProducts' => $totalProducts,
            'totalCustomers' => $totalCustomers,
            'totalBrands' => $totalBrands,
        ]);
    }
}