<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsSuperAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->role && Auth::user()->role->nm_role === 'Super Admin') {
            return $next($request);
        }

        return response()->json(['message' => 'Forbidden, only Super Admin can access this resource'], 403);
    }
}

