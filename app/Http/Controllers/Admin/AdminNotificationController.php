<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\GlobalSetting;

class AdminNotificationController extends Controller
{
    public function create()
    {
        return view('admin.notifications.create');
    }

    public function send(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string|max:1000',
        ]);
    
        $globalSettings = GlobalSetting::first();
    
        // ✅ Use default FCM image if set, otherwise fallback to site logo
        $imageUrl = $globalSettings->default_fcm_image
            ?? ($globalSettings->site_logo ? asset('storage/' . $globalSettings->site_logo) : null);
    
        $serviceAccountPath = base_path(env('FIREBASE_CREDENTIALS'));
        $projectId = env('FIREBASE_PROJECT_ID');
    
        $token = $this->generateAccessToken($serviceAccountPath);
    
        // ✅ Build the message payload
        $message = [
            "message" => [
                "topic" => "all",
                "notification" => [
                    "title" => $request->title,
                    "body" => $request->body,
                ]
            ]
        ];
    
        // ✅ Attach image if available
        if ($imageUrl) {
            $message['message']['notification']['image'] = $imageUrl;
        }
    
        $response = Http::withToken($token)
            ->post("https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send", $message);
    
        if ($response->successful()) {
            return back()->with('success', '✅ Notification sent!');
        }
    
        return back()->with('error', '❌ Failed: ' . $response->body());
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
        $signature = '';
        openssl_sign("$base64UrlHeader.$base64UrlClaims", $signature, $json['private_key'], 'sha256WithRSAEncryption');
        $base64UrlSignature = rtrim(strtr(base64_encode($signature), '+/', '-_'), '=');
        $jwt = "$base64UrlHeader.$base64UrlClaims.$base64UrlSignature";

        $res = Http::asForm()->post($json['token_uri'], [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwt,
        ]);

        return $res->json()['access_token'];
    }
}
