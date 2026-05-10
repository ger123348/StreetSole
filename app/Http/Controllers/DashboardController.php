<?php

namespace App\Http\Controllers;

use App\Models\Product;

use App\Models\User;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;


class DashboardController extends Controller
{
    public function index(Request $request, string $role)
    {
        $role = in_array($role, ['admin', 'pembeli'], true) ? $role : 'pembeli';

        if ($role === 'admin') {
            $products = Product::query()
                ->select(['id', 'name', 'brand', 'category', 'price', 'description', 'rating', 'image_color', 'status'])
                ->withCasts(['price' => 'integer'])
                ->get()
                ->map(function ($p) {
                    return [
                        'id' => $p->id,
                        'nama' => $p->name,
                        'brand' => $p->brand,
                        'kategori' => $p->category,
                        'harga' => (int) $p->price,
                        'deskripsi' => $p->description,
                        'rating' => (float) $p->rating,
                        'imageColor' => $p->image_color,
                        'status' => $p->status === 'aktif' ? 'Aktif' : 'Nonaktif',
                        'stok' => 0, // stok dihitung dari product_stocks tidak dibutuhkan di admin blade untuk render dasar
                    ];
                });

            $users = User::query()
                ->select(['id', 'first_name', 'last_name', 'username', 'email', 'role', 'status', 'created_at'])
                ->orderByDesc('created_at')
                ->get()
                ->map(function ($u) {
                    return [
                        'id' => $u->id,
                        'nama' => trim(($u->first_name ?? '') . ' ' . ($u->last_name ?? '')),
                        'username' => $u->username,
                        'email' => $u->email,
                        'role' => $u->role,
                        'status' => ($u->status ?? 'aktif') === 'aktif' ? 'Aktif' : 'Nonaktif',
                        'bergabung' => optional($u->created_at)->format('d M Y') ?? '',
                    ];
                });

            $orders = Order::query()
                ->with('user')
                ->orderByDesc('created_at')
                ->limit(50)
                ->get()
                ->map(function ($o) {
                    return [
                        'id' => $o->order_number,
                        'produk' => ($o->orderItems()->first()->product_name ?? 'Produk'),
                        'pembeli' => trim(($o->user->first_name ?? '') . ' ' . ($o->user->last_name ?? '')),
                        'total' => (int) $o->total,
                        'status' => ucfirst($o->status),
                    ];
                });

            $reviews = Review::query()
                ->with(['user', 'product', 'order'])
                ->orderByDesc('created_at')
                ->limit(50)
                ->get()
                ->map(function ($r) {
                    return [
                        'id' => $r->id,
                        'produk' => $r->product_id ? ($r->product->name ?? $r->product_id) : 'Produk',
                        'user' => trim(($r->user->first_name ?? '') . ' ' . ($r->user->last_name ?? '')),
                        'rating' => (int) $r->rating,
                        'komentar' => $r->comment,
                        'tanggal' => optional($r->created_at)->format('d M Y') ?? '',
                    ];
                });

            return view('dashboard_admin', [
                'role' => $role,
                'products' => $products,
                'users' => $users,
                'orders' => $orders,
                'reviews' => $reviews,
            ]);
        }

        // pembeli
        $productsRaw = Product::query()
            ->where('status', 'aktif')
            ->select(['id', 'name', 'brand', 'category', 'price', 'description', 'rating', 'image_color', 'status'])
            ->get();

        $stocksByProduct = \DB::table('product_stocks')
            ->select(['product_id', 'size', 'quantity'])
            ->get()
            ->groupBy('product_id');

        // JS butuh format:
        // {id, name, brand, category, price, priceFormatted, rating, stock: {size: qty}, imageColor, desc}
        $products = $productsRaw->map(function ($p) use ($stocksByProduct) {
            $stock = [];
            foreach (($stocksByProduct[$p->id] ?? []) as $s) {
                $stock[(string)$s->size] = (int)$s->quantity;
            }

            return [
                'id' => $p->id,
                'name' => $p->name,
                'brand' => $p->brand,
                'category' => $p->category,
                'price' => (int) $p->price,
                'priceFormatted' => 'Rp ' . number_format((int) $p->price, 0, ',', '.'),
                'rating' => (float) $p->rating,
                'stock' => $stock,
                'imageColor' => $p->image_color,
                'desc' => $p->description,
            ];
        });


        return view('dashboard', [
            'role' => $role,
            'products' => $products,
        ]);
    }
}

