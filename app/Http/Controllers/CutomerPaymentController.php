<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class CutomerPaymentController extends Controller
{
    public function index(){
        return view('customer.payment');
    }
    public function store(Request $request)
{
    $validatedData = $request->validate([
        'orderId' => 'required|exists:orders,id',
        'fullName' => 'required|string',
        'contact' => 'required|string',
        'address' => 'required|string',
        'paymentMethod' => 'required|string',
    ]);

    // Store the payment in the database
    Payment::create([
        'order_id' => $validatedData['orderId'],
        'full_name' => $validatedData['fullName'],
        'contact' => $validatedData['contact'],
        'address' => $validatedData['address'],
        'payment_method' => $validatedData['paymentMethod'],
    ]);

    // Update the order status to completed
    $order = Order::find($validatedData['orderId']);
    $order->status = 'Completed'; // Set the status to completed
    $order->save(); // Save the updated order status

    $userId = auth()->id();

    // Clear the cart for this user
    Cart::where('user_id', $userId)->delete();

    return response()->json(['message' => 'Payment recorded successfully and order status updated to completed.']);
}


}
