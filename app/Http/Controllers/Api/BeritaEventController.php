<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BeritaEvent;
use Illuminate\Http\Request;

class BeritaEventController extends Controller
{
    public function index()
    {
        try {
            $berita = BeritaEvent::orderBy('tanggal', 'desc')->get();
            return response()->json(['success' => true, 'data' => $berita]);
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
                'tipe'    => 'required|in:berita,event',
                'tanggal' => 'nullable|date',
            ]);

            $berita = BeritaEvent::create($data);

            return response()->json(['success' => true, 'data' => $berita], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $berita = BeritaEvent::findOrFail($id);
            return response()->json(['success' => true, 'data' => $berita]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $berita = BeritaEvent::findOrFail($id);
            $data = $request->validate([
                'judul'   => 'sometimes|string|max:150',
                'isi'     => 'sometimes|string',
                'gambar'  => 'nullable|string',
                'tipe'    => 'sometimes|in:berita,event',
                'tanggal' => 'nullable|date',
            ]);

            $berita->update($data);

            return response()->json(['success' => true, 'data' => $berita]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $berita = BeritaEvent::findOrFail($id);
            $berita->delete();
            return response()->json(['success' => true, 'message' => 'Berita/Event berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
