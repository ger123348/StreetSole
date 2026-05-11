<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Cek login
            if (!Auth::check()) {
                return response()->json(['success' => false, 'message' => 'Harap login'], 401);
            }

            // Validasi
            $request->validate([
                'order_id' => 'required|string',
                'product_id' => 'required|integer',
                'rating' => 'required|integer|min:1|max:5',
                'comment' => 'nullable|string',
            ]);

            // Cek apakah sudah pernah review
            $existing = Review::where('user_id', Auth::id())
                ->where('order_id', $request->order_id)
                ->where('product_id', $request->product_id)
                ->first();

            if ($existing) {
                return response()->json(['success' => false, 'message' => 'Anda sudah memberikan review untuk produk ini']);
            }

            // Simpan review
            $review = Review::create([
                'user_id' => Auth::id(),
                'order_id' => $request->order_id,
                'product_id' => $request->product_id,
                'rating' => $request->rating,
                'comment' => $request->comment ?? '',
            ]);

            return response()->json(['success' => true, 'review' => $review]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function index()
    {
        $reviews = Review::with(['user', 'product'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($review) {
                return [
                    'id' => $review->id,
                    'user_name' => trim(($review->user->first_name ?? '') . ' ' . ($review->user->last_name ?? '')),
                    'product_name' => $review->product->name ?? 'Produk',
                    'rating' => $review->rating,
                    'comment' => $review->comment,
                    'created_at' => $review->created_at,
                ];
            });

        return response()->json($reviews);
    }
}