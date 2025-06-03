<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;
    public $timestamps = true;

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    function products()
    {
        return $this->belongsToMany(Product::class, 'product_sale')
            ->withPivot(['quantity', 'total_price'])
            ->withTimestamps();
    }
}
