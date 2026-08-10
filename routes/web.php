<?php


use Illuminate\Support\Facades\Route;


use App\Http\Controllers\HomeController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RegisterProfileController;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardProfileController;

use App\Http\Controllers\ProjectDashboardController;
use App\Http\Controllers\ProjectInquiryController;
use App\Http\Controllers\ProjectInquiryManageController;

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ManufacturerController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\ProjectController;

use App\Http\Controllers\AdminController;

use App\Services\NavasanService;



/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/


Route::get('/', [

    HomeController::class,

    'index'

])
->name('home');





Route::get('/test-dollar', function (NavasanService $navasan) {

    return $navasan->getUsdPrice();

});









/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/


Route::middleware('auth')->group(function () {



    Route::get('/dashboard', [

        DashboardController::class,

        'index'

    ])
    ->name('dashboard');





    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */


    Route::get('/dashboard/profile', [

        DashboardProfileController::class,

        'show'

    ])
    ->name('dashboard.profile');




    Route::post('/dashboard/profile', [

        DashboardProfileController::class,

        'update'

    ])
    ->name('dashboard.profile.update');







    /*
    |--------------------------------------------------------------------------
    | Projects
    |--------------------------------------------------------------------------
    */


    Route::get('/dashboard/projects', [

        ProjectDashboardController::class,

        'index'

    ])
    ->name('dashboard.projects');





    Route::get('/dashboard/projects/create', [

        ProjectDashboardController::class,

        'create'

    ])
    ->name('dashboard.projects.create');





    Route::post('/dashboard/projects', [

        ProjectDashboardController::class,

        'store'

    ])
    ->name('dashboard.projects.store');





    Route::get('/dashboard/projects/{project}', [

        ProjectDashboardController::class,

        'show'

    ])
    ->name('dashboard.projects.show');







    /*
    |--------------------------------------------------------------------------
    | Project Inquiry
    |--------------------------------------------------------------------------
    */


    Route::post('/dashboard/projects/{project}/inquiry', [

        ProjectInquiryController::class,

        'store'

    ])
    ->name('dashboard.projects.inquiry');





    Route::delete('/dashboard/projects/inquiry/{inquiry}', [

        ProjectInquiryController::class,

        'destroy'

    ])
    ->name('dashboard.projects.inquiry.destroy');







    /*
    |--------------------------------------------------------------------------
    | Project Inquiry Manage
    |--------------------------------------------------------------------------
    */


    Route::post('/dashboard/projects/inquiry/{inquiry}/accept', [

        ProjectInquiryManageController::class,

        'accept'

    ])
    ->name('dashboard.projects.inquiry.accept');






    Route::post('/dashboard/projects/inquiry/{inquiry}/reject', [

        ProjectInquiryManageController::class,

        'reject'

    ])
    ->name('dashboard.projects.inquiry.reject');



});









/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/


Route::get('/login', [

    AuthController::class,

    'showLogin'

])
->name('login');



Route::post('/login', [

    AuthController::class,

    'login'

]);





Route::get('/login/otp', [

    OtpController::class,

    'showLoginOtp'

])
->name('login.otp');




Route::post('/login/otp', [

    OtpController::class,

    'verifyLoginOtp'

]);









/*
|--------------------------------------------------------------------------
| Register
|--------------------------------------------------------------------------
*/


Route::get('/register', [

    RegisterController::class,

    'show'

])
->name('register');




Route::post('/register', [

    RegisterController::class,

    'store'

]);




Route::get('/register/otp', [

    OtpController::class,

    'showRegisterOtp'

])
->name('register.otp');




Route::post('/register/otp', [

    OtpController::class,

    'verifyRegisterOtp'

]);




Route::get('/register/type', [

    RegisterController::class,

    'type'

])
->name('register.type');




Route::post('/register/type', [

    RegisterController::class,

    'saveType'

]);








Route::middleware('auth')->group(function(){


    Route::get('/register/profile',[

        RegisterProfileController::class,

        'show'

    ])
    ->name('register.profile');




    Route::post('/register/profile',[

        RegisterProfileController::class,

        'store'

    ]);


});









/*
|--------------------------------------------------------------------------
| Pending
|--------------------------------------------------------------------------
*/


Route::get('/pending', function(){

    return view('auth.pending');

})
->name('pending');









/*
|--------------------------------------------------------------------------
| Directory
|--------------------------------------------------------------------------
*/


Route::get('/companies',[

    CompanyController::class,

    'index'

])
->name('companies.index');




Route::get('/manufacturers',[

    ManufacturerController::class,

    'index'

])
->name('manufacturers.index');




Route::get('/stores',[

    StoreController::class,

    'index'

])
->name('stores.index');




Route::get('/technicians',[

    TechnicianController::class,

    'index'

])
->name('technicians.index');




Route::get('/projects',[

    ProjectController::class,

    'index'

])
->name('projects.index');









/*
|--------------------------------------------------------------------------
| Public Profiles
|--------------------------------------------------------------------------
*/


Route::get('/company/{slug}', [

    CompanyController::class,

    'show'

])
->name('company.profile');




Route::get('/manufacturer/{slug}', [

    ManufacturerController::class,

    'show'

])
->name('manufacturer.profile');




Route::get('/store/{slug}', [

    StoreController::class,

    'show'

])
->name('store.profile');




Route::get('/technician/{slug}', [

    TechnicianController::class,

    'show'

])
->name('technician.profile');




Route::get('/project/{slug}', [

    ProjectController::class,

    'show'

])
->name('project.profile');









/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/


Route::middleware([

    'auth',

    'admin'

])

->prefix('admin')

->group(function(){



    Route::get('/users',[

        AdminController::class,

        'users'

    ])
    ->name('admin.users');





    Route::post('/users/{user}/approve',[

        AdminController::class,

        'approve'

    ])
    ->name('admin.users.approve');





    Route::post('/users/{user}/reject',[

        AdminController::class,

        'reject'

    ])
    ->name('admin.users.reject');



});
