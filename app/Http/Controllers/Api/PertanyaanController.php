<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pertanyaan;
use Illuminate\Http\Request;

class PertanyaanController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'profesi' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'email' => 'nullable|email',
            'no_hp' => 'nullable|string|max:20',
            'topik' => 'nullable|string|max:255',
            'isi_pertanyaan' => 'required|string',
        ]);

        $pertanyaan = Pertanyaan::create($validated);

        return response()->json([
            'message' => 'Pertanyaan berhasil dikirim',
            'data' => $pertanyaan
        ], 201);
    }
}

