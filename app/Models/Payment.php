<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'orders'; // ⬅️ Use the existing orders table

    protected $casts = [
        'admin_commission' => 'decimal:2',
        'store_earnings' => 'decimal:2',
    ];

    // Only treat rows with payment data as Payment
    protected static function booted(): void
    {
        static::addGlobalScope('payments_only', function (Builder $builder) {
            $builder->whereNotNull('payment_method');
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
