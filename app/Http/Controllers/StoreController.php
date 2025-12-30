<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use Illuminate\Http\Request;
use App\models\Message;

class StoreController extends Controller
{
    /**
     * Show the store dashboard with products, categories, orders, etc.
     */
    public function dashboard()
    {
        $tenantId = session('tenant_id');

        if (!$tenantId) {
            return redirect()->route('store.login')->withErrors('Please log in to access your store.');
        }

        // Fetch store data, products, orders, and categories
        $store = Store::with(['products', 'orders', 'categories'])->findOrFail($tenantId);

        return view('store.dashboard', [
            'store' => $store,
            'products' => $store->products,
            'orders' => $store->orders,
            'categories' => $store->categories
        ]);
    }

    /**
     * Show the store products in the store section
     */
    public function storeProducts()
    {
        $tenantId = session('tenant_id');
        if (!$tenantId) {
            return redirect()->route('store.login')->withErrors('Please log in to access your store.');
        }

        $products = Product::where('tenant_id', $tenantId)->paginate(10); // Paginate products for store
        return view('store.product.index', compact('products'));
    }

    /**
     * Show the store orders for the store owner
     */
    public function storeOrders()
    {
        $tenantId = session('tenant_id');
        if (!$tenantId) {
            return redirect()->route('store.login')->withErrors('Please log in to access your store.');
        }

        $orders = Order::where('tenant_id', $tenantId)->paginate(10);
        return view('store.order.index', compact('orders'));
    }
    public function updateSettings(Request $request)
{
    $storeId = session('tenant_id');
    $store = \App\Models\Store::findOrFail($storeId);

    $validated = $request->validate([
        'store_name' => 'required|string|max:255',
        'phone' => 'nullable|string|max:10',
        'address' => 'nullable|string|max:500',
        'logo' => 'nullable|image|max:2048', // Max 2MB
        'facebook' => 'nullable|url',
        'instagram' => 'nullable|url',
        'whatsapp' => 'nullable|string|max:20',
        'theme' => 'nullable|in:light,dark,auto',
    ]);

    // 🔁 Mass-assign fillable fields
    $store->fill([
        'store_name' => $validated['store_name'],
        'phone'      => $validated['phone'] ?? null,
        'address'    => $validated['address'] ?? null,
        'facebook'   => $validated['facebook'] ?? null,
        'instagram'  => $validated['instagram'] ?? null,
        'whatsapp'   => $validated['whatsapp'] ?? null,
        'theme'      => $validated['theme'] ?? 'light',
    ]);

    // 🖼 Upload logo if present
    if ($request->hasFile('logo')) {
        $store->logo = $request->file('logo')->store('stores', 'public');
    }

    // 🌗 Update session theme
    session(['store_theme' => $store->theme]);

    $store->save();

    return back()->with('success', 'Store profile updated successfully.');
}



public function chatWithUser(Order $order)
{
    $tenantId = session('tenant_id');

    if ($order->store_id !== $tenantId) {
        abort(403, 'Unauthorized access to this chat.');
    }

    $messages = $order->messages()->orderBy('created_at')->get();
    $store = Store::findOrFail($tenantId);

    return view('store.order.chat', [
        'order' => $order,
        'messages' => $messages,
        'store' => $store,

        // Add these to avoid "undefined variable" errors
        'products' => collect(),        // 👈 empty list
        'orders' => collect(),
        'categories' => collect(),
    ]);
}




public function sendChatMessage(Request $request, Order $order)
{
    $tenantId = session('tenant_id');

    if ($order->store_id !== $tenantId) {
        abort(403, 'Unauthorized message send.');
    }

    $request->validate([
        'message' => 'nullable|string|max:1000',
        'image' => 'nullable|image|max:2048', // 2MB limit
    ]);

    $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('chat_images', 'public');
    }

    Message::create([
        'order_id' => $order->id,
        'sender' => 'store',
        'message' => $request->message,
        'image' => $imagePath,
    ]);

    return redirect()->route('store.orders.chat', $order->id);
}
public function fetchMessages(Order $order)
{
    $tenantId = session('tenant_id');

    if ($order->store_id !== $tenantId) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    $messages = $order->messages()->orderBy('created_at')->get();

    return response()->json($messages);
}





}

