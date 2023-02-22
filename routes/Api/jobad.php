<?php


use App\Http\Controllers\v1\JobAdController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::name('job_ads.')->group(function () {
        Route::controller(JobAdController::class)->group(function () {

            Route::prefix('/job_ad')->group(function () {
                Route::post('/my-jobAds', 'my_jobAds')
                    ->name('my_jobAds');
                Route::post('/store/{company}', 'store')
                    ->name('store');
            });

        });
    });
    Route::resource('job_ads', JobAdController::class)
        ->only([
            'index',
            'show',
            'update',
            'destroy'
        ]);
});
