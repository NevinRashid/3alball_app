<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LiveChat extends Model
{
    protected $fillable = ['user_id', 'chat_session_id', 'message', 'file', 'from_admin', 'ended_at'];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
