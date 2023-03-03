<?php


use App\Http\Controllers\v1\CommentController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::name('comment.')->group(callback: function () {
        Route::controller(CommentController::class)->group(function () {

        });
    });
    Route::resource('comment', CommentController::class)
        ->only([
            'index',
            'show',
            'update',
            'destroy'
        ]);
});
