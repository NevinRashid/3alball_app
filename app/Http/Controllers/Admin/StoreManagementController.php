<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;

class StoreManagementController extends Controller
{
    public function index()
    {
        $stores = Store::withCount(['orders', 'products'])->get();

        return view('admin.layouts.dashboard', [
            'section' => 'stores',
            'stores' => $stores,
        ]);
    }

    public function create()
    {
        return view('admin.stores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'store_name' => 'required|string|max:255',
            'email' => 'required|email|unique:stores,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'password' => 'required|string|min:6',
        ]);

        Store::create([
            'store_name' => $request->store_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'status' => 'active',
            'theme' => 'light',
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('admin.dashboard', ['section' => 'stores'])
                         ->with('success', 'Store created successfully.');
    }

    public function show($id)
    {
        $store = Store::with(['orders', 'products'])->findOrFail($id);

        return view('admin.stores.show', compact('store'));
    }

    public function toggleStatus($id)
    {
        $store = Store::findOrFail($id);
        $store->status = $store->status === 'active' ? 'suspended' : 'active';
        $store->save();

        return redirect()->back()->with('success', 'Store status updated.');
    }

    public function destroy($id)
    {
        $store = Store::findOrFail($id);
        $store->delete();

        return redirect()->back()->with('success', 'Store deleted.');
    }

    public function resetPassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $store = Store::findOrFail($id);
        $store->password = bcrypt($request->password);
        $store->save();

        return redirect()->back()->with('success', 'Store password reset successfully.');
    }
}