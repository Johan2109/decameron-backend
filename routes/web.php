<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\RoomController;

Route::get('/hotels', [HotelController::class, 'index']);
Route::post('/hotels', [HotelController::class, 'create']);
Route::put('/hotels/{id}', [HotelController::class, 'update']);
Route::delete('/hotels/{id}', [HotelController::class, 'destroy']);

Route::get('/hotels/{id}/rooms', [RoomController::class, 'index']);
Route::post('/rooms', [RoomController::class, 'create']);

Route::get('/', function () {
    return view('welcome');
});
