<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pertanyaan;
use Illuminate\Http\Request;

class AdminFungsiController extends Controller
{
    public function index()
    {
        $pertanyaan = Pertanyaan::where('fungsi_id', auth()->id())
            ->where('status', 'disposisi')
            ->latest()->get();

        return response()->json($pertanyaan);
    }

    public function jawabPertanyaan(Request $request, $id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id);

        if ($pertanyaan->fungsi_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate(['jawaban' => 'required|string']);

        $pertanyaan->update([
            'jawaban' => $request->jawaban,
            'status' => 'dijawab fungsi'
        ]);

        return response()->json(['message' => 'Jawaban fungsi disimpan', 'data' => $pertanyaan]);
    }
}

