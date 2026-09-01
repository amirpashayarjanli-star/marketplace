<?php


use Illuminate\Support\Facades\Route;


use App\Http\Controllers\HomeController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProfileWizardController;

use App\Http\Controllers\DashboardController;

use App\Http\Controllers\ProjectDashboardController;
use App\Http\Controllers\ProjectInquiryController;
use App\Http\Controllers\ProjectInquiryManageController;

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ManufacturerController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SearchController;

use App\Http\Controllers\AuctionController;
use App\Http\Controllers\AuctionDashboardController;
use App\Http\Controllers\BidController;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminServiceController;

use App\Http\Controllers\CustomerProfileController;
use App\Http\Controllers\ServiceRequestController;
use App\Http\Controllers\TechnicianServiceJobController;
use App\Http\Controllers\WalletController;

use App\Services\NavasanService;



/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/


/*
| نقشه‌ی سایت — به گوگل کمک می‌کند صفحه‌های واقعی را ببیند و نشانی‌های
| فروشگاه وردپرسی قدیمی را از ایندکس کنار بگذارد.
*/
Route::get('/sitemap.xml', [
    App\Http\Controllers\SitemapController::class,
    'index'
])->name('sitemap');


Route::get('/', [

    HomeController::class,

    'index'

])
->name('home');










/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/


