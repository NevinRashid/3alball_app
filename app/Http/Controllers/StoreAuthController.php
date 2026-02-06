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

    // EN + AR messages
    $invalidMsg = "Invalid email or password.\nالبريد الإلكتروني أو كلمة المرور غير صحيحة";

    $pendingMsg = "Your store is waiting for admin approval.\nمتجرك بانتظار موافقة الإدارة";
    $suspendedMsg = "Your store has been suspended.\nتم إيقاف متجرك مؤقتًا";

    $store = Store::where('email', $request->email)->first();

    // generic invalid for email OR password
    if (!$store || !Hash::check($request->password, $store->password)) {
        return $request->expectsJson()
            ? response()->json(['message' => $invalidMsg], 401)
            : back()->withErrors(['email' => $invalidMsg]);
    }

    // Status check
    if ($store->status !== 'active') {
        $msg = $store->status === 'pending' ? $pendingMsg : $suspendedMsg;

        return $request->expectsJson()
            ? response()->json(['message' => $msg], 403)
            : back()->withErrors(['email' => $msg]);
    }

    // all good, store in session
    session(['tenant_id' => $store->id]);

    return $request->expectsJson()
        ? response()->json(['redirect' => route('store.dashboard')])
        : redirect()->route('store.dashboard');
}


    public function logout(Request $request)
    {
        $request->session()->forget('tenant_id');
        return redirect()->route('store.login')->with('success', 'Logged out successfully.');
    }
}
