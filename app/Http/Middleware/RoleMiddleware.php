<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed ...$roles
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();

        // cek apakah user login dan punya role
        if (!$user || !$user->role) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // cek apakah role user ada di daftar roles
        if (!in_array($user->role->nm_role, $roles)) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return $next($request);
    }
}
