<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Ambil semua cart user
    public function index()
    {
        $cart = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get()
            ->map(function($item) {
                $product = $item->product;
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'brand' => $product->brand,
                    'category' => $product->category,
                    'price' => $product->price,
                    'priceFormatted' => 'Rp ' . number_format($product->price, 0, ',', '.'),
                    'rating' => $product->rating,
                    'stock' => [], // akan diisi dari product_stocks jika diperlukan
                    'imageColor' => $product->image_color,
                    'image' => $product->image,
                    'desc' => $product->description,
                    'size' => $item->size,
                    'qty' => $item->quantity,
                    'cart_id' => $item->id,
                ];
            });
        
        return response()->json($cart);
    }

    // Tambah ke keranjang
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'size' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        // Cek apakah sudah ada di cart
        $existing = Cart::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->where('size', $request->size)
            ->first();

        if ($existing) {
            // Update quantity
            $existing->quantity += $request->quantity;
            $existing->save();
            $cartItem = $existing;
        } else {
            // Buat baru
            $cartItem = Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'size' => $request->size,
                'quantity' => $request->quantity,
            ]);
        }

        // Ambil product untuk response
        $product = Product::find($request->product_id);

        return response()->json([
            'success' => true,
            'cart' => [
                'id' => $product->id,
                'name' => $product->name,
                'brand' => $product->brand,
                'category' => $product->category,
                'price' => $product->price,
                'priceFormatted' => 'Rp ' . number_format($product->price, 0, ',', '.'),
                'imageColor' => $product->image_color,
                'image' => $product->image,
                'size' => $cartItem->size,
                'qty' => $cartItem->quantity,
                'cart_id' => $cartItem->id,
            ]
        ]);
    }

    // Update quantity
    public function update(Request $request, $cartId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::where('id', $cartId)
            ->where('user_id', Auth::id())
            ->first();

        if (!$cart) {
            return response()->json(['success' => false, 'message' => 'Item tidak ditemukan'], 404);
        }

        $cart->quantity = $request->quantity;
        $cart->save();

        return response()->json(['success' => true]);
    }

    // Hapus dari keranjang
    public function destroy($cartId)
    {
        $cart = Cart::where('id', $cartId)
            ->where('user_id', Auth::id())
            ->first();

        if (!$cart) {
            return response()->json(['success' => false, 'message' => 'Item tidak ditemukan'], 404);
        }

        $cart->delete();

        return response()->json(['success' => true]);
    }

    // Kosongkan keranjang (setelah checkout)
    public function clear()
    {
        Cart::where('user_id', Auth::id())->delete();
        return response()->json(['success' => true]);
    }
}