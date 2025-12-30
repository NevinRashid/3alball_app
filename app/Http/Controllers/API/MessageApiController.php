<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;

class MessageApiController extends Controller
{
    // Get all messages for a given order
    public function index($order_id)
    {
        $messages = Message::where('order_id', $order_id)
            ->orderBy('created_at')
            ->get();

        return response()->json($messages);
    }

    // Store a new message
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'sender' => 'required|in:user,store',
            'message' => 'required|string',
        ]);

        $message = Message::create([
            'order_id' => $request->order_id,
            'sender' => $request->sender,
            'message' => $request->message,
        ]);

        return response()->json($message);
    }
}
