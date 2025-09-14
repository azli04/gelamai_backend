<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FaqKategori;

class FaqKategoriController extends Controller
{
    /**
     * Tampilkan semua kategori FAQ
     */
    public function index()
    {
        return response()->json(FaqKategori::all());
    }

    /**
     * Tambah kategori FAQ baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'admin_role_id' => 'required|exists:roles,id_role',
            'deskripsi' => 'nullable|string',
        ]);

        $kategori = FaqKategori::create($validated);
        return response()->json($kategori, 201);
    }

    /**
     * Update kategori FAQ
     */
    public function update(Request $request, $id)
    {
        $kategori = FaqKategori::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'admin_role_id' => 'required|exists:roles,id_role',
            'deskripsi' => 'nullable|string',
        ]);

        $kategori->update($validated);
        return response()->json($kategori);
    }

    /**
     * Hapus kategori FAQ
     */
    public function destroy($id)
    {
        $kategori = FaqKategori::findOrFail($id);
        $kategori->delete();

        return response()->json(['message' => 'Kategori deleted']);
    }
}
