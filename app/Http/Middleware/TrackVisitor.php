<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Visitor;
use Carbon\Carbon;

class TrackVisitor
{
    public function handle(Request $request, Closure $next)
    {
        $ip = $request->ip();
        $today = Carbon::today();

        // Hanya simpan sekali per hari per IP
        $exists = Visitor::where('ip_address', $ip)
            ->whereDate('visited_date', $today)
            ->exists();

        if (!$exists) {
            Visitor::create([
                'ip_address' => $ip,
                'user_agent' => $request->userAgent(),
                'visited_date' => $today,
            ]);
        }

        return $next($request);
    }
}
