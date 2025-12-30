<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    // ✅ 1. Get all approved products with full image URLs
    public function index()
    {
        $products = Product::where('status', 'approved')->latest()->get();

        $transformed = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'stock' => $product->stock,
                'store_id' => $product->store_id,
                'image' => $product->image ? asset('storage/' . $product->image) : null,
            ];
        });

        return response()->json([
            'success' => true,
            'products' => $transformed,
        ]);
    }

    // ✅ 2. Get product by ID
    public function show($id)
    {
        $product = Product::find($id);

        if (!$product || $product->status !== 'approved') {
            return response()->json(['success' => false, 'message' => 'Product not found'], 404);
        }

        $product->image = $product->image ? asset('storage/' . $product->image) : null;

        return response()->json(['success' => true, 'product' => $product]);
    }

    // ✅ 3. Get products by category
    public function getByCategory($categoryId)
    {
        $products = Product::where('category_id', $categoryId)
            ->where('status', 'approved')
            ->latest()
            ->get();

        $transformed = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'stock' => $product->stock,
                'store_id' => $product->store_id,
                'image' => $product->image ? asset('storage/' . $product->image) : null,
            ];
        });

        return response()->json([
            'success' => true,
            'products' => $transformed,
        ]);
    }
}
