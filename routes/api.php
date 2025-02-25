<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OrderController;

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

Route::get('/', function () {
    return true;
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders', [OrderController::class, 'index']);

    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/orders', [OrderController::class, 'adminOrders']);
        Route::put('/admin/orders/{id}', [OrderController::class, 'updateStatus']);
    });
});

Route::get('/test-route', function () {
    return response()->json(['message' => 'API is working']);
});