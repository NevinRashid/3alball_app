<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LiveChat;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use App\Models\UserMessage; 

class LiveChatController extends Controller
{
    public function index(Request $request)
    {
        $users = User::whereHas('liveChats', function($q) {
            $q->whereNull('ended_at'); // ✅ Only show users with active chats
        })->with('liveChats')->get();

        $selectedUser = null;
        $messages = [];
        $chatEnded = false;

        if ($request->has('user')) {
            $selectedUser = User::findOrFail($request->user);
            $messages = LiveChat::where('user_id', $selectedUser->id)
                ->orderBy('created_at')
                ->get();

            $chatEnded = $selectedUser->liveChats()
                ->latest()
                ->first()?->ended_at !== null;
        }

        return view('admin.livechat.index', compact('users', 'selectedUser', 'messages', 'chatEnded'));
    }

    public function reply(Request $request, $userId)
    {
        $request->validate([
            'message' => 'nullable|string',
            'file' => 'nullable|file|max:5120'
        ]);

        $latestChat = LiveChat::where('user_id', $userId)
            ->whereNull('ended_at')
            ->latest()
            ->first();

        if (!$latestChat) {
            return back()->with('error', 'No active chat session.');
        }

        $data = [
            'user_id' => $userId,
            'chat_session_id' => $latestChat->chat_session_id, // ✅ Attach to the correct session!
            'message' => $request->message,
            'from_admin' => true,
        ];

        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('live_chat_uploads', 'public');
        }

        $chat = LiveChat::create($data);
        
        UserMessage::create([
            'user_id' => $userId,
            'title' => 'Support Replied',
            'body' => $request->message ?? 'You received a new reply from support.',
            'type' => 'support',
            'sent_by' => 'support_agent',
        ]);

        // ✅ Optional: Broadcast event to notify user in real-time (you have already prepared event class)
        event(new \App\Events\NewChatMessage($chat));

        return back()->with('success', 'Message sent.');
    }

    public function end($userId)
    {
        LiveChat::where('user_id', $userId)
            ->whereNull('ended_at')
            ->update(['ended_at' => now()]);

        return back()->with('success', 'Chat ended successfully.');
    }

    public function start(Request $request)
    {
        $chat = LiveChat::create([
            'user_id' => auth()->id(),
            'message' => $request->input('message') ?? '🆘 User has requested support',
            'from_admin' => false,
        ]);

        return response()->json(['success' => true, 'chat_id' => $chat->id]);
    }
    public function fetch()
{
    $users = User::whereHas('liveChats', function($q) {
        $q->whereNull('ended_at');
    })->withCount(['liveChats as unread_messages_count' => function($query) {
        $query->whereNull('ended_at')->where('from_admin', false);
    }])->get();

    return response()->json($users);
}
public function messages($userId)
{
    $messages = LiveChat::where('user_id', $userId)
        ->orderBy('created_at')
        ->get();

    return response()->json($messages);
}

}
