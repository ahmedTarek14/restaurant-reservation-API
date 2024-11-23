<?php

use App\Http\Controllers\Api\MealController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ReservationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::name('reservation.')->prefix('reservation')->controller(ReservationController::class)->group(function () {
    Route::post('/check-availability', 'checkAvailability')->name('check');
    Route::post('/reserve-table', 'reserveTable')->name('reserve');
});

Route::name('order.')->prefix('order')->controller(OrderController::class)->group(function () {
    Route::post('/place-order', 'placeOrder')->name('placeOrder');
    Route::post('/checkout', 'checkout')->name('checkout');
});

Route::get('meals/menu', [MealController::class, 'listMenu'])->name('meals.all');