<?php

namespace App\Events;

use App\Models\LiveChat;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast; 
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class NewChatMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $chat;

    public function __construct(LiveChat $chat)
    {
        $this->chat = $chat;
    }

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('chat.user.' . $this->chat->user_id); // ✅ dynamic channel for user
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->chat->id,
            'message' => $this->chat->message,
            'file' => $this->chat->file,
            'from_admin' => $this->chat->from_admin,
            'created_at' => $this->chat->created_at->toDateTimeString(),
        ];
    }
}
