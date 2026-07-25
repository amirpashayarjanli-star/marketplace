<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');


use App\Services\NavasanService;

Route::get('/test-dollar', function (NavasanService $navasan) {
    return $navasan->getUsdPrice();
});


use App\Http\Controllers\CompanyController;

Route::get('/companies', [CompanyController::class, 'index'])
    ->name('companies.index');


use App\Http\Controllers\ManufacturerController;

Route::get('/manufacturers', [ManufacturerController::class, 'index'])
    ->name('manufacturers.index');


use App\Http\Controllers\StoreController;

Route::get('/stores', [StoreController::class, 'index'])
    ->name('stores.index');


use App\Http\Controllers\TechnicianController;

Route::get('/technicians', [TechnicianController::class, 'index'])
    ->name('technicians.index');


use App\Http\Controllers\ProjectController;

Route::get('/projects', [ProjectController::class, 'index'])
    ->name('projects.index');



Route::get('/company-profile', function () {

    return view('pages.profile.company.index');

});


Route::get('/manufacturer-profile', function () {

    return view('pages.profile.manufacturer.index');

});
