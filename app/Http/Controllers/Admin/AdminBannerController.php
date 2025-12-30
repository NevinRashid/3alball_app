<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\Storage;

class AdminBannerController extends Controller
{
    public function index()
    {
        $banners = Banner::latest()->paginate(10);
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'required|image|max:2048',
            'target_type' => 'required|in:product,store,category,url',
            'target_value' => 'required|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_campaign' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',

        ]);

        $data['image'] = $request->file('image')->store('banners', 'public');
        $data['is_campaign'] = $request->has('is_campaign') ? 1 : 0;
        $data['is_active'] = $request->has('is_active') ? 1 : 0;


        Banner::create($data);

        return redirect()->route('admin.banners.index')->with('success', '✅ Banner added successfully.');
    }

    public function show(string $id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.banners.show', compact('banner'));
    }

    public function edit(string $id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, string $id)
{
    $banner = Banner::findOrFail($id);

    $data = $request->validate([
        'title' => 'nullable|string|max:255',
        'image' => 'nullable|image|max:2048',
        'target_type' => 'required|in:product,store,category,url',
        'target_value' => 'required|string',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
        'is_active' => 'nullable|boolean',
        // ⛔️ is_campaign is NOT in validation — that's fine as we handle it manually below
    ]);

    if ($request->hasFile('image')) {
        Storage::disk('public')->delete($banner->image);
        $data['image'] = $request->file('image')->store('banners', 'public');
    }

    // ✅ Fix: Add this to persist checkbox states
    $data['is_active'] = $request->has('is_active') ? 1 : 0;
    $data['is_campaign'] = $request->has('is_campaign') ? 1 : 0;

    $banner->update($data);

    return redirect()->route('admin.banners.index')->with('success', '✅ Banner updated successfully.');
}

    public function destroy(string $id)
    {
        $banner = Banner::findOrFail($id);
        Storage::disk('public')->delete($banner->image);
        $banner->delete();

        return redirect()->route('admin.banners.index')->with('success', '🗑️ Banner deleted successfully.');
    }

    public function reorder(Request $request)
    {
        foreach ($request->positions as $position => $id) {
            Banner::where('id', $id)->update(['position' => $position]);
        }

        return response()->json(['success' => true]);
    }
}
