<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    public function index()
    {
        try {
            $artikel = Artikel::orderBy('tanggal', 'desc')->get();
            return response()->json(['success' => true, 'data' => $artikel]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'judul'   => 'required|string|max:150',
                'isi'     => 'required|string',
                'gambar'  => 'nullable|string',
                'tanggal' => 'nullable|date',
            ]);

            $artikel = Artikel::create($data);

            return response()->json(['success' => true, 'data' => $artikel], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $artikel = Artikel::findOrFail($id);

            // Tambah views otomatis setiap kali diakses
            $artikel->increment('views');

            return response()->json([
                'success' => true,
                'message' => 'Detail artikel',
                'data'    => $artikel
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $artikel = Artikel::findOrFail($id);
            $data = $request->validate([
                'judul'   => 'sometimes|string|max:150',
                'isi'     => 'sometimes|string',
                'gambar'  => 'nullable|string',
                'tanggal' => 'nullable|date',
            ]);

            $artikel->update($data);

            return response()->json(['success' => true, 'data' => $artikel]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $artikel = Artikel::findOrFail($id);
            $artikel->delete();
            return response()->json(['success' => true, 'message' => 'Artikel berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
