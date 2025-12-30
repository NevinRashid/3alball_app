<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories for the store.
     */
    public function index()
    {
        $storeId = session('tenant_id');
        if (!$storeId) {
            return redirect()->route('store.login')->withErrors('Please log in to access your store.');
        }

        $categories = Category::where('store_id', $storeId)->latest()->get();

        return view('store.sections.categories', compact('categories'));
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $storeId = session('tenant_id');
        if (!$storeId) {
            return redirect()->route('store.login')->withErrors('Please log in to access your store.');
        }

        Category::create([
            'store_id' => $storeId,
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Category added successfully.');
    }

    /**
     * Remove the specified category.
     */
    public function destroy(Category $category)
    {
        $storeId = session('tenant_id');

        // Only delete if category belongs to logged-in store
        if ($category->store_id == $storeId) {
            $category->delete();
            return redirect()->back()->with('success', 'Category deleted.');
        }

        return redirect()->back()->withErrors('Unauthorized action.');
    }
}
