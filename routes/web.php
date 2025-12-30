<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\StoreAuthController;
use App\Http\Controllers\StoreProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\StoreController;
use App\Models\Order;
use App\Models\Store;

// Homepage
Route::get('/', function () {
    return view('welcome');
});

// 🌐 Language switching
Route::get('/change-language/{lang}', function ($lang) {
    session(['locale' => $lang]);
    return back();
})->name('change.language');

// ======================== STORE SECTION ========================
// Store login/logout
// ✅ Store login/logout (Store section only)
Route::get('/store-login-redirect', fn () => redirect()->route('store.login'))->name('store.login.redirect');
Route::get('/store-login', [StoreAuthController::class, 'showLoginForm'])->name('store.login');
Route::post('/store-login', [StoreAuthController::class, 'login'])->name('store.login.submit');
Route::post('/store-logout', [StoreAuthController::class, 'logout'])->name('store.logout');

// ✅ Store dashboard
Route::get('/store-dashboard', function () {
    $storeId = session('tenant_id');
    if (!$storeId) {
        return redirect()->route('store.login')->withErrors(['Please log in first.']);
    }

    $store = Store::with('products')->find($storeId);
    $products = $store->products ?? collect();
    $orders = Order::with('products')->where('store_id', $storeId)->latest()->paginate(10);
    $categories = \App\Models\Category::all();

    return view('store.layouts.dashboard', compact('store', 'products', 'orders', 'categories'));
})->name('store.dashboard');

// ✅ Store Products
Route::get('/store-products', [StoreProductController::class, 'index'])->name('store-products.index');
Route::get('/store-products/create', [StoreProductController::class, 'create'])->name('store-products.create');
Route::post('/store-products', [StoreProductController::class, 'store'])->name('store-products.store');
Route::get('/store-products/{id}/edit', [StoreProductController::class, 'edit'])->name('store-products.edit');
Route::put('/store-products/{id}', [StoreProductController::class, 'update'])->name('store-products.update');
Route::delete('/store-products/{id}', [StoreProductController::class, 'destroy'])->name('store-products.destroy');

// ✅ Store Orders
Route::get('/store-orders', [StoreController::class, 'storeOrders'])->name('store-orders.index');
Route::post('/store-orders/{order}/status', [OrderController::class, 'updateStatus'])->name('store.orders.status');

// ✅ Categories Routes
Route::get('/store-categories', [CategoryController::class, 'index'])->name('store.categories.index');
Route::post('/store-categories', [CategoryController::class, 'store'])->name('store.categories.store');

// ✅ Store Sales Data
Route::get('/store-sales', [OrderController::class, 'getSalesData'])->name('store.sales.data');

// ✅ Store Settings
Route::put('/store/settings', [StoreController::class, 'updateSettings'])->name('store.settings.update');

// ✅ Store Chat System
Route::get('/store/orders/{order}/chat', [StoreController::class, 'chatWithUser'])->name('store.orders.chat');
Route::post('/store/orders/{order}/chat', [StoreController::class, 'sendChatMessage'])->name('store.orders.chat.send');
Route::get('/store/orders/{order}/messages', [StoreController::class, 'fetchMessages'])->name('store.orders.messages');

// ✅ Print Routes
Route::get('/store-order/{order}/export/pdf', [OrderController::class, 'exportPdf'])->name('store.order.export.pdf');
Route::get('/store-order/{order}/export/csv', [OrderController::class, 'exportCsv'])->name('store.order.export.csv');


// ======================== ADMIN SECTION ========================
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminGlobalSettingController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\StoreManagementController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminBannerController;
use App\Http\Controllers\Admin\AdminOrderApprovalController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\FinanceController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\LiveChatController;
use App\Http\Controllers\Admin\AdminNotificationController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Middleware\AdminMiddleware;

Route::get('/admin-login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin-login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin-logout', [AdminAuthController::class, 'logout'])->name('admin.logout');


