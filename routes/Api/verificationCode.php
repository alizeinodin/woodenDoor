<?php


use App\Http\Controllers\VerificationCodeController;
use Illuminate\Support\Facades\Route;

Route::name('verification_code.')->group(function () {
    Route::prefix('/verification_code')->group(function () {
        Route::controller(VerificationCodeController::class)->group(function () {
            Route::post('/request', 'send')
                ->name('send');
        });
    });
});
