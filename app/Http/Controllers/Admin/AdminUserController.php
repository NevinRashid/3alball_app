<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index(Request $request)
{
    $query = User::query();

    if ($request->filled('search')) {
        $search = $request->input('search');
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }

    $users = $query->latest()->paginate(15);
    return view('admin.users.index', compact('users'));
}


    public function toggleStatus(User $user)
    {
        $user->is_active = !$user->is_active;
        $user->save();

        return back()->with('success', 'User status updated.');
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate(['role' => 'required|in:admin,shop_owner,support,customer']);
        $user->role = $request->role;
        $user->save();

        return back()->with('success', 'User role updated.');
    }

    public function userOrders(User $user)
{
    $orders = $user->orders()->with('products', 'store')->latest()->get();

    if (request()->ajax()) {
        return view('admin.users.orders', compact('user', 'orders'))->render();
    }

    // Full page fallback
    return view('admin.users.orders', compact('user', 'orders'));
}

    
}


    
    


