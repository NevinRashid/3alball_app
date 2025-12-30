<?php

namespace App\Http\Controllers\Api;

use App\Models\UserMessage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserMessageApiController extends Controller
{
    /**
     * GET /api/user-messages
     * Return all messages for the authenticated user
     */
    public function index()
    {
        try {
            $user = Auth::user();

            $messages = UserMessage::where('user_id', $user->id)
                ->latest()
                ->get();

            return response()->json([
                'data' => $messages
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Unable to fetch messages',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * POST /api/user-messages/{id}/read
     * Mark a message as read
     */
    public function markAsRead($id)
    {
        try {
            $message = UserMessage::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $message->update(['is_read' => true]);

            return response()->json(['message' => 'Marked as read']);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Unable to mark as read',
                'details' => $e->getMessage()
            ], 500);
        }
    }
    public function unreadCount()
{
    $count = UserMessage::where('user_id', auth()->id())
        ->where('is_read', false)
        ->count();

    return response()->json(['count' => $count]);
}

}
