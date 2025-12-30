<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Store;
use App\Models\User;
use App\Models\Notification;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Http;
use App\Models\UserMessage;

class OrderController extends Controller
{
    public function storeOrders(Request $request)
    {
        $storeId = session('tenant_id');
        if (!$storeId) {
            return redirect()->route('store.login')->withErrors('Please log in to access your store.');
        }

        $store = Store::with('products')->find($storeId);
        $products = $store->products ?? collect();

        $orders = Order::with('product')
            ->where('store_id', $storeId)
            ->whereIn('status', ['order_placed', 'order_packed', 'on_the_way', 'delivered']) 
            ->when($request->filled('status'), fn($q) => $q->where('status', $request->status))
            ->when($request->filled('date'), fn($q) => $q->whereDate('created_at', $request->date))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('store.order.index', compact('orders', 'store', 'products'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $storeId = session('tenant_id');
        if ($order->store_id != $storeId) {
            abort(403);
        }
        if (!in_array($order->status, ['order_placed', 'order_packed', 'on_the_way'])) {
            return back()->withErrors('You can only update active orders.');
        }
        

        $request->validate([
            'status' => 'required|in:order_placed,order_packed,on_the_way,delivered'
        ]);
        

        $order->status = $request->status;
        $order->save();

        // 🔔 Create Notification
        Notification::create([
            'title' => 'Order Update: ' . str_replace('_', ' ', ucfirst($order->status)),
            'body' => 'Your order #' . $order->id . ' is now ' . str_replace('_', ' ', $order->status),
            'type' => 'order',
            'user_id' => $order->user_id,
            'order_id' => $order->id,
        ]);

        // 🔥 Send FCM Push via Firebase v1 HTTP API
        $user = User::find($order->user_id);
        if ($user && $user->fcm_token) {
            $token = $this->generateAccessToken(base_path(env('FIREBASE_CREDENTIALS')));
            $projectId = env('FIREBASE_PROJECT_ID');

            Http::withToken($token)->post("https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send", [
                'message' => [
                    'token' => $user->fcm_token,
                    'notification' => [
                        'title' => 'Order Update: ' . str_replace('_', ' ', ucfirst($order->status)),
                        'body' => 'Your order #' . $order->id . ' is now ' . str_replace('_', ' ', $order->status),
                    ],
                    'data' => [
                        'type' => 'order',
                        'order_id' => (string) $order->id,
                    ]
                ]
            ]);
        }
        UserMessage::create([
            'user_id' => $order->user_id,
            'title' => 'Order ' . ucfirst($order->status),
            'body' => "Your order #{$order->id} status is now: {$order->status}.",
            'type' => 'order',
            'related_order_id' => $order->id,
            'sent_by' => 'system',
        ]);

        return back()->with('success', 'Order status updated!');
    }

    private function generateAccessToken($jsonPath)
    {
        $json = json_decode(file_get_contents($jsonPath), true);
        $now = time();
        $header = ['alg' => 'RS256', 'typ' => 'JWT'];
        $claims = [
            'iss' => $json['client_email'],
            'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
            'aud' => $json['token_uri'],
            'iat' => $now,
            'exp' => $now + 3600,
        ];

        $base64UrlHeader = rtrim(strtr(base64_encode(json_encode($header)), '+/', '-_'), '=');
        $base64UrlClaims = rtrim(strtr(base64_encode(json_encode($claims)), '+/', '-_'), '=');
        openssl_sign("$base64UrlHeader.$base64UrlClaims", $signature, $json['private_key'], 'sha256WithRSAEncryption');
        $base64UrlSignature = rtrim(strtr(base64_encode($signature), '+/', '-_'), '=');
        $jwt = "$base64UrlHeader.$base64UrlClaims.$base64UrlSignature";

        $res = Http::asForm()->post($json['token_uri'], [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwt,
        ]);

        return $res->json()['access_token'];
    }

    public function getSalesData()
    {
        $storeId = session('tenant_id');
        if (!$storeId) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $sales = Order::where('store_id', $storeId)
            ->where('status', 'approved')
            ->selectRaw("DATE(created_at) as date, SUM(total_price) as total")
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return response()->json($sales);
    }

    public function exportPdf(Order $order)
    {
        $storeId = session('tenant_id');
        if ($order->store_id != $storeId) {
            abort(403, 'Unauthorized access to order.');
        }

        $order->load('products');

        return Pdf::loadView('store.order.export_pdf', compact('order'))
           ->download("order-{$order->id}.pdf");
    }

    public function exportCsv(Order $order)
    {
        $storeId = session('tenant_id');
        if ($order->store_id != $storeId) {
            abort(403, 'Unauthorized access to order.');
        }

        $order->load('products');

        $filename = "order-{$order->id}.csv";
        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate",
            "Expires" => "0",
        ];

        $callback = function () use ($order) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Product', 'Quantity', 'Price']);

            foreach ($order->products as $product) {
                fputcsv($handle, [
                    $product->name,
                    $product->pivot->quantity,
                    $product->price,
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
