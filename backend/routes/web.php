<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SignUpController;

Route::get('/', function () {
    return view('Login');
});

Route::get('/signup', [SignUpController::class, 'show']);
Route::post('/signup', [SignUpController::class, 'store']);