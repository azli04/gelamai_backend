<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Aplikasi;
use Illuminate\Http\Request;

class AplikasiController extends Controller
{
    public function index()
    {
        return response()->json(Aplikasi::all());
    }

    public function store(Request $request)
{
    try {
        $data = $request->validate([
            'nama_app' => 'required|string|max:50',
            'url' => 'nullable|string',
            'image' => 'nullable|string',
            'kategori' => 'required|in:internal,eksternal,lainnya',
        ]);

        $aplikasi = Aplikasi::create($data);

        return response()->json($aplikasi, 201);
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
}


    public function show($id)
    {
        $aplikasi = Aplikasi::findOrFail($id);
        return response()->json($aplikasi);
    }

    public function update(Request $request, $id)
    {
        $aplikasi = Aplikasi::findOrFail($id);

        $data = $request->validate([
            'nama_app' => 'sometimes|string|max:50',
            'url' => 'nullable|string',
            'image' => 'nullable|string',
            'kategori' => 'sometimes|in:internal,eksternal,lainnya',
        ]);

        $aplikasi->update($data);

        return response()->json($aplikasi);
    }

    public function destroy($id)
    {
        $aplikasi = Aplikasi::findOrFail($id);
        $aplikasi->delete();

        return response()->json(['message' => 'Aplikasi deleted successfully']);
    }
}
