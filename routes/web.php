<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ManufacturerController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\ProjectController;

use App\Services\NavasanService;



/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])
    ->name('home');





/*
|--------------------------------------------------------------------------
| Test Services
|--------------------------------------------------------------------------
*/

Route::get('/test-dollar', function (NavasanService $navasan) {

    return $navasan->getUsdPrice();

});





/*
|--------------------------------------------------------------------------
| Directory Pages
|--------------------------------------------------------------------------
*/


Route::get('/companies', [CompanyController::class, 'index'])
    ->name('companies.index');



Route::get('/manufacturers', [ManufacturerController::class, 'index'])
    ->name('manufacturers.index');



Route::get('/stores', [StoreController::class, 'index'])
    ->name('stores.index');



Route::get('/technicians', [TechnicianController::class, 'index'])
    ->name('technicians.index');



Route::get('/projects', [ProjectController::class, 'index'])
    ->name('projects.index');






/*
|--------------------------------------------------------------------------
| Profile Pages
|--------------------------------------------------------------------------
*/


Route::get('/company/{slug}', [CompanyController::class, 'show'])
    ->name('company.profile');



Route::get('/manufacturer/{slug}', [ManufacturerController::class, 'show'])
    ->name('manufacturer.profile');



Route::get('/store/{slug}', [StoreController::class, 'show'])
    ->name('store.profile');



Route::get('/technician/{slug}', [TechnicianController::class, 'show'])
    ->name('technician.profile');
