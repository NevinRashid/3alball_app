<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryApiController extends Controller
{
    public function index()
    {
        $categories = Category::all()->map(function ($cat) {
            return [
                'id' => $cat->id,
                'name' => $cat->name,
                'image' => $cat->image ? asset('storage/' . $cat->image) : null,
            ];
        });

        return response()->json($categories); // ✅ FIXED
    }
}
