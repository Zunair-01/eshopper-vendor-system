<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CutomerOrderController extends Controller
{
    public function createOrder(Request $request)
{
    $user = Auth::user();
    $cartItems = Cart::where('user_id', $user->id)->with('product')->get();
    $subtotal = $request->input('subtotal');
    $grandTotal = $request->input('grandTotal');

    // Create the order with the passed amounts
    $order = Order::create([
        'user_id' => $user->id,
        'subtotal' => $subtotal,
        'grand_total' => $grandTotal,
        'status' => 'pending'
    ]);

    // Create order items
    foreach ($cartItems as $item) {
        $total = $item->quantity * $item->product->price;
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $item->product->id,
            'quantity' => $item->quantity,
            'price' => $item->product->price,
            'total' => $total,
        ]);
    }
    return response()->json(['status' => 'success', 'message' => 'Order created successfully!']);
}
public function getOrderDetails()
{
    // Fetch the latest order of the logged-in user
    $order = Order::where('user_id', auth()->id())->latest()->first();

    if (!$order) {
        return response()->json([
            'message' => 'No order found for the user.'
        ], 404); // Return a 404 error if no order is found
    }

    $subtotal = $order->subtotal;
    $tax = $order->tax;
    $grandTotal = $order->grand_total;
    $totalItems = $order->items->sum('quantity');

    return response()->json([
        'orderId' => $order->id,
        'totalItems' => $totalItems,
        'subtotal' => number_format($subtotal, 2),
        'grandTotal' => number_format($grandTotal, 2)
    ]);
}





}
