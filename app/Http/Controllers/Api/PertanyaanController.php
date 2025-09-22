<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pertanyaan;
use Illuminate\Http\Request;

class PertanyaanController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'profesi' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'no_hp' => 'nullable|string|max:20',
            'topik' => 'nullable|string|max:255',
            'isi_pertanyaan' => 'required|string',
        ]);

        $pertanyaan = Pertanyaan::create(array_merge(
            $request->all(),
            ['status' => Pertanyaan::STATUS_MENUNGGU]
        ));

        return response()->json([
            'message' => 'Pertanyaan berhasil dikirim',
            'data' => $pertanyaan,
        ], 201);
    }

    public function index(Request $request)
    {
        $query = Pertanyaan::with('faq')->latest();

        // filter status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // filter admin fungsi
        if ($request->admin_fungsi_id) {
            $query->where('admin_fungsi_id', $request->admin_fungsi_id);
        }

        return response()->json($query->get());
    }

    public function show($id)
    {
        $pertanyaan = Pertanyaan::with('faq')->findOrFail($id);
        return response()->json($pertanyaan);
    }

    public function update(Request $request, $id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id);

        $pertanyaan->update($request->only([
            'status', 'jawaban', 'admin_fungsi_id'
        ]));

        return response()->json([
            'message' => 'Pertanyaan berhasil diperbarui',
            'data' => $pertanyaan,
        ]);
    }
}
