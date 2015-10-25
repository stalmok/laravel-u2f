<?php
/**
     * User: LAHAXE Arnaud
     * Date: 18/05/2015
     * Time: 17:49
     * FileName : u2f.php
     * Project : laravel-u2f
     */

return [
    /*
     * Enable the u2f middleware, if false the middleware will not redirect to the u2f authentication page
     */
    'enable' => true,

    /*
     * Do not redirect user without u2f key to the authentication page after login
     */
    'byPassUserWithoutKey' => true,

    /*
     * The sessionU2fName attribute will be set to true when the user validates a u2f
     */
    'sessionU2fName' => 'otp',

    /*
     * Controller configuration
     */
    'register' => [
        /*
         * the template to load for the registration page
         */
        'view' => 'u2f.register',

        /*
         * the route to redirect after a successful key registration (default /)
         */
        'postSuccessRedirectRoute' => '',

    ],

    'authenticate' => [
        /*
         * the authentication page template
         */
        'view' => 'u2f.authentication',

        /*
         * the route to redirect after a successful key authentication (default /)
         */
        'postSuccessRedirectRoute' => '',
    ],

    /*
     * The authenticate middleware. If the request is valid for this middleware we
     * can get the current user by Auth::user()
     */
    'authMiddlewareName' => 'auth'
];
