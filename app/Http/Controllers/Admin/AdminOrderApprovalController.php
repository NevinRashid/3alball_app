<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderApprovalController extends Controller
{
    public function approve(Order $order)
    {
        $order->payment_status = 'approved';
        $order->save();

        return back()->with('success', '✅ Payment approved successfully.');
    }

    public function reject(Order $order)
    {
        $order->payment_status = 'rejected';
        $order->save();

        return back()->with('success', '❌ Payment rejected.');
    }
}
