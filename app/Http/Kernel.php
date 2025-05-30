<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

class Kernel extends HttpKernel
{
    /**
     * These middleware run on every request.
     */
    protected $middleware = [
        // (leave empty for pure API)
    ];

    /**
     * Grouped middleware for "web" and "api" routes.
     */
    protected $middlewareGroups = [
        'web' => [
            // (no web middleware needed)
        ],

        'api' => [
            // Sanctum (optional if you only use token guard, but safe)
            EnsureFrontendRequestsAreStateful::class,
            // throttle = rate limiting
            'throttle:api',
            // route-model binding, etc.
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * Route-level middleware you can assign to routes or groups.
     */
    protected $routeMiddleware = [
        // built-in auth guard
        'auth' => \App\Http\Middleware\Authenticate::class,
            //'auth'        => \Illuminate\Auth\Middleware\Authenticate::class,
         'is.seller' => \App\Http\Middleware\IsSeller::class,
         'is.customer' => \App\Http\Middleware\IsCustomer::class,

        // you can add more here if you generate them later
    ];
    
}


