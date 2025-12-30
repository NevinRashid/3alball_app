<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with('product', 'user')->latest()->paginate(15);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function edit($id)
    {
        $review = Review::findOrFail($id);
        return view('admin.reviews.edit', compact('review'));
    }

    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);
        $review->comment = $request->comment;
        $review->rating = $request->rating;
        $review->save();

        return redirect()->route('admin.reviews.index')->with('success', 'Review updated!');
    }

    public function destroy($id)
    {
        Review::destroy($id);
        return back()->with('success', 'Review deleted.');
    }
}

