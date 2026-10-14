<?php

use App\Http\Controllers\Api\EventController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Events API Routes
|--------------------------------------------------------------------------
|
| Public routes: anyone can browse published events.
| Admin routes: require Sanctum authentication + admin role middleware.
|
*/

// Public: list and show events
Route::get('/events', [EventController::class, 'index']);
Route::get('/events/{slug}', [EventController::class, 'show']);

// Admin only: create, update, delete
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::post('/events', [EventController::class, 'store']);
    Route::put('/events/{id}', [EventController::class, 'update']);
    Route::delete('/events/{id}', [EventController::class, 'destroy']);
});
