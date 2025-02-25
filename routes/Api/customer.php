<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Customer\Auth\CustomerAuthController;
use App\Http\Controllers\Api\Customer\SettingsController;

Route::middleware(['api'])->prefix('customer')->group(function () {
    Route::post('login', [CustomerAuthController::class, 'login']);
    Route::middleware('api')->group(function (){
        //settings
        Route::get('settings', [SettingsController::class, 'index']);
    });

    //all auth routes here
    Route::middleware(['auth:sanctum','customer'])->group(function () {
        //logout user
        Route::get('logout', [CustomerAuthController::class, 'logout']);
    });
});
