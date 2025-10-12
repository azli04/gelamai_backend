<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ChartLayanan;
use Illuminate\Http\Request;

class ChartLayananController extends Controller
{
    public function index()
    {
        return response()->json(ChartLayanan::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'label' => 'required|string',
            'value' => 'required|integer',
            'color' => 'required|string',
            'date'  => 'required|date',
        ]);

        $chart = ChartLayanan::create($data);
        return response()->json($chart, 201);
    }

    public function show($id)
    {
        return response()->json(ChartLayanan::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $chart = ChartLayanan::findOrFail($id);
        $chart->update($request->all());
        return response()->json($chart);
    }

    public function destroy($id)
    {
        ChartLayanan::destroy($id);
        return response()->json(['message' => 'Deleted successfully']);
    }
}
