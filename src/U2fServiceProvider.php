<?php

namespace Certly\U2f;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class U2fServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $routeConfig = [
            'namespace'  => '\Certly\U2f\Http\Controllers',
            'prefix'     => '/u2f/',
            'middleware' => ['web', $this->app[ 'config' ]->get('u2f.authMiddlewareName', 'auth')],
        ];

        $this->app[ 'router' ]->group($routeConfig, function (Router $router) {
            $router->get('register', [
                'uses'       => 'U2fController@registerData',
                'as'         => 'u2f.register.data',
                'middleware' => 'u2f',
            ]);
            $router->post('register', [
                'uses'       => 'U2fController@register',
                'as'         => 'u2f.register',
                'middleware' => 'u2f',
            ]);

            $router->get('auth', [
                'uses' => 'U2fController@authData',
                'as'   => 'u2f.auth.data',
            ]);
            $router->post('auth', [
                'uses' => 'U2fController@auth',
                'as'   => 'u2f.auth',
            ]);
        });

        $this->publishes([
            __DIR__.'/../database/migrations/' => base_path('/database/migrations'),
        ], 'migrations');

        $this->publishes([(__DIR__.'/../config/u2f.php') => config_path('u2f.php')], 'config');

        $this->publishes([
            __DIR__.'/../resources/js' => base_path('/resources/js/u2f'),
        ], 'public');

        $this->publishes([
            __DIR__.'/../views' => base_path('/resources/views/u2f'),
        ], 'views');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'u2f');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $app = $this->app;
        $this->app->bind('u2f', function () use ($app) {

            return new U2f($app->make('config'), $this->app->make('session'));
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['u2f'];
    }
}
