<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerHomeController extends Controller
{
    public function customerHome()
    {
        return view('customer.home'); // Ensure this view exists
    }
}
