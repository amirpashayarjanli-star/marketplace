<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;


$app = Application::configure(basePath: dirname(__DIR__))

    ->withRouting(

        web: __DIR__.'/../routes/web.php',

        commands: __DIR__.'/../routes/console.php',

        health: '/up',

    )


    ->withMiddleware(function (Middleware $middleware): void {


        $middleware->alias([

            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'approved' => \App\Http\Middleware\EnsureUserApproved::class,

        ]);


    })


    ->withExceptions(function (Exceptions $exceptions): void {


        $exceptions->shouldRenderJsonWhen(

            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),

        );


    })

    ->create();

// روی هاست، پوشه‌ی public جدا از ریشه‌ی برنامه است (public_html کنار asansorpro_app،
// نه زیرپوشه‌ش)، برای همین لاراول باید بدونه فایل‌های build/manifest.json واقعاً کجان.
// DOCUMENT_ROOT همون پوشه‌ایه که وب‌سرور واقعاً ازش سرو می‌کنه، پس همیشه درسته.
if (! empty($_SERVER['DOCUMENT_ROOT']) && is_dir($_SERVER['DOCUMENT_ROOT'])) {
    $app->usePublicPath($_SERVER['DOCUMENT_ROOT']);
}

return $app;
