<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pertanyaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PertanyaanController extends Controller
{
    /**
     * Submit pertanyaan (Public - tanpa login)
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:255',
            'profesi' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'email' => 'required|email|max:255',
            'no_hp' => 'required|string|max:20',
            'topik' => 'required|string|max:255',
            'isi_pertanyaan' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $pertanyaan = Pertanyaan::create($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Pertanyaan berhasil dikirim. Tim kami akan segera merespons.',
            'data' => $pertanyaan
        ], 201);
    }

    /**
     * List semua pertanyaan (Admin only)
     */
    public function index(Request $request)
    {
        $query = Pertanyaan::query();

        // Filter berdasarkan status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan topik
        if ($request->has('topik')) {
            $query->where('topik', 'like', '%' . $request->topik . '%');
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('isi_pertanyaan', 'like', '%' . $search . '%');
            });
        }

        $pertanyaan = $query->orderBy('created_at', 'desc')
                           ->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $pertanyaan
        ]);
    }

    /**
     * Detail pertanyaan (Admin only)
     */
    public function show($id)
    {
        $pertanyaan = Pertanyaan::with('faq')->find($id);

        if (!$pertanyaan) {
            return response()->json([
                'success' => false,
                'message' => 'Pertanyaan tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $pertanyaan
        ]);
    }

    /**
     * Update status pertanyaan (Admin only)
     */
    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,processed,published,rejected'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $pertanyaan = Pertanyaan::find($id);

        if (!$pertanyaan) {
            return response()->json([
                'success' => false,
                'message' => 'Pertanyaan tidak ditemukan'
            ], 404);
        }

        $pertanyaan->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Status pertanyaan berhasil diperbarui',
            'data' => $pertanyaan
        ]);
    }

    /**
     * Delete pertanyaan (Admin only)
     */
    public function destroy($id)
    {
        $pertanyaan = Pertanyaan::find($id);

        if (!$pertanyaan) {
            return response()->json([
                'success' => false,
                'message' => 'Pertanyaan tidak ditemukan'
            ], 404);
        }

        $pertanyaan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pertanyaan berhasil dihapus'
        ]);
    }
}