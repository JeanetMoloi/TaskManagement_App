<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * RoleMiddlewarePTJ
 *
 * Custom middleware for role-based access control.
 * Usage in routes: ->middleware('role:admin')
 *                  ->middleware('role:admin,team_member')
 *
 * Register this in bootstrap/app.php (Laravel 12):
 *   ->withMiddleware(function (Middleware $middleware) {
 *       $middleware->alias(['role' => RoleMiddlewarePTJ::class]);
 *   })
 */
class RoleMiddlewarePTJ
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles  One or more allowed roles (comma-separated in route definition)
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Make sure the user is authenticated first
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Check if the user's role matches any of the allowed roles
        if (!in_array($user->role, $roles)) {
            // Return 403 Forbidden with a friendly message
            abort(403, 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}
