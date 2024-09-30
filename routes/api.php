<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Auth\AuthController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('login', [AuthController::class, 'login']);
Route::middleware(['auth:api', 'is_admin'])->group(function () {
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout']);
Route::post('refresh', [AuthController::class, 'refresh']);
Route::get('/me', [AuthController::class, 'me']);


Route::get('orders/getSoftDeletedOrder', [OrderController::class, 'getSoftDeletedOrder']);
Route::get('/orders', [OrderController::class, 'index']);
Route::post('/orders', [OrderController::class, 'store']);
Route::get('/orders/{id}', [OrderController::class, 'show']);
Route::put('/orders/{id}', [OrderController::class, 'update']);
Route::delete('/orders/{id}', [OrderController::class, 'destroy']);
Route::post('/orders/{id}/restore', [OrderController::class, 'restore']);
Route::delete('/orders/{id}/forceDestroy', [OrderController::class, 'forceDestroy']);


Route::get('customers/getSoftDeletedCustomer', [CustomerController::class, 'getSoftDeletedCustomer']);
Route::get('/customers', [CustomerController::class, 'index']);
Route::post('/customers', [CustomerController::class, 'store']);
Route::get('customers/{id}', [CustomerController::class, 'show']);
Route::put('customers/{id}', [CustomerController::class, 'update']);
Route::delete('customers/{id}', [CustomerController::class, 'destroy']);
Route::post('/customers/{id}/restore', [CustomerController::class, 'restore']);
Route::delete('/customers/{id}/forceDestroy', [CustomerController::class, 'forceDestroy']);
Route::get('customers/filter/status', [CustomerController::class, 'filterByStatus'])->name('customers.filter.status');
Route::get('customers/filter/dates', [CustomerController::class, 'filterByDateRange'])->name('customers.filter.dates');


Route::get('payments/getSoftDeletedPayment', [PaymentController::class, 'getSoftDeletedPayment']);
Route::get('/payments', [PaymentController::class, 'index']);
Route::post('/payments', [PaymentController::class, 'store']);
Route::get('payments/{id}', [PaymentController::class, 'show']);
Route::put('payments/{id}', [PaymentController::class, 'update']);
    Route::delete('payments/{id}', [PaymentController::class, 'destroy']);
Route::post('/payments/{id}/restore', [PaymentController::class, 'restore']);
    Route::delete('/payments/{id}/forceDestroy', [PaymentController::class, 'forceDestroy']);
    Route::get('payments/{id}/orders', [PaymentController::class, 'ordersByPayment']); // GET /api/payments/{id}/orders



Route::get('customers/filter/status', [CustomerController::class, 'filterByOrdersStatus']);
Route::get('customers/filter/date-range', [CustomerController::class, 'filterByOrderDateRange']);
Route::get('orders/filter/customer/{customerId}', [OrderController::class, 'getOrdersByCustomer']);
Route::get('orders/filter/product/{productName}', [OrderController::class, 'getOrdersByProduct']);
});
