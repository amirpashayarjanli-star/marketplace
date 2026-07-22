<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

use App\Services\NavasanService;

Route::get('/test-dollar', function (NavasanService $navasan) {
    return $navasan->getUsdPrice();
});