<?php

namespace App\Http\Controllers;

use App\Models\Pertanyaan;
use Illuminate\Http\Request;

class PertanyaanController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_user' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'isi' => 'required|string',
        ]);

        $pertanyaan = Pertanyaan::create($data);

        return response()->json([
            'message' => 'Pertanyaan berhasil dikirim',
            'data' => $pertanyaan,
        ], 201);
    }

    public function index()
    {
        return response()->json(Pertanyaan::orderBy('created_at', 'desc')->paginate(15));
    }

    public function show($id)
    {
        return response()->json(Pertanyaan::findOrFail($id));
    }
}
    