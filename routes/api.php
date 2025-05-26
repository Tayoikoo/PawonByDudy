<?php

use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/order/midtrans-callback', [OrderController::class, 'callback'])->name('pawonbydudy.order.callback');
Route::post('/midtrans/notification', [OrderController::class, 'handleNotification']);
