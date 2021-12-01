<?php

use App\Http\Controllers\Security\LoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Security Routes
|--------------------------------------------------------------------------
*/

Route::middleware('web')->post('/login', LoginController::class);
