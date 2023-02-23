<?php


use App\Models\JobCategory;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::name('job_category.')->group(function () {
        Route::controller(JobCategory::class)->group(function () {

            Route::prefix('/job_category')->group(function () {

                Route::get('/show_companies/{category}', 'showCompanies')
                    ->name('companies');

                Route::get('/show_job_ads/{category}', 'showJobAds')
                    ->name('job_ads');
            });

        });
    });
    Route::resource('job_category', JobCategory::class)
        ->only([
            'index',
            'store',
            'show',
            'update',
            'destroy'
        ]);
});
