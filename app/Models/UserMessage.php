<?php

// app/Models/UserMessage.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'body', 'type', 'related_order_id', 'is_read', 'sent_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'related_order_id');
    }
}
