<?php


use App\Http\Controllers\v1\CommentController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::name('comment.')->group(callback: function () {
        Route::controller(CommentController::class)->group(function () {

            Route::prefix('/comments')->group(function () {

                Route::get('{post}', 'get_comments')
                    ->name('comments');

                Route::get('{comment}/children', 'get_children')
                    ->name('replies');

                Route::get('{comment}/parent', 'get_parent')
                    ->name('parents');
            });

        });
    });
    Route::resource('comment', CommentController::class)
        ->only([
            'index',
            'show',
            'store',
            'update',
            'destroy'
        ]);
});
