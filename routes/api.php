<?php

use App\Http\Controllers\Security\LoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Security Routes
|--------------------------------------------------------------------------
*/

Route::post('/login', LoginController::class);
