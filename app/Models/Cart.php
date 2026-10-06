<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
    ];

    // Relationship to fetch product details
    public function product()
    {
        return $this->belongsTo(Product::class); // Assuming you have a Product model
    }
    public function user()
    {
        return $this->belongsTo(User::class); // Assuming you have a User model
    }
}
