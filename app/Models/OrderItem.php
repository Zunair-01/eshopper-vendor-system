<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $fillable = ['order_id', 'product_id', 'quantity', 'price','total'];

    // Relationship to fetch the product details
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relationship to fetch the order it belongs to
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
