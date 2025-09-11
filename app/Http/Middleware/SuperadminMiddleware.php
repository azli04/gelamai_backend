<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SuperadminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()?->role?->nm_role !== 'Super Admin') {
            return response()->json(['message' => 'Forbidden, only Super Admin can access this resource'], 403);
        }

        return $next($request);
    }
}
