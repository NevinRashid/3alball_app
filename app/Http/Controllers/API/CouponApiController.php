<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CouponApiController extends Controller
{
    public function index()
    {
        // Return list of available coupons (optional for listing)
        return response()->json(Coupon::where('is_active', true)->get());
    }

    public function apply(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string',
            'total' => 'required|numeric|min:0.01',
        ]);
    
        $coupon = Coupon::where('code', $request->coupon_code)
                        ->where('is_active', true)
                        ->first();
    
        if (!$coupon) {
            return response()->json(['message' => 'Invalid or expired coupon'], 404);
        }
    
        // User must be logged in
        $user = $request->user(); // works with Laravel Sanctum
    
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    
        // Check if user already used this coupon
        if ($coupon->users()->where('user_id', $user->id)->exists()) {
            return response()->json(['message' => 'You have already used this coupon'], 400);
        }
    
        // Expiry check
        if ($coupon->expires_at && now()->gt($coupon->expires_at)) {
            return response()->json(['message' => 'Coupon expired'], 400);
        }
    
        // Min order check
        if ($coupon->min_order_amount && $request->total < $coupon->min_order_amount) {
            return response()->json([
                'message' => 'Minimum order amount not reached',
                'required_minimum' => $coupon->min_order_amount
            ], 400);
        }
    
        // Calculate discount
        $discount = $coupon->type === 'percent'
            ? round($request->total * ($coupon->discount / 100), 2)
            : min($coupon->discount, $request->total);
    
        return response()->json([
            'discount_amount' => $discount,
            'code' => $coupon->code,
            'type' => $coupon->type,
            'original_discount' => $coupon->discount,
            'min_order_amount' => $coupon->min_order_amount,
            'expires_at' => $coupon->expires_at,
        ]);
    }
    
    }

