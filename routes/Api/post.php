<?php


use App\Http\Controllers\v1\Blog\PostController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::name('post.')->group(function () {
        Route::controller(PostController::class)->group(function () {

        });
    });
    Route::resource('post', PostController::class)
        ->only([
            'index',
            'show',
            'store',
            'update',
            'destroy'
        ]);
});
