<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Whistleblowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WhistleblowingController extends Controller
{
    /**
     * 🔹 [PUBLIC TANPA LOGIN] Kirim laporan whistleblowing
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap_user' => 'required|string|max:75',
            'profesi' => 'nullable|string|max:50',
            'alamat' => 'nullable|string|max:100',
            'tgl_lahir' => 'nullable|date',
            'email' => 'required|email|max:50',
            'kontak' => 'required|string|max:15',
            'indikasi_pelanggaran' => 'required|string',
            'lokasi_pelanggaran' => 'nullable|string',
            'oknum_pelanggaran' => 'nullable|string|max:100',
            'kronologi' => 'required|string',
            'data_pendukung' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120'
        ]);

        // Upload file jika ada
        if ($request->hasFile('data_pendukung')) {
            $validated['data_pendukung'] = $request->file('data_pendukung')
                ->store('whistleblowing', 'public');
        }

        // Simpan laporan baru
        $laporan = Whistleblowing::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Laporan whistleblowing berhasil dikirim.',
            'data' => $laporan
        ], 201);
    }

    /**
     * 🔹 [ADMIN, KEPALA, SUPER ADMIN] Ambil semua laporan whistleblowing
     */
    public function index()
    {
        $laporan = Whistleblowing::orderByDesc('created_at')->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar laporan whistleblowing',
            'data' => $laporan
        ]);
    }

    /**
     * 🔹 [ADMIN, KEPALA, SUPER ADMIN] Lihat detail laporan
     */
    public function show($id)
    {
        $laporan = Whistleblowing::find($id);

        if (!$laporan) {
            return response()->json([
                'success' => false,
                'message' => 'Laporan tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $laporan
        ]);
    }

    /**
     * 🔹 [ADMIN WB / SUPER ADMIN] Update status laporan
     */
    public function update(Request $request, $id)
    {
        $laporan = Whistleblowing::find($id);

        if (!$laporan) {
            return response()->json([
                'success' => false,
                'message' => 'Laporan tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'status' => 'required|in:baru,proses,selesai'
        ]);

        $laporan->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Status laporan berhasil diperbarui',
            'data' => $laporan
        ]);
    }

    /**
     * 🔹 [SUPER ADMIN] Hapus laporan
     */
    public function destroy($id)
    {
        $laporan = Whistleblowing::find($id);

        if (!$laporan) {
            return response()->json([
                'success' => false,
                'message' => 'Laporan tidak ditemukan'
            ], 404);
        }

        // Hapus file jika ada
        if ($laporan->data_pendukung && Storage::disk('public')->exists($laporan->data_pendukung)) {
            Storage::disk('public')->delete($laporan->data_pendukung);
        }

        $laporan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Laporan berhasil dihapus'
        ]);
    }
}
