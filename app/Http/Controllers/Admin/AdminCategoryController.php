<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('categories', 'public');
        }

        Category::create([
            'name' => $request->name,
            'image' => $path,
        ]);

        return back()->with('success', 'Category added successfully.');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

   
public function update(Request $request, $id)
{
    $category = Category::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'image' => 'nullable|image|max:2048',
    ]);

    $category->name = $request->name;

    if ($request->hasFile('image')) {
        // 🔥 Delete old image if exists
        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }

        // Upload new image
        $path = $request->file('image')->store('categories', 'public');
        $category->image = $path;
    }

    $category->save();

    return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
}


    public function destroy($id)
    {
        Category::findOrFail($id)->delete();
        return back()->with('success', 'Category deleted successfully.');
    }
}
