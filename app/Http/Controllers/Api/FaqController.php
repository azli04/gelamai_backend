<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Pertanyaan;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        return response()->json(Faq::with('pertanyaan')->latest()->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'pertanyaan_id' => 'required|exists:pertanyaan,id_pertanyaan',
            'jawaban' => 'required|string',
        ]);

        $faq = Faq::create([
            'pertanyaan_id' => $request->pertanyaan_id,
            'jawaban' => $request->jawaban,
        ]);

        $pertanyaan = Pertanyaan::findOrFail($request->pertanyaan_id);
        $pertanyaan->update([
            'status' => Pertanyaan::STATUS_SELESAI,
            'jawaban' => $request->jawaban,
        ]);

        return response()->json([
            'message' => 'FAQ berhasil dibuat',
            'data' => $faq,
        ], 201);
    }

    public function destroy($id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();

        return response()->json([
            'message' => 'FAQ berhasil dihapus'
        ]);
    }
}
