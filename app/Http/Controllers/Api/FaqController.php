<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * ===============================
     * Public Endpoint
     * ===============================
     */

    // Lihat FAQ (dijawab saja, filter by kategori opsional)
    public function index(Request $request)
    {
        $query = Faq::where('status', 'dijawab')->with('kategori');

        if ($request->kategori) {
            $query->where('id_faq_kategori', $request->kategori);
        }

        return response()->json($query->get());
    }

    // Submit pertanyaan baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pertanyaan' => 'required|string',
            'id_faq_kategori' => 'required|exists:faq_kategori,id_faq_kategori',
        ]);

        $faq = Faq::create([
            'pertanyaan' => $validated['pertanyaan'],
            'id_faq_kategori' => $validated['id_faq_kategori'],
            'status' => 'pending',
        ]);

        return response()->json($faq, 201);
    }

    // Cari FAQ berdasarkan keyword
    public function search(Request $request)
    {
        $keyword = $request->query('q');

        $faq = Faq::where('status', 'dijawab')
            ->where(function ($q) use ($keyword) {
                $q->where('pertanyaan', 'like', "%$keyword%")
                  ->orWhere('jawaban', 'like', "%$keyword%");
            })
            ->with('kategori')
            ->get();

        return response()->json($faq);
    }

    // Filter FAQ berdasarkan kategori
    public function byKategori($idKategori)
    {
        $faq = Faq::where('id_faq_kategori', $idKategori)
            ->where('status', 'dijawab')
            ->with('kategori')
            ->get();

        return response()->json($faq);
    }

    /**
     * ===============================
     * Admin Endpoint
     * ===============================
     */

    // List semua pertanyaan (dengan kategori & admin penjawab)
    public function adminIndex()
    {
        return response()->json(
            Faq::with(['kategori', 'admin'])->get()
        );
    }

    // List pertanyaan pending
    public function pending()
    {
        $faq = Faq::where('status', 'pending')
            ->with('kategori')
            ->get();

        return response()->json($faq);
    }

    // Jawab pertanyaan
    public function jawab(Request $request, $id)
    {
        $request->validate([
            'jawaban' => 'required|string',
        ]);

        $faq = Faq::findOrFail($id);
        $faq->jawaban = $request->jawaban;
        $faq->status = 'dijawab';
        $faq->answered_by = auth()->id();
        $faq->save();

        return response()->json($faq);
    }

    // Tolak pertanyaan
    public function tolak($id)
    {
        $faq = Faq::findOrFail($id);
        $faq->status = 'ditolak';
        $faq->answered_by = auth()->id();
        $faq->save();

        return response()->json($faq);
    }

    // Hapus satu pertanyaan
    public function destroy($id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();

        return response()->json(['message' => 'FAQ deleted']);
    }

    // Hapus semua FAQ public (status = dijawab)
    public function deletePublic()
    {
        $deleted = Faq::where('status', 'dijawab')->delete();

        return response()->json([
            'message' => 'Semua FAQ public berhasil dihapus',
            'total_deleted' => $deleted
        ]);
    }
}
