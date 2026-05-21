<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

/**
 * LogActivityMiddlewarePTJ
 *
 * Custom middleware that logs every authenticated request.
 * Useful for auditing who accessed/changed what and when.
 *
 * Logs to storage/logs/laravel.log (or configured log channel).
 *
 * Register in bootstrap/app.php:
 *   $middleware->alias(['log.activity' => LogActivityMiddlewarePTJ::class]);
 * Then use ->middleware('log.activity') on route groups that need auditing.
 */
class LogActivityMiddlewarePTJ
{
    public function handle(Request $request, Closure $next): Response
    {
        // Log the incoming request before it reaches the controller
        if (Auth::check()) {
            Log::channel('daily')->info('User Activity', [
                'user_id'    => Auth::id(),
                'user_email' => Auth::user()->email,
                'role'       => Auth::user()->role,
                'method'     => $request->method(),        // GET, POST, PUT, DELETE
                'url'        => $request->fullUrl(),
                'ip'         => $request->ip(),
                'user_agent' => $request->userAgent(),
                'timestamp'  => now()->toDateTimeString(),
            ]);
        }

        // Pass the request to the next middleware / controller
        $response = $next($request);

        return $response;
    }
}
