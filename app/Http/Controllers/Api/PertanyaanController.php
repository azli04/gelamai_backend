<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pertanyaan;
use Illuminate\Http\Request;

class PertanyaanController extends Controller
{
    // Submit pertanyaan baru dari user
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pertanyaan' => 'required|string',
            'id_faq_kategori' => 'required|exists:faq_kategori,id_faq_kategori',
        ]);

        $pertanyaan = Pertanyaan::create([
            'pertanyaan' => $validated['pertanyaan'],
            'id_faq_kategori' => $validated['id_faq_kategori'],
            'status' => 'pending',
        ]);

        return response()->json($pertanyaan, 201);
    }

    // List semua pertanyaan (untuk admin)
    public function adminIndex()
    {
        return response()->json(
            Pertanyaan::with(['kategori', 'admin'])->get()
        );
    }

    // List pertanyaan pending
    public function pending()
    {
        $pertanyaan = Pertanyaan::where('status', 'pending')
            ->with('kategori')
            ->get();

        return response()->json($pertanyaan);
    }

    // Jawab pertanyaan
    public function jawab(Request $request, $id)
    {
        $request->validate([
            'jawaban' => 'required|string',
        ]);

        $pertanyaan = Pertanyaan::findOrFail($id);
        $pertanyaan->jawaban = $request->jawaban;
        $pertanyaan->status = 'dijawab';
        $pertanyaan->answered_by = auth()->id();
        $pertanyaan->save();

        return response()->json($pertanyaan);
    }

    // Tolak pertanyaan
    public function tolak($id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id);
        $pertanyaan->status = 'ditolak';
        $pertanyaan->answered_by = auth()->id();
        $pertanyaan->save();

        return response()->json($pertanyaan);
    }

    // Hapus pertanyaan
    public function destroy($id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id);
        $pertanyaan->delete();

        return response()->json(['message' => 'Pertanyaan deleted']);
    }
}
