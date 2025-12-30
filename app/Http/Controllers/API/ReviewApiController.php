<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;

class ReviewApiController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'nullable|string',
    ]);

    $review = Review::create([
        'user_id' => auth()->id(),
        'product_id' => $request->product_id,
        'rating' => $request->rating,
        'comment' => $request->comment,
    ]);

    return response()->json(['success' => true, 'review' => $review], 201);
}

public function productReviews($productId)
{
    return Review::with('user')
        ->where('product_id', $productId)
        ->latest()
        ->get()
        ->map(function ($review) {
            return [
                'id' => $review->id,
                'user_id' => $review->user->id,
                'user_name' => $review->user->name,
                'rating' => $review->rating,
                'comment' => $review->comment,
                'created_at' => $review->created_at->toDateTimeString(),
            ];
        });
}

public function myReviews()
{
    $user = auth()->user();

    return Review::with('product', 'user')
        ->where('user_id', $user->id)
        ->orderBy('created_at', 'desc')
        ->get()
        ->map(function ($review) {
            return [
                'id' => $review->id,
                'user_id' => $review->user->id,
                'user_name' => $review->user->name,
                'product_id' => $review->product->id,
                'product_name' => $review->product->name,
                'product_image' => $review->product->image,
                'rating' => $review->rating,
                'comment' => $review->comment,
                'created_at' => $review->created_at->toDateTimeString(),
            ];
        });
}   


}
