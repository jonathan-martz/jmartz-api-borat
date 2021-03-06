<?php

require_once __DIR__.'/../vendor/autoload.php';

try {
    (new Laravel\Lumen\Bootstrap\LoadEnvironmentVariables(
        dirname(__DIR__)
    ))->bootstrap();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

$app = new Laravel\Lumen\Application(
    realpath(__DIR__.'/../')
);

$app->withFacades();
$app->withEloquent();

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

$app->routeMiddleware([
    'auth' => App\Http\Middleware\Authenticate::class,
    'xss' => App\Http\Middleware\Xss::class,
    'https' => App\Http\Middleware\Https::class
]);

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/

/**
 * @todo create own module to auto register provider
 */
$app->register(App\Providers\AppServiceProvider::class);
$app->register(App\Providers\BoratProvider::class);
$app->register(App\Providers\BaseRoleProvider::class);
$app->register(App\Providers\UserRoleProvider::class);
$app->register(App\Providers\AdminRoleProvider::class);
$app->register(App\Providers\ModelUserProvider::class);
$app->register(App\Providers\RegisterProvider::class);
$app->register(App\Providers\LoginProvider::class);
$app->register(App\Providers\BoratReposProvider::class);
$app->register(App\Providers\AuthServiceProvider::class);
$app->register(App\Providers\UserProvider::class);
$app->register(App\Providers\BoratCacheProvider::class);
$app->register(App\Providers\BoratMailProvider::class);
$app->register(App\Providers\BoratAdminProvider::class);
$app->register(App\Providers\AdminActivateProvider::class);
$app->register(App\Providers\ControllerProvider::class);
$app->register(Illuminate\Mail\MailServiceProvider::class);
$app->register(App\Providers\CommandBoratProvider::class);

/*
 * Load Mailer stuff
 */
$app->alias('mailer', Illuminate\Mail\Mailer::class);
$app->alias('mailer', Illuminate\Contracts\Mail\Mailer::class);
$app->alias('mailer', Illuminate\Contracts\Mail\MailQueue::class);

/*
 * Load Config Files
 */
$app->configure('github');
$app->configure('mail');
$app->configure('database');
$app->configure('filesystems');

/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/
$app->router->group([
    'namespace' => 'App\Http\Controllers',
], function ($router) {
    require __DIR__.'/../routes/web.php';
});


return $app;
