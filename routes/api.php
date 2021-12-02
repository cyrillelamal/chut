<?php

use App\Http\Controllers\ConversationController;
use App\Http\Controllers\ParticipationController;
use App\Http\Controllers\Security\LoginController;
use App\Http\Controllers\Security\LogoutController;
use App\Http\Controllers\Security\RegisterController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Security Routes
|--------------------------------------------------------------------------
*/

Route::middleware('web')->post('/login', LoginController::class)->name('login');
Route::middleware('web')->post('/register', RegisterController::class)->name('register');
Route::middleware('web')->post('/logout', LogoutController::class)->name('logout');


/*
|--------------------------------------------------------------------------
| Resource Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')
    ->get('/users', [UserController::class, 'find'])
    ->name('users.find');

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('participations', ParticipationController::class)
        ->only('index');
    Route::apiResource('conversations', ConversationController::class)
        ->only(['store', 'show', 'update', 'destroy']);
});
