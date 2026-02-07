<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Store extends Authenticatable
{
    protected $fillable = [
    'store_name',
    'email',
    'password',
    'phone',
    'address',
    'facebook',
    'instagram',
    'whatsapp',
    'logo',
    'theme',
    'status',
];

    protected $hidden = [
        'password',
    ];
    
    public function products()
{
    return $this->hasMany(\App\Models\Product::class, 'store_id');
}
public function orders()
{
    return $this->hasMany(\App\Models\Order::class, 'store_id');
}

public function categories()
{
    return $this->hasMany(Category::class);
}
public function payouts()
{
    return $this->hasMany(\App\Models\StorePayout::class);
}


    
}

