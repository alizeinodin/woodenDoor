<?php


use App\Http\Controllers\v1\Post\PostCategoryController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::name('post_category.')->group(function () {
        Route::controller(PostCategoryController::class)->group(function () {
            Route::get('/{postCategory}/posts', 'show_posts')
                ->name('show_posts');
        });
    });
    Route::resource('post_category', PostCategoryController::class)
        ->only([
            'index',
            'store',
            'update',
            'destroy'
        ]);
});
