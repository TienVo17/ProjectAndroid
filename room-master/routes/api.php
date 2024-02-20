<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CheckinoutController;
use App\Http\Controllers\BookingRoomController;
use App\Http\Controllers\InvoiceController;


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

Route::resource('rooms', RoomController::class);

Route::get('room_store',[RoomController::class,'store2']);

Route::resource('room-types', RoomTypeController::class);
Route::resource('customers', CustomerController::class);
Route::resource('check-in-out', CheckinoutController::class);
Route::resource('booking-room', BookingRoomController::class);
Route::resource('invoices', InvoiceController::class);
