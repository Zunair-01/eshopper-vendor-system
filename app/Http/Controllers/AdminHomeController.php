<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminHomeController extends Controller
{
    public function adminHome(){
        return view('admin.home');
    }
    public function adminCustomers(){
        return view('admin.customers');
    }
    public function adminOrders(){
        return view('admin.orders');
    }
    public function adminChats(){
        return view('admin.chats');
    }
    public function getHomeData(){
        $totalCustomers = User::where('role', 'customer')->count();
        $totalOrders = Order::count();
        $totalSales = Order::sum('grand_total');

        return response()->json([
            'totalCustomers' => $totalCustomers,
            'totalOrders' => $totalOrders,
            'totalSales' => $totalSales,
        ]);

    }
    
}