Route::middleware(['auth', 'approved'])->group(function () {



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




    /*
    |--------------------------------------------------------------------------
    | پرو مزایده — سمت کارفرما
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard/auctions', [
        AuctionDashboardController::class,
        'index'
    ])->name('dashboard.auctions');

    Route::get('/dashboard/auctions/create', [
        AuctionDashboardController::class,
        'create'
    ])->name('dashboard.auctions.create');

    Route::post('/dashboard/auctions', [
        AuctionDashboardController::class,
        'store'
    ])->name('dashboard.auctions.store');

    Route::get('/dashboard/auctions/{auction}', [
        AuctionDashboardController::class,
        'show'
    ])->name('dashboard.auctions.show');

    Route::post('/dashboard/auctions/{auction}/request-callback', [
        AuctionDashboardController::class,
        'requestCallback'
    ])->name('dashboard.auctions.callback');

    Route::post('/dashboard/auctions/{auction}/pay-consultation', [
        AuctionDashboardController::class,
        'payConsultation'
    ])->name('dashboard.auctions.pay-consultation');

    Route::post('/dashboard/auctions/{auction}/award', [
        AuctionDashboardController::class,
        'award'
    ])->name('dashboard.auctions.award');

    Route::post('/dashboard/auctions/{auction}/cancel', [
        AuctionDashboardController::class,
        'cancel'
    ])->name('dashboard.auctions.cancel');




    /*
    |--------------------------------------------------------------------------
    | پرو مزایده — سمت پیشنهاددهنده
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard/bids', [
        BidController::class,
        'index'
    ])->name('dashboard.bids');

    Route::post('/auction/{auction}/bids', [
        BidController::class,
        'store'
    ])->name('auction.bids.store');

    Route::put('/dashboard/bids/{bid}', [
        BidController::class,
        'update'
    ])->name('dashboard.bids.update');

    Route::post('/dashboard/bids/{bid}/withdraw', [
        BidController::class,
        'withdraw'
    ])->name('dashboard.bids.withdraw');



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
])->middleware('throttle:5,1');

Route::post('/logout', [
    AuthController::class,
    'logout'
])->middleware('auth')->name('logout');





Route::get('/login/otp', [

    OtpController::class,

    'showLoginOtp'

])
->name('login.otp');




Route::post('/login/otp/send', [
    OtpController::class,
    'sendLoginOtp'
])->middleware('throttle:5,1')->name('login.otp.send');


Route::post('/login/otp', [
    OtpController::class,
    'verifyLoginOtp'
])->middleware('throttle:5,1');









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
])->middleware('throttle:5,1');




Route::get('/register/otp', [

    OtpController::class,

    'showRegisterOtp'

])
->name('register.otp');




Route::post('/register/otp/resend', [

    OtpController::class,

    'resendRegisterOtp'

])
->middleware('throttle:5,1')
->name('register.otp.resend');




Route::post('/register/otp', [
    OtpController::class,
    'verifyRegisterOtp'
])->middleware('throttle:5,1');




/*
|--------------------------------------------------------------------------
| ویزارد تکمیل پروفایل
|--------------------------------------------------------------------------
|
| عمداً پشت middleware 'approved' نیست — کاربری که هنوز پروفایلش کامل
| نشده باید بتواند به اینجا برسد تا کاملش کند.
|
*/

Route::middleware('auth')->group(function(){


    Route::get('/profile/setup/type',[

        ProfileWizardController::class,

        'chooseType'

    ])
    ->name('profile.wizard.type');




    Route::post('/profile/setup/type',[

        ProfileWizardController::class,

        'saveType'

    ])
    ->name('profile.wizard.type.store');




    Route::get('/profile/setup',[

        ProfileWizardController::class,

        'overview'

    ])
    ->name('profile.wizard');




    Route::post('/profile/setup/submit',[

        ProfileWizardController::class,

        'submit'

    ])
    ->name('profile.wizard.submit');




    Route::get('/profile/setup/{step}',[

        ProfileWizardController::class,

        'editStep'

    ])
    ->name('profile.wizard.step');




    Route::post('/profile/setup/{step}',[

        ProfileWizardController::class,

        'saveStep'

    ])
    ->name('profile.wizard.step.store');


});



















/*
|--------------------------------------------------------------------------
| پروسرویس — تکمیل پروفایل مشتری
|--------------------------------------------------------------------------
|
| مثل ویزارد کسب‌وکارها، پشت 'approved' نیست چون تا این فرم پر نشه
| کاربر اصلاً approved نمیشه.
|
*/

Route::middleware('auth')->group(function () {

    Route::get('/service/setup', [
        CustomerProfileController::class,
        'show'
    ])
    ->name('service.setup');


    Route::post('/service/setup', [
        CustomerProfileController::class,
        'store'
    ])
    ->name('service.setup.store');

});




/*
|--------------------------------------------------------------------------
| پروسرویس — سمت مشتری و تکنسین
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'approved'])->group(function () {

    Route::get('/service', [
        ServiceRequestController::class,
        'index'
    ])
    ->name('service.index');


    Route::get('/service/create', [
        ServiceRequestController::class,
        'create'
    ])
    ->name('service.create');


    Route::post('/service', [
        ServiceRequestController::class,
        'store'
    ])
    ->name('service.store');


    Route::get('/service/{serviceRequest}', [
        ServiceRequestController::class,
        'show'
    ])
    ->name('service.show');


    Route::post('/service/{serviceRequest}/technician', [
        ServiceRequestController::class,
        'chooseTechnician'
    ])
    ->name('service.technician');


    Route::post('/service/{serviceRequest}/confirm', [
        ServiceRequestController::class,
        'confirm'
    ])
    ->name('service.confirm');


    Route::get('/service-jobs', [
        TechnicianServiceJobController::class,
        'index'
    ])
    ->name('service.jobs');


    Route::get('/service-jobs/{serviceRequest}', [
        TechnicianServiceJobController::class,
        'show'
    ])
    ->name('service.jobs.show');


    Route::post('/service-jobs/{serviceRequest}/advance', [
        TechnicianServiceJobController::class,
        'advance'
    ])
    ->name('service.jobs.advance');


    Route::get('/wallet', [
        WalletController::class,
        'show'
    ])
    ->name('wallet');


    Route::post('/wallet/top-up', [
        WalletController::class,
        'topUp'
    ])
    ->middleware('throttle:10,1')
    ->name('wallet.topup');

});




/*
|--------------------------------------------------------------------------
| بازگشت از درگاه پرداخت
|--------------------------------------------------------------------------
|
| عمداً بیرون از 'approved' است — اگر وضعیت کاربر بین شروع پرداخت و بازگشت
| عوض شود، نباید پول پرداخت‌شده بی‌ثبت بماند.
|
*/

Route::get('/wallet/callback', [
    WalletController::class,
    'callback'
])
->middleware('auth')
->name('wallet.callback');




/*
|--------------------------------------------------------------------------
| Directory
|--------------------------------------------------------------------------
*/


Route::get('/search', [

    SearchController::class,

    'index'

])
->name('search');




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




Route::get('/auctions', [

    AuctionController::class,

    'index'

])
->name('auctions.index');




Route::get('/auction/{slug}', [

    AuctionController::class,

    'show'

])
->name('auction.show');









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

    /*
    | مسیر این بخش عمداً /admin/reviews نیست.
    | پنل Filament خودش روی /admin نشسته و یک ReviewResource دارد که
    | همان /admin/reviews را می‌گیرد. چون routes/web.php بعد از پنل
    | ثبت می‌شود، مسیر ما روی مسیر Filament می‌افتاد و روت
    | filament.admin.resources.reviews.index حذف می‌شد — نتیجه‌اش
    | خطای «Route not defined» در سایدبار و ۵۰۰ شدن کل پنل بود.
    | نام روت‌ها دست‌نخورده مانده، پس همه‌ی route('admin.reviews') ها کار می‌کنند.
    */

    Route::get('/review-approvals', [

        AdminController::class,

        'reviews'

    ])
    ->name('admin.reviews');

    Route::post('/review-approvals/{review}/approve', [

        AdminController::class,

        'approveReview'

    ])
    ->name('admin.reviews.approve');

    Route::delete('/review-approvals/{review}', [

        AdminController::class,

        'rejectReview'

    ])
    ->name('admin.reviews.reject');


    Route::get('/service-requests', [
        AdminServiceController::class,
        'index'
    ])
    ->name('admin.service.index');


    Route::get('/service-requests/{serviceRequest}', [
        AdminServiceController::class,
        'show'
    ])
    ->name('admin.service.show');


    Route::post('/service-requests/{serviceRequest}/invoice', [
        AdminServiceController::class,
        'saveInvoice'
    ])
    ->name('admin.service.invoice');


    Route::post('/service-requests/{serviceRequest}/technician', [
        AdminServiceController::class,
        'assignTechnician'
    ])
    ->name('admin.service.technician');


    Route::post('/service-requests/{serviceRequest}/cancel', [
        AdminServiceController::class,
        'cancel'
    ])
    ->name('admin.service.cancel');

});
