<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    // Lihat semua FAQ publik
    public function index(Request $request)
    {
        $query = Faq::where('status', 'dijawab')->with('kategori');

        if ($request->kategori) {
            $query->where('id_faq_kategori', $request->kategori);
        }

        return response()->json($query->get());
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
}
