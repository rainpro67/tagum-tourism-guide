<?php

use App\Http\Controllers\Api\PlaceController;
use Illuminate\Support\Facades\Route;

Route::get('/places', [PlaceController::class, 'index']);
Route::get('/places/{slug}', [PlaceController::class, 'show']);

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::post('/places', [PlaceController::class, 'store']);
    Route::put('/places/{id}', [PlaceController::class, 'update']);
    Route::delete('/places/{id}', [PlaceController::class, 'destroy']);
});
