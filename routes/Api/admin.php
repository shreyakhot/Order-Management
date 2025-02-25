<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\Auth\AdminAuthController;
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\Admin\SettingController;
use App\Http\Controllers\Api\Admin\MailController;

Route::group(['prefix' => 'admin'], function () {
    Route::post('login', [AdminAuthController::class, 'login']);
    Route::group(['middleware' => ['auth:sanctum', 'admin']], function () {
        //logout user
        Route::get('logout', [AdminAuthController::class, 'logout']);

        //users
        Route::apiResource('users', UserController::class);

        //settings
        Route::group(['prefix' => 'settings'], function () {
            Route::get('/', [SettingController::class, 'index']);
            Route::post('/', [SettingController::class, 'update']);
        });

        //email
        Route::get('email/sent', [MailController::class, 'sendEmail']);
    });
});
