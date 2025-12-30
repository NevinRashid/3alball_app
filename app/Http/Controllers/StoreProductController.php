<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreProductController extends Controller
{
    // Show the main store dashboard with products, orders, and categories
    public function index()
    {
        $tenantId = session('tenant_id');
        if (!$tenantId) {
            return redirect()->route('store.login')->withErrors('Please log in to access your store.');
        }

        $store = Store::with(['products', 'orders'])->findOrFail($tenantId);
        $categories = Category::where('store_id', $tenantId)->get();

        return view('store.layouts.dashboard', [
            'store' => $store,
            'products' => $store->products,
            'orders' => $store->orders,
            'categories' => $categories
        ]);
    }

    // Show the form to create a new product
    public function create()
    {
        $tenantId = session('tenant_id');
        if (!$tenantId) {
            return redirect()->route('store.login')->withErrors('Please log in to access your store.');
        }

        $categories = Category::where('store_id', $tenantId)->get();
        return view('store.product.create', compact('categories'));
    }

    // Store a newly created product
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:pending,approved',
            'image' => 'nullable|image|mimes:jpg,jpeg,png'
        ]);

        $storeId = session('tenant_id');
        $store = Store::find($storeId);

        if (!$store) {
            return redirect()->route('store.login')->withErrors('Store not found. Please log in again.');
        }

        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->category_id = $request->category_id;
        $product->status = $request->status;
        $product->store_id = $store->id;

        if ($request->hasFile('image')) {
            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->save();

        return redirect()->route('store-products.index')->with('success', 'Product added successfully!');
    }

    // Edit an existing product
    public function edit($id)
    {
        $tenantId = session('tenant_id');
        if (!$tenantId) {
            return redirect()->route('store.login')->withErrors('Please log in to access your store.');
        }

        $product = Product::where('store_id', $tenantId)->findOrFail($id);
        $categories = Category::where('store_id', $tenantId)->get();

        return view('store.product.edit', compact('product', 'categories'));
    }

    // Update an existing product
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:pending,approved'
        ]);

        $tenantId = session('tenant_id');
        if (!$tenantId) {
            return redirect()->route('store.login')->withErrors('Please log in to access your store.');
        }

        $product = Product::where('store_id', $tenantId)->findOrFail($id);
        $product->fill($request->only(['name', 'description', 'price', 'stock', 'category_id', 'status']));

        if ($request->hasFile('image')) {
            $product->image = $request->file('image')->store('products', 'public');
        }
        
        

        $product->save();

        return redirect()->route('store-products.index')->with('success', 'Product updated successfully!');
    }

    // Delete a product
    public function destroy($id)
    {
        $tenantId = session('tenant_id');
        if (!$tenantId) {
            return redirect()->route('store.login')->withErrors('Please log in to access your store.');
        }

        $product = Product::where('store_id', $tenantId)->findOrFail($id);
        $product->delete();

        return redirect()->route('store-products.index')->with('success', 'Product deleted successfully!');
    }
}
