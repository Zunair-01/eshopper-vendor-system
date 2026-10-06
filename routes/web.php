<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChargeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminHomeController;
use App\Http\Controllers\CustomerCartController;
use App\Http\Controllers\CustomerHomeController;
use App\Http\Controllers\CutomerOrderController;
use App\Http\Controllers\CustomerProductController;
use App\Http\Controllers\CutomerPaymentController;
use App\Http\Controllers\AdminOrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/setting', function () {
    return view('admin.setting');
});

//customer routes
Route::group(['middleware' => 'user'], function () {

    // logout for customer
    Route::post('/auth/customer/logout', [AuthController::class, 'customerLogout'])->name('customer.logout');
    Route::post('/addToCart', [CustomerCartController::class, 'addToCart']);
    Route::get('/cus-cart', [CustomerCartController::class, 'view'])->name('customer.cart');
    Route::get('/cus-fetched', [CustomerCartController::class, 'showCart']);
    Route::get('/cart/count', [CustomerCartController::class, 'getCartCount']);
    Route::post('/create-order', [CutomerOrderController::class, 'createOrder']);
    Route::get('/get-order', [CutomerOrderController::class, 'getOrderDetails'])->name('getOrderDetails');
    Route::get('/payments', [CutomerPaymentController::class, 'index']);
    Route::post('/store-payment', [CutomerPaymentController::class, 'store']);
    Route::delete('/remove-cart-item/{id}', [CustomerCartController::class, 'removeCartItem']);
    Route::get('auth/reset-email', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('auth/reset-password', [AuthController::class, 'reset'])->name('password.update');
});
//customer routes without login access
Route::get('/show', [CustomerProductController::class, 'show']);
Route::get('/showCategories', [CustomerProductController::class, 'showCategories']);
Route::get('/showProductsByCategory/{category}', [CustomerProductController::class, 'showProductsByCategory']);
Route::get('/cus-home', [CustomerHomeController::class, 'customerHome'])->name('customer.home');
//Auth routes
Route::get('/auth/register', [AuthController::class, 'registerView'])->name('customer.register');
Route::post('/auth/register', [AuthController::class, 'createRegister']);
Route::get('/auth/login', [AuthController::class, 'loginView'])->name('customer.login');
Route::post('/auth/login', [AuthController::class, 'createLogin']);

// password reset roytes both for admin and customer
Route::get('/auth/forgot-password', [AuthController::class, 'forgotPasswordView'])->name('customer.forgot');
Route::post('/auth/reset-email', [AuthController::class, 'sendResetLink'])->name('password.reset');


Route::group(['middleware' => 'admin'], function () {
    //home route
    Route::get('/home-data', [AdminHomeController::class, 'getHomeData'])->name('admin.home');
    //product add,update,delete routes
    Route::get('/product', [ProductController::class, 'create']);
    Route::post('/store', [ProductController::class, 'store']);
    Route::get('/show', [ProductController::class, 'show']);
    Route::get('/edit/{id}', [ProductController::class, 'edit']);
    Route::put('/update/{id}', [ProductController::class, 'update']);
    Route::delete('/delete/{id}', [ProductController::class, 'destroy']);

    Route::get('/', [AdminHomeController::class, 'adminHome'])->name('admin.home');
    Route::get('/home', [AdminHomeController::class, 'adminHome'])->name('admin.home');
    Route::get('/customers', [AdminHomeController::class, 'adminCustomers'])->name('admin.customers');
    Route::get('/orders', [AdminHomeController::class, 'adminOrders'])->name('admin.orders');
    Route::get('/chats', [AdminHomeController::class, 'adminChats'])->name('admin.chats');
    // logout for admin
    Route::post('/auth/admin/logout', [AuthController::class, 'adminLogout'])->name('admin.logout');
    Route::get('auth/reset-email', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('auth/reset-password', [AuthController::class, 'reset'])->name('password.update');
    Route::post('/charges', [ChargeController::class, 'store']); // Automatically creates resource routes
    Route::get('/get', [ChargeController::class, 'getCharges']);
    Route::put('/charges/{id}', [ChargeController::class, 'update']);
    Route::get('/orders-view', [AdminOrderController::class, 'index']);
    Route::post('orders', [AdminOrderController::class, 'ordersdata']);
});
