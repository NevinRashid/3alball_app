<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationApiController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user(); // authenticated user

        $notifications = Notification::where('user_id', $user->id)
            ->latest()
            ->take(50)
            ->get();

        return response()->json([
            'status' => true,
            'notifications' => $notifications,
        ]);
    }
}
