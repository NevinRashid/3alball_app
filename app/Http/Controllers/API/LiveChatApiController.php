<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LiveChat;

class LiveChatApiController extends Controller
{
    public function start(Request $request)
    {
        $user = $request->user();
    
        $activeChat = LiveChat::where('user_id', $user->id)
            ->whereNull('ended_at')
            ->latest()
            ->first();
    
        if ($activeChat) {
            $activeChat->update([
                'ended_at' => now(),
            ]);
        }
    
        LiveChat::create([
            'user_id' => $user->id,
            'chat_session_id' => uniqid('chat_'), 
            'message' => '🆘 User has requested support',
            'from_admin' => false,
        ]);
    
        return response()->json(['message' => 'Support chat initiated.']);
    }
    


    public function index(Request $request)
{
    return LiveChat::where('user_id', auth()->id())
        ->orderBy('created_at')
        ->get();
}


public function store(Request $request)
{
    $request->validate([
        'message' => 'required|string',
    ]);

    $user = auth()->user();

    $latestChat = LiveChat::where('user_id', $user->id)
        ->whereNull('ended_at')
        ->latest()
        ->first();

    if (!$latestChat) {
        return response()->json(['error' => 'No active chat session.'], 400);
    }

    $chat = LiveChat::create([
        'user_id' => $user->id,
        'chat_session_id' => $latestChat->chat_session_id,
        'message' => $request->message,
        'from_admin' => false,
    ]);

    return response()->json($chat, 201);
}



public function fetchChat(Request $request)
{
    $user = auth()->user();

    $latestChat = LiveChat::where('user_id', $user->id)
        ->whereNull('ended_at')
        ->latest()
        ->first();

    if (!$latestChat) {
        return response()->json([]); // No active session
    }

    $messages = LiveChat::where('user_id', $user->id)
        ->where('chat_session_id', $latestChat->chat_session_id)
        ->orderBy('created_at')
        ->get();

    return response()->json($messages);
}



}
