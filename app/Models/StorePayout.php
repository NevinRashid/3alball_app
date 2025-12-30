<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StorePayout extends Model
{
    protected $fillable = [
        'store_id',
        'amount',
        'commission',
        'note',
        'admin_id',
        'paid_at',
    ];
}
