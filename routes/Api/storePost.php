<?php


use App\Http\Controllers\v1\StorePostController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::name('store_post.')->group(function () {
        Route::controller(StorePostController::class)->group(function () {
            Route::prefix('/store_post')->group(function () {

                Route::post('/store/{post}', 'storePost')
                    ->name('store');

                Route::post('/unStore/{post}', 'unStorePost')
                    ->name('unStore');
            });;
        });
    });
});