Route::prefix('admin')
    ->name('admin.')
    ->middleware([AdminMiddleware::class])
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/users', [App\Http\Controllers\Admin\AdminUserController::class, 'index'])->name('users.index');
    Route::put('/users/{user}/toggle-status', [App\Http\Controllers\Admin\AdminUserController::class, 'toggleStatus'])->name('users.toggleStatus');
    Route::put('/users/{user}/update-role', [App\Http\Controllers\Admin\AdminUserController::class, 'updateRole'])->name('users.updateRole');
    Route::get('/users/{user}/orders', [App\Http\Controllers\Admin\AdminUserController::class, 'userOrders'])->name('users.orders');

    // ... (same for products, orders, settings, etc.)

    Route::get('/settings', [App\Http\Controllers\Admin\AdminGlobalSettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [App\Http\Controllers\Admin\AdminGlobalSettingController::class, 'update'])->name('settings.update');
    
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');

    Route::get('/settings', [AdminGlobalSettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [AdminGlobalSettingController::class, 'update'])->name('settings.update');

    Route::put('/users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggleStatus');
    Route::put('/users/{user}/update-role', [AdminUserController::class, 'updateRole'])->name('users.updateRole');
    Route::get('/users/{user}/orders', [AdminUserController::class, 'userOrders'])->name('users.orders');

    Route::get('/stores', [StoreManagementController::class, 'index'])->name('stores.index');
    Route::post('/stores', [StoreManagementController::class, 'store'])->name('stores.store');
    Route::get('/stores/{id}', [StoreManagementController::class, 'show'])->name('stores.show');
    Route::put('/stores/{id}/toggle', [StoreManagementController::class, 'toggleStatus'])->name('stores.toggle');
    Route::delete('/stores/{id}', [StoreManagementController::class, 'destroy'])->name('stores.destroy');

    Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
    Route::put('/products/{id}/approve', [AdminProductController::class, 'approve'])->name('products.approve');
    Route::put('/products/{id}/reject', [AdminProductController::class, 'reject'])->name('products.reject');
    Route::get('/products/export/{type}', [AdminProductController::class, 'export'])->name('products.export');
    Route::get('/products/{id}', [AdminProductController::class, 'show'])->name('products.show');

    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}/edit', [AdminCategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{id}', [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::delete('/orders/{id}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');
    Route::get('/orders/export/{type}', [AdminOrderController::class, 'export'])->name('orders.export');
    Route::post('/orders/{order}/approve', [AdminOrderApprovalController::class, 'approve'])->name('orders.approve');
    Route::post('/orders/{order}/reject', [AdminOrderApprovalController::class, 'reject'])->name('orders.reject');

    Route::resource('banners', AdminBannerController::class)->names('banners');
    Route::post('/banners/reorder', [AdminBannerController::class, 'reorder'])->name('banners.reorder');

    Route::get('/payment/settings', [PaymentController::class, 'paymentSettings'])->name('payment.settings');
    Route::post('/payment/settings/update', [PaymentController::class, 'updatePaymentSettings'])->name('payment.settings.update');

    Route::get('/pages', [PageController::class, 'index'])->name('pages.index');
    Route::get('/pages/{page}/edit', [PageController::class, 'edit'])->name('pages.edit');
    Route::put('/pages/{page}', [PageController::class, 'update'])->name('pages.update');

    Route::resource('reviews', ReviewController::class)->only(['index', 'edit', 'update', 'destroy']);
    Route::post('reviews/{review}/approve', [ReviewController::class, 'approve'])->name('reviews.approve');

    Route::get('finance', [FinanceController::class, 'index'])->name('finance.index');
    Route::post('finance/pay/{store}', [FinanceController::class, 'markAsPaid'])->name('finance.pay');

    Route::resource('coupons', CouponController::class)->only(['index', 'create', 'store', 'destroy']);

    Route::get('/livechat', [LiveChatController::class, 'index'])->name('livechat.index');
    Route::get('/livechat/{user}', [LiveChatController::class, 'show'])->name('livechat.show');
    Route::post('/livechat/{user}/reply', [LiveChatController::class, 'reply'])->name('livechat.reply');
    Route::post('/livechat/{user}/end', [LiveChatController::class, 'end'])->name('livechat.end');
    Route::get('/livechat/fetch', [LiveChatController::class, 'fetch'])->name('livechat.fetch');
    Route::get('/livechat/{user}/messages', [LiveChatController::class, 'messages'])->name('livechat.messages');

    Route::get('/notifications', [AdminNotificationController::class, 'create'])->name('notifications.create');
    Route::post('/notifications/send', [AdminNotificationController::class, 'send'])->name('notifications.send');


    
});

    