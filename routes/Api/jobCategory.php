<?php


use App\Http\Controllers\v1\JobCategoryController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::name('job_category.')->group(function () {
        Route::controller(JobCategoryController::class)->group(function () {

            Route::prefix('/job_category')->group(function () {

                Route::get('/show_companies/{category}', 'showCompanies')
                    ->name('companies');

                Route::get('/show_job_ads/{category}', 'showJobAds')
                    ->name('job_ads');
            });

        });
    });
    Route::resource('job_category', JobCategoryController::class)
        ->only([
            'index',
            'store',
            'show',
            'update',
            'destroy'
        ]);
});
