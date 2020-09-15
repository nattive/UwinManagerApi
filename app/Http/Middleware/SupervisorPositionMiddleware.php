<?php

namespace App\Http\Middleware;

use Closure;

class SupervisorPositionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = \auth()->user();
        if ($user->position == 'supervisor' || $user->position == 'director' ) {
            return $next($request);
        }
        return response()->json('You don\'t have the required permission', 401);
    }
}
