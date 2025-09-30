<?php

use App\Http\Controllers\BookingController;

Route::prefix('bookings')->group(function () {
    Route::post('/', [BookingController::class, 'store']);    // FR: créer / RU: создать
    Route::get('/', [BookingController::class, 'index']);     // FR: lister / RU: список
    Route::delete('{id}', [BookingController::class, 'destroy']); // FR: supprimer / RU: удалить
});
