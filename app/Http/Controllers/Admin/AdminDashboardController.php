<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use App\Models\Banner;
use App\Models\GlobalSetting;
use App\Models\Payment;
use App\Models\Page;
use App\Models\Review;
use App\Models\Coupon;
use App\Models\Message;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $section = $request->get('section', 'overview');
        $sub = $request->get('sub', null);

        $stores = Store::withCount(['orders', 'products'])->get();

        $orders = null;
        if ($section === 'orders') {
            $orders = Order::with(['user', 'store'])
                ->where('payment_method', 'cliq')
                ->where('payment_status', 'pending')
                ->latest()
                ->paginate(10);
        }

        $products = null;
        if ($section === 'products') {
            $products = Product::with('store')->latest()->paginate(10);
        }

        $categories = null;
        if ($section === 'categories') {
            $categories = Category::latest()->paginate(10);
        }

        $users = null;
        if ($section === 'users') {
            $users = User::latest()->paginate(15);
        }

        $banners = null;
        if ($section === 'banners') {
            $banners = Banner::latest()->paginate(10);
        }

        $settings = null;
        if ($section === 'settings') {
            $settings = GlobalSetting::first();
        }

        $payments = null;
        if ($section === 'payment') {
            $payments = Payment::with(['user', 'store'])->latest()->paginate(15);
        }

        if ($section === 'payment-settings') {
            $settings = GlobalSetting::firstOrCreate([]);
        }

        $pages = null;
        if ($section === 'pages') {
            $pages = Page::all();
        }

        $reviews = null;
        if ($section === 'reviews') {
            $reviews = Review::with('product', 'user')->latest()->paginate(15);
        }

        if ($section === 'finance') {
            return redirect()->route('admin.finance.index');
        }

        $coupons = null;
        if ($section === 'coupons') {
            $coupons = Coupon::latest()->paginate(10);
        }

        $chats = null;
        if ($section === 'livechat') {
            $chats = Message::latest()->get();
        }
        $notifications = null;
        if ($section === 'notifications') {
        $notifications = []; // We'll later make it fetch from DB if you want, for now just empty
                    }


        $weeklySales = [];
        $weeklyLabels = [];
        $startOfWeek = \Carbon\Carbon::now()->startOfWeek();
                    
        for ($i = 0; $i < 7; $i++) {
        $day = $startOfWeek->copy()->addDays($i);
        $label = $day->format('D');
                    
        $amount = \App\Models\Order::whereDate('created_at', $day)
         ->where('payment_status', 'approved')
         ->whereNotNull('payment_method')
         ->sum('total_price');
                    
        $weeklyLabels[] = $label;
         $weeklySales[] = $amount;
                    }
                    
        $monthlyStoreLabels = [];
        $monthlyStoreCounts = [];

        for ($i = 1; $i <= 6; $i++) {
            $month = Carbon::now()->subMonths(6 - $i);
            $label = $month->format('M');
            $count = Store::whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->count();

            $monthlyStoreLabels[] = $label;
            $monthlyStoreCounts[] = $count;
        }

        return view('admin.layouts.dashboard', [
            'section' => $section,
            'sub' => $sub,
            'stores' => $stores,
            'products' => $products,
            'orders' => $orders,
            'users' => $users,
            'storeCount' => $stores ? $stores->count() : Store::count(),
            'totalOrders' => $stores ? $stores->sum('orders_count') : Order::count(),
            'totalSales' => \App\Models\Order::whereNotNull('payment_method')
            ->where('payment_status', 'approved')
            ->sum('total_price'),
            'userCount' => User::count(),
            'pendingProducts' => Product::where('status', 'pending')->count(),
            'categories' => $categories,
            'banners' => $banners,
            'settings' => $settings,
            'payments' => $payments,
            'pages' => $pages ?? collect(),
            'reviews' => $reviews,
            'coupons' => $coupons,
            'weeklySales' => $weeklySales,
            'weeklyLabels' => $weeklyLabels,
            'monthlyStoreLabels' => $monthlyStoreLabels,
            'monthlyStoreCounts' => $monthlyStoreCounts,
            'chats' => $chats,
            'notifications' => $notifications,
            
        ]);
    }

    public function create()
    {
        return view('admin.stores.create');
    }
}