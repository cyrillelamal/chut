<?php

use App\Http\Controllers\ConversationController;
use App\Http\Controllers\ConversationMessageController;
use App\Http\Controllers\DiscoveryController;
use App\Http\Controllers\ParticipationController;
use App\Http\Controllers\Security\LoginController;
use App\Http\Controllers\Security\LogoutController;
use App\Http\Controllers\Security\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserMessageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Security Routes
|--------------------------------------------------------------------------
*/

Route::middleware('web')->group(function () {
    Route::post('/login', LoginController::class)->name('login');
    Route::post('/register', RegisterController::class)->name('register');
    Route::post('/logout', LogoutController::class)->name('logout');
});


/*
|--------------------------------------------------------------------------
| Resource Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserController::class, 'find'])
        ->name('users.find');

    Route::apiResource('conversations', ConversationController::class)
        ->only(['store', 'update']);

    Route::apiResource('participations', ParticipationController::class)
        ->only(['index']);

    Route::apiResource('conversations.messages', ConversationMessageController::class)
        ->shallow()
        ->only(['index', 'store']);

    Route::apiResource('users.messages', UserMessageController::class)
        ->shallow()
        ->parameter('users', 'receiver')
        ->only(['store']);

    Route::get('/discovery', DiscoveryController::class)->name('discovery');
});
