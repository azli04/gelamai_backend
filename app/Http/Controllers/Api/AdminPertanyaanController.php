<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pertanyaan;
use App\Models\Faq;
use App\Models\RiwayatDisposisi;
use Illuminate\Http\Request;

class AdminPertanyaanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pertanyaan::query();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('fungsi_id')) {
            $query->where('fungsi_id', $request->fungsi_id);
        }

        return response()->json($query->latest()->get());
    }

    public function jawabLangsung(Request $request, $id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id);
        $request->validate(['jawaban' => 'required|string']);

        $pertanyaan->update([
            'jawaban' => $request->jawaban,
            'status' => 'dijawab web'
        ]);

        return response()->json(['message' => 'Pertanyaan dijawab langsung', 'data' => $pertanyaan]);
    }

    public function disposisi(Request $request, $id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id);
        $request->validate(['fungsi_id' => 'required|exists:users,id']);

        $pertanyaan->update([
            'fungsi_id' => $request->fungsi_id,
            'status' => 'disposisi'
        ]);

        RiwayatDisposisi::create([
            'pertanyaan_id' => $pertanyaan->id,
            'dari_user_id' => auth()->id(),
            'ke_user_id' => $request->fungsi_id,
            'catatan' => $request->catatan ?? null
        ]);

        return response()->json(['message' => 'Pertanyaan didisposisi', 'data' => $pertanyaan]);
    }

    public function reviewJawaban(Request $request, $id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id);
        $request->validate(['jawaban' => 'required|string']);

        $pertanyaan->update(['jawaban' => $request->jawaban]);

        return response()->json(['message' => 'Jawaban berhasil direview', 'data' => $pertanyaan]);
    }

    public function publishToFaq($id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id);

        if (!$pertanyaan->jawaban) {
            return response()->json(['message' => 'Jawaban belum tersedia'], 400);
        }

        $faq = Faq::create([
            'pertanyaan' => $pertanyaan->isi_pertanyaan,
            'jawaban' => $pertanyaan->jawaban,
            'status' => true,
            'pertanyaan_id' => $pertanyaan->id,
            'published_by' => auth()->id(),
        ]);

        $pertanyaan->update(['status' => 'selesai']);

        return response()->json(['message' => 'Dipublish ke FAQ', 'data' => $faq]);
    }
}
