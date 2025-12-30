<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;
use App\Models\Coupon;

class OrderApiController extends Controller
{
    public function store(Request $request)
{
    Log::info('Incoming Multi-Store Order Request:', $request->all());

    $validator = Validator::make($request->all(), [
        'products' => 'required|array',
        'products.*.product_id' => 'required|exists:products,id',
        'products.*.quantity' => 'required|integer|min:1',
        'recipient_name' => 'required|string',
        'recipient_phone' => 'required|string',
        'recipient_address' => 'required|string',
        'delivery_date' => 'required|date',
        'delivery_time' => 'required|string',
        'coupon_code' => 'nullable|string',
        'discount_amount' => 'nullable|numeric',
        'gift_message' => 'nullable|string|max:1000',
        'payment_method' => 'required|in:cliq,apple_pay,credit_card',
        'payment_proof' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        'total_price' => 'required|numeric',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors(),
        ], 422);
    }

    $user = $request->user();

    // Upload proof once
    $paymentProofPath = null;
    if ($request->hasFile('payment_proof')) {
        $paymentProofPath = $request->file('payment_proof')->store('uploads/payment_proofs', 'public');
    }

    // Group products by store_id
    $grouped = [];
    foreach ($request->products as $item) {
        $product = \App\Models\Product::find($item['product_id']);
        $grouped[$product->store_id][] = [
            'product' => $product,
            'quantity' => $item['quantity'],
        ];
    }

    $orders = [];

    foreach ($grouped as $storeId => $items) {
        $subTotal = 0;
        foreach ($items as $item) {
            $subTotal += $item['product']->price * $item['quantity'];
        }

        $commission = $subTotal * 0.10;
        $storeEarnings = $subTotal - $commission;

        $order = $user->orders()->create([
            'store_id' => $storeId,
            'recipient_name' => $request->recipient_name,
            'recipient_phone' => $request->recipient_phone,
            'recipient_address' => $request->recipient_address,
            'delivery_date' => $request->delivery_date,
            'delivery_time' => $request->delivery_time,
            'total_price' => $subTotal,
            'coupon_code' => $request->coupon_code,
            'discount_amount' => $request->discount_amount,
            'gift_message' => $request->gift_message,
            'payment_method' => $request->payment_method,
            'payment_status' => 'pending',
            'payment_proof' => $paymentProofPath,
            'admin_commission' => $commission,
            'store_earnings' => $storeEarnings,
            'status' => 'pending',
        ]);

        // Apply coupon (optional)
        if ($request->coupon_code) {
            $coupon = Coupon::where('code', $request->coupon_code)->first();
            if ($coupon) {
                $coupon->users()->syncWithoutDetaching($user->id);
            }
        }

        // Attach products
        foreach ($items as $item) {
            $order->products()->attach($item['product']->id, [
                'quantity' => $item['quantity'],
            ]);
        }

        $orders[] = $order->load('products');
    }

    return response()->json([
        'success' => true,
        'orders' => $orders,
    ], 201);
}


       
    public function index()
    {
        $orders = Order::with('products')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();
    
        foreach ($orders as $order) {
            $items = [];
            foreach ($order->products as $product) {
                $items[] = [
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $product->pivot->quantity,
                ];
            }
    
            $order->items = $items;
    
            // 🔁 Custom status text for display in Flutter
            $order->status_text = match ($order->status) {
                'pending'       => 'Awaiting Approval',
                'approved'      => 'Approved (Not visible)',
                'rejected'      => 'Rejected',
                'order_placed'  => 'Order Placed',
                'order_packed'  => 'Order Packed',
                'on_the_way'    => 'On The Way',
                'delivered'     => 'Delivered',
                default         => ucfirst(str_replace('_', ' ', $order->status)),
            };
        }
    
        return response()->json($orders->map(function ($order) {
            return [
                'id' => $order->id,
                'status' => $order->status,
                'delivery_date' => $order->delivery_date,
                'delivery_time' => $order->delivery_time,
                'total_price' => $order->total_price,
                'coupon_code' => $order->coupon_code,
                'discount_amount' => $order->discount_amount,
                'payment_method' => $order->payment_method,
                'reference_code' => $order->reference_code,
                'payment_proof' => $order->payment_proof,
                'recipient_name' => $order->recipient_name,
                'recipient_phone' => $order->recipient_phone,
                'recipient_address' => $order->recipient_address,
                'gift_message' => $order->gift_message,
                'store_id' => $order->store_id,
                'items' => $order->items,
                'status_text' => $order->status_text,
            ];
        }));
    }
    
}
