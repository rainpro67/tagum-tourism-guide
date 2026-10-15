<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SignUpController;
use App\Http\Controllers\UserProfileController;

Route::get('/', function () {
    return view('Login');
})->name('login');

Route::get('/signup', [SignUpController::class, 'show']);
Route::post('/signup', [SignUpController::class, 'store']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserProfileController::class, 'show']);
    Route::post('/profile', [UserProfileController::class, 'update']);
});