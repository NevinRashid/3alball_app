<?php

// app/Models/Coupon.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Coupon extends Model
{
    protected $fillable = [
        'code', 'discount', 'type', 'min_order_amount', 'expires_at', 'usage_limit', 'is_active'
    ];

    public function isValid($total)
    {
        return $this->is_active &&
               (!$this->expires_at || now()->lt(Carbon::parse($this->expires_at))) &&
               (!$this->min_order_amount || $total >= $this->min_order_amount);
    }

    public function calculateDiscount($total)
    {
        if ($this->type === 'percent') {
            return round($total * ($this->discount / 100), 2);
        }

        return min($this->discount, $total);
    }
    public function users()
{
    return $this->belongsToMany(User::class, 'coupon_user')->withTimestamps();
}

}
