<?php


use App\Http\Controllers\v1\CompanyController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::name('company.')->group(function () {
        Route::controller(CompanyController::class)->group(function () {

            Route::prefix('/companies')->group(function () {
                Route::get('/my-companies', 'my_companies')
                    ->name('my_companies');
            });

        });
    });
    Route::resource('companies', CompanyController::class)
        ->only([
            'index',
            'store',
            'update',
            'destroy'
        ]);
});
