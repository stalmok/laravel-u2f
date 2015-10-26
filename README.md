# laravel-u2f
Integrate FIDO U2F into Laravel 5.x applications. You'll need to be accessing your application from an [App ID compliant](https://developers.yubico.com/U2F/App_ID.html) domain; `localhost` support is finicky.

## Install

Via Composer

``` bash
composer require certly/laravel-u2f
```

### Provider

In the config/app.php file:
``` php
[
    // ...
    Certly\U2f\LaravelU2fServiceProvider::class,
    // ...
]
```

### Alias

In the config/app.php file:
``` php
[
    // ...
    'U2f' => Certly\U2f\U2fServiceFacade::class,
    // ...
]
```

### Publishing resources
This will copy the needed resources to your project so you can modify them.

``` bash
$ php artisan vendor:publish --provider="Certly\U2f\U2fServiceProvider"
$ php artisan migrate
```

### Middleware

In the app/Http/Kernel.php file

``` php
protected $routeMiddleware = [
    // ...
    'u2f' => Certly\U2f\Http\Middleware\U2f::class,
];
```

## Usage

### Middleware
``` php
    Route::get('admin/profile', ['middleware' => ['auth', 'u2f'], function () {
        //
    }]);
```
### Configuration
`config/u2f.php` is commented and will be created when you publish the provider via the above command.

## Security
Security issues can be reported via [HackerOne](https://hackerone.com/certly) or via email at [ian@certly.io](mailto:ian@certly.io).

## Credits
- [Arnaud LAHAXE](https://github.com/lahaxearnaud)
- [Ian Carroll](https://github.com/iangcarroll)

## License  
[MIT](LICENSE.md)
