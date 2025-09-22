<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RiwayatDisposisi;
use App\Models\Pertanyaan;
use Illuminate\Http\Request;

class RiwayatDisposisiController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'pertanyaan_id' => 'required|exists:pertanyaan,id',
            'admin_fungsi_id' => 'required|integer',
            'catatan' => 'nullable|string',
        ]);

        $riwayat = RiwayatDisposisi::create($request->only(['pertanyaan_id', 'admin_fungsi_id', 'catatan']));

        $pertanyaan = Pertanyaan::find($request->pertanyaan_id);
        $pertanyaan->update([
            'status' => 'disposisi',
            'admin_fungsi_id' => $request->admin_fungsi_id,
        ]);

        return response()->json([
            'message' => 'Pertanyaan berhasil didisposisikan',
            'data' => $riwayat,
        ], 201);
    }

    public function showByPertanyaan($pertanyaan_id)
    {
        return response()->json(
            RiwayatDisposisi::where('pertanyaan_id', $pertanyaan_id)->get()
        );
    }
}
