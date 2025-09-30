<?php

use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::prefix('api')->group(function () {
Route::prefix('/bookings')->group(function () {
    Route::post('/', [BookingController::class, 'store']);    //RU: создать
    Route::get('/', [BookingController::class, 'index']);     //RU: список
    Route::delete('{id}', [BookingController::class, 'destroy']); //RU: удалить
});

Route::get('/ping', function () {
    return response()->json([
        'message_fr' => 'Ça marche 🚀',       // FR: Ça marche
        'message_ru' => 'Работает 🚀',       // RU: Работает
        'status'     => 'ok'
    ]);
});
});