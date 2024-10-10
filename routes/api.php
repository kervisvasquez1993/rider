<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\RideRequestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::middleware('auth:api')->group(function () {
    Route::get('notifications', [AuthController::class, 'notifications'])->name('notifications.notifications');
    Route::post('new-request-rider', [RideRequestController::class, 'store'])->name('new-request-rider.store');
});
