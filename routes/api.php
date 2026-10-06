<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//Route::get('/orders', [AdminOrderController::class, 'ordersdata']);
// Route::post('/auth/reset-email', [AuthController::class, 'sendResetLink'])->name('password.reset');
// Route::post('password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset.token');
// Route::post('password/reset', [AuthController::class, 'reset'])->name('password.update');
