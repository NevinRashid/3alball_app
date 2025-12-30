<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use Illuminate\Support\Facades\Hash;

class StoreAuthController extends Controller
{
    public function showLoginForm()
    {
        // Load the login page (store/auth/login.blade.php)
        return view('store.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);
    
        $store = Store::where('email', $request->email)->first();
    
        if (!$store || !Hash::check($request->password, $store->password)) {
            return back()->withErrors(['email' => 'Invalid credentials.']);
        }
    
        // ✅ Check if the store is active
        if ($store->status !== 'active') {
            return back()->withErrors([
                'email' => $store->status === 'pending'
                    ? 'Your store is waiting for admin approval.'
                    : 'Your store has been suspended.'
            ]);
        }
    
        // ✅ All good — store in session
        session(['tenant_id' => $store->id]);
    
        return redirect()->route('store.dashboard');
    }
    
    
    

    public function logout(Request $request)
    {
        $request->session()->forget('tenant_id');
        return redirect()->route('store.login')->with('success', 'Logged out successfully.');
    }
}
