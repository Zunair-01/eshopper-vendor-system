<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Charge;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminOrderController extends Controller
{
    public function index(){
        return view('admin.orders');
    }
    // public function getOrders()
    public function ordersdata()
    {
        try {
            $orders = Order::with(['items', 'user', 'payment'])
                ->get();
                $formattedOrders = $orders->map(function ($order) {
                    return [
                        'order_id' => $order->id,
                        'order_items_count' => $order->items->count(), // Get count of items instead of details
                        'payment' => $order->payment,
                        'customer_name' => $order->user ? $order->user->name : 'N/A',
                        'grand_total' => $order->grand_total,
                        'status' => $order->status,
                    ];
                });


            return response()->json([
                'success' => true,
                'data' => $formattedOrders,
                'message' => 'Orders fetched successfully.'
            ]);
        } catch (\Exception $e) {
            Log::debug("order ========> " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch orders: ' . $e->getMessage()
            ], 500);
        }
    }





}
