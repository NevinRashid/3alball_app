<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Order;
use App\Models\StorePayout;

class FinanceController extends Controller
{
    /**
     * Show store finance data (total sales, 10% commission, and paid status).
     */
    public function index()
    {
        $data = Store::all()->map(function ($store) {
            // Total earned from approved orders
            $totalSales = $store->orders()
                ->where('payment_status', 'approved')
                ->sum('total_price');
        
            // Total paid to store
            $totalPaid = $store->payouts()->sum('amount');
        
            // Commission (e.g. 10%)
            $commission = $totalSales * 0.10;
        
            // Remaining balance (what's left to pay the store)
            $remaining = $totalSales - $totalPaid;
        
            return [
                'store' => $store,
                'total_sales' => $totalSales,
                'commission' => $commission,
                'paid_amount' => $totalPaid,
                'remaining' => $remaining,
            ];
        });
        
        

        return view('admin.finance.index', compact('data'));
    }

    /**
     * Mark a store's commission as paid.
     */
    

    public function markAsPaid(Request $request, $storeId)
    {
        StorePayout::create([
            'store_id' => $storeId,
            'amount' => $request->amount,
            'commission' => $request->commission,
            'note' => 'Auto payout for remaining balance',
            'admin_id' => auth()->id(),
            'paid_at' => now(),
        ]);
    
        return back()->with('success', 'Remaining amount paid.');
    }
    

}
