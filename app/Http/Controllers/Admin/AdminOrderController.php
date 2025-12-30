<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;


class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['store', 'user'])->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', $search)
                  ->orWhereHas('user', fn($q) => $q->where('name', 'like', "%$search%"))
                  ->orWhereHas('store', fn($q) => $q->where('store_name', 'like', "%$search%"));
            });
        }

        $orders = $query->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('store')->findOrFail($id);
        return response()->json($order);
    }

    public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:pending,approved,rejected,order_placed,order_packed,on_the_way,delivered'
    ]);

    $order = Order::findOrFail($id);
    $order->status = $request->status;
    $order->save();

    // 🔔 Notification message
    $title = 'Order ' . ucfirst($order->status);
    $body = 'Your order #' . $order->id . ' has been ' . ($order->status === 'rejected' ? 'rejected by admin.' : 'updated to ' . $order->status . '.');

    // 🧠 Custom logic if rejected
    if ($request->status === 'rejected') {
        // Example: log rejection or notify admin team
        Log::info("Order #{$order->id} has been rejected by admin.");
        // Optional: refund trigger, flag, or rollback
    }

    // 🔔 Create notification
    Notification::create([
        'title' => $title,
        'body' => $body,
        'type' => 'order',
        'user_id' => $order->user_id,
        'order_id' => $order->id,
    ]);

    // 🔥 Send FCM notification
    $user = User::find($order->user_id);
    if ($user && $user->fcm_token) {
        $token = $this->generateAccessToken(base_path(env('FIREBASE_CREDENTIALS')));
        $projectId = env('FIREBASE_PROJECT_ID');

        Http::withToken($token)->post("https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send", [
            'message' => [
                'token' => $user->fcm_token,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                ],
                'data' => [
                    'type' => 'order',
                    'order_id' => (string) $order->id,
                    'status' => $order->status,
                ]
            ]
        ]);
    }

    return back()->with('success', 'Order status updated successfully.');
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

    public function destroy($id)
    {
        Order::findOrFail($id)->delete();
        return back()->with('success', 'Order deleted successfully.');
    }

    public function export($type)
    {
        $orders = Order::with('store')->get();

        if ($type === 'csv') {
            $filename = 'orders_export_' . now()->format('Ymd_His') . '.csv';
            $headers = ['ID', 'Store', 'Status', 'Total', 'Created At'];

            $rows = $orders->map(function ($order) {
                return [
                    $order->id,
                    $order->store->store_name ?? 'N/A',
                    $order->status,
                    $order->total_price ?? '0.00',
                    $order->created_at->format('Y-m-d H:i'),
                ];
            });

            $handle = fopen('php://temp', 'r+');
            fputcsv($handle, $headers);
            foreach ($rows as $row) {
                fputcsv($handle, $row);
            }
            rewind($handle);
            $csv = stream_get_contents($handle);
            fclose($handle);

            return Response::make($csv, 200, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"$filename\"",
            ]);
        }

        return back()->with('error', 'Unsupported export type.');
    }
}
