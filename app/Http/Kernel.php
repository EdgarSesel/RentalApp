<?php

namespace App\Http;

use App\Http\Middleware\CheckAdmin;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middleware = [
        // Add your global middleware here
    ];

    protected $middlewareGroups = [
        'web' => [
            // Add your 'web' middleware group here
        ],

        'api' => [
            // Add your 'api' middleware group here
        ],
    ];

    protected $routeMiddleware = [
        // Add your route middleware here
        'admin' => CheckAdmin::class,
    ];
}
