<?php

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\Security\LoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Security Routes
|--------------------------------------------------------------------------
*/

Route::middleware('web')->post('/login', LoginController::class);
Route::middleware('web')->post('/register', RegisterController::class);
