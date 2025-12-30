<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'store_id',
        'buyer_name',
        'buyer_phone',
        'recipient_name',
        'recipient_phone',
        'recipient_address',
        'delivery_date',
        'delivery_time',
        'total_price',
        'status',
        'gift_message',
        'payment_method',
        'payment_status',
        'payment_proof',
        'admin_commission',
        'store_earnings',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    // many-to-many relationship with Product
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_product')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }
  // app/Models/User.php

public function orders()
{
    return $this->hasMany(\App\Models\Order::class);
}
// app/Models/Order.php

public function user()
{
    return $this->belongsTo(\App\Models\User::class);
}
public function messages()
{
    return $this->hasMany(Message::class);
}
protected $appends = ['items'];

public function getItemsAttribute()
{
    return $this->products->map(function ($product) {
        return [
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => $product->pivot->quantity ?? 1,
            'image' => $product->image,
        ];
    })->toArray();
}



}
