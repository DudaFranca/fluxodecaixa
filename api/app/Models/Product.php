<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fileable = [
        'name',
        'description',
        'price',
        'quantity',
        'image',
        'active',
    ];

    function sales()
    {
        return $this->belongsToMany(Sales::class, 'product_sale')
            ->withPivot(['quantity', 'total_price'])
            ->withTimestamps();
    }
}
