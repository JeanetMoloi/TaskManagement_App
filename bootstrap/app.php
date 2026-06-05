<?php

use App\Http\Middleware\RoleMiddlewarePTJ;
use App\Http\Middleware\LogActivityMiddlewarePTJ;
use App\Models\Task;
use App\Policies\TaskPolicyPTJ;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Gate;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role'         => RoleMiddlewarePTJ::class,
            'log.activity' => LogActivityMiddlewarePTJ::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->booted(function () {
        Gate::policy(Task::class, TaskPolicyPTJ::class);
    })
    ->create();