<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     */
    protected $middleware = [
        \App\Http\Middleware\SecureHeaders::class,
    ];

    /**
     * The application's route middleware groups.
     */
    protected $middlewareGroups = [
        'web' => [],
        'api' => [],
    ];

    /**
     * The application's middleware aliases.
     */
    protected $middlewareAliases = [];
}
