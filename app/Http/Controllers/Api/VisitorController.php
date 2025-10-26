<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class VisitorController extends Controller
{
    public function stats()
    {
        $today = Carbon::today();
        $month = Carbon::now()->month;

        $todayCount = Visitor::whereDate('visited_date', $today)->count();
        $monthCount = Visitor::whereMonth('visited_date', $month)->count();
        $totalCount = Visitor::count();

        return response()->json([
            'today' => $todayCount,
            'month' => $monthCount,
            'total' => $totalCount,
        ]);
    }
}
