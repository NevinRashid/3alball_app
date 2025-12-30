<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['tenant_id', 'name', 'description', 'price', 'stock', 'status', 'category_id','image'];

    // Relationship with Tenant
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
    // In Product.php
public function category()
{
    return $this->belongsTo(Category::class);
}
public function store()
{
    return $this->belongsTo(\App\Models\Store::class);
}


}
