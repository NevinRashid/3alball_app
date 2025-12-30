<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const ROLE_ADMIN = 'admin';
    const ROLE_SHOP = 'shop_owner';
    const ROLE_CUSTOMER = 'customer';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'tenant_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // 🔗 Tenant Relationship
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    // 🔗 Addresses Relationship
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    // 🔗 Orders Relationship ✅ ADD THIS
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function usedCoupons()
{
    return $this->belongsToMany(Coupon::class, 'coupon_user')->withTimestamps();
}


public function liveChats()
{
    return $this->hasMany(\App\Models\LiveChat::class);
}


}
