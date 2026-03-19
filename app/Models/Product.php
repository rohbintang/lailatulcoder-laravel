<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'price',
        'description',
        'stock',
        'category_id',
        'seller_id',
        'is_active'
    ];
    
    public function reviews()
    {
        return $this->hasMany(\App\Models\Review::class);
    }
}
