<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'title', 'body', 'type', 'user_id', 'order_id', 'image', 'read_at'
    ];
    
    public function user() {
        return $this->belongsTo(User::class);
    }
    
    public function order() {
        return $this->belongsTo(Order::class);
    }
    
}
