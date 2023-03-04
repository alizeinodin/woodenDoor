<?php


use App\Http\Controllers\v1\Blog\ReactionPostController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::name('reaction.')->group(function () {
        Route::controller(ReactionPostController::class)->group(function () {

            Route::prefix('/reaction')->group(function () {

                Route::post('/likeOrDislike', 'react')
                    ->name('likeOrDislike');

                Route::post('/delete', 'delete_react')
                    ->name('delete');
            });

        });
    });
    Route::resource('reaction', ReactionPostController::class)
        ->only([
            'index',
        ]);
});
