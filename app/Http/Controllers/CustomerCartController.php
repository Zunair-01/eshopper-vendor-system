<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerCartController extends Controller
{
    public function view(){
        return view('customer.cart');
    }
    public function addToCart(Request $request)
{
    // Check if the user is authenticated
    if (!auth()->check()) {
        return response()->json(['status' => 'unauthenticated']);
    }

    $user = Auth::user();
    $productId = $request->input('product_id');
    $quantity = $request->input('quantity', 1);  // Default quantity of 1

    // Find or create the cart item for the authenticated user and specific product
    $cartItem = Cart::where('user_id', $user->id)
                    ->where('product_id', $productId)
                    ->first();

    if ($cartItem) {
        // If the product is already in the cart, update the quantity
        $cartItem->quantity += $quantity;
        $cartItem->save();
    } else {
        // Otherwise, create a new cart entry for the product
        Cart::create([
            'user_id' => $user->id,
            'product_id' => $productId,
            'quantity' => $quantity,
        ]);
    }

    return response()->json(['status' => 'success']);
}
public function showCart()
    {
        if (!Auth::check()) {
            return response()->json(['status' => 'unauthenticated']);
        }

        $user = Auth::user();

        // Get all cart items for the authenticated user
        $cartItems = Cart::with(['product', 'user'])
                ->where('user_id', $user->id)
                ->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['status' => 'empty', 'message' => 'Your cart is empty.']);
        }

        return response()->json(['status' => 'success', 'cartItems' => $cartItems]);
    }
    public function removeCartItem($id)
{
    $cartItem = Cart::find($id);

    if ($cartItem && $cartItem->user_id === Auth::id()) {
        $cartItem->delete();
        return response()->json(['status' => 'success']);
    }

    return response()->json(['status' => 'error', 'message' => 'Item not found or unauthorized.']);
}
public function getCartCount()
{
    $user = Auth::user();

    if ($user) {
        $count = Cart::where('user_id', $user->id)->count();
        return response()->json(['status' => 'success', 'count' => $count]);
    }

    return response()->json(['status' => 'error', 'count' => 0]);
}




}
