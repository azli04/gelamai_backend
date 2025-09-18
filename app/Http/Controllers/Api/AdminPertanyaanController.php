<?php

namespace App\Http\Controllers\Api;

use App\Models\Pertanyaan;
use App\Models\Faq;
use Illuminate\Http\Request;

class AdminPertanyaanController extends Controller
{
    // List semua pertanyaan
    public function index()
    {
        $data = Pertanyaan::with('kategori')->latest()->get();
        return response()->json($data);
    }

    // Admin jawab pertanyaan -> publish ke FAQ
    public function jawab(Request $request, $id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id);

        $validated = $request->validate([
            'jawaban'         => 'required|string',
            'id_faq_kategori' => 'required|exists:faq_kategori,id_faq_kategori',
        ]);

        $faq = Faq::create([
            'pertanyaan'      => $pertanyaan->isi_pertanyaan,
            'jawaban'         => $validated['jawaban'],
            'status'          => 'dijawab',
            'id_faq_kategori' => $validated['id_faq_kategori'],
            'answered_by'     => auth()->id(),
            'id_pertanyaan'   => $pertanyaan->id_pertanyaan,
        ]);

        $pertanyaan->update(['status' => 'dijawab']);

        return response()->json([
            'message' => 'Pertanyaan berhasil dijawab & dipublikasikan ke FAQ',
            'data'    => $faq
        ]);
    }

    // Admin tolak pertanyaan
    public function tolak($id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id);
        $pertanyaan->update(['status' => 'ditolak']);

        return response()->json([
            'message' => 'Pertanyaan berhasil ditolak'
        ]);
    }
}
