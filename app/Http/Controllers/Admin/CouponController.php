<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->paginate(10);
        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:coupons,code',
            'discount' => 'required|numeric|min:0.01',
            'type' => 'required|in:percent,fixed',
            'min_order_amount' => 'nullable|numeric|min:0',
            'expires_at' => 'nullable|date',
        ]);

        Coupon::create([
            'code' => $request->code,
            'discount' => $request->discount,
            'type' => $request->type,
            'min_order_amount' => $request->min_order_amount,
            'expires_at' => $request->expires_at,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.coupons.index')->with('success', '🎉 Coupon created successfully!');
    }

    public function destroy($id)
    {
        Coupon::destroy($id);
        return back()->with('success', '🗑️ Coupon deleted.');
    }
}

