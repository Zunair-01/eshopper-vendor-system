<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Fillable attributes for mass assignment
    protected $fillable = [
        'user_id',
        'subtotal',
        'grand_total',
        'status'
    ];

    // Relationship to fetch order items
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id'); // Ensure the foreign key is correctly defined
    }
    // Relationship to fetch the user who placed the order
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function payment()
    {
        return $this->hasOne(Payment::class, 'order_id'); // Ensure the foreign key is correctly defined
    }

}
