<?php


use App\Http\Controllers\v1\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::name('auth.')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('/sign-up', 'register')
            ->name('register')
            ->middleware('registration.allow');
    });
});
