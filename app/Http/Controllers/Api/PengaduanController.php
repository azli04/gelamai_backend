<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TanggapanPengaduanMail;
use Illuminate\Support\Facades\Storage;

class PengaduanController extends Controller
{
    /**
     * 🔹 List semua pengaduan (untuk admin)
     */
    public function index()
    {
        $pengaduan = Pengaduan::with('admin:id_user,name')
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar pengaduan',
            'data' => $pengaduan,
        ]);
    }

    /**
     * 🔹 Simpan pengaduan baru (publik / frontend)
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'umur' => 'nullable|integer',
            'nama_perusahaan' => 'nullable|string|max:255',
            'jenis_perusahaan' => 'nullable|string|max:255',
            'jenis_pengaduan' => 'nullable|string|max:255',
            'jenis_produk' => 'nullable|string|max:255',
            'tanggal' => 'nullable|date',
            'jam' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'no_telepon' => 'nullable|string|max:50',
            'alamat' => 'nullable|string',
            'nama_produk' => 'nullable|string|max:255',
            'no_registrasi' => 'nullable|string|max:255',
            'kadaluarsa' => 'nullable|date',
            'nama_pabrik' => 'nullable|string|max:255',
            'alamat_pabrik' => 'nullable|string',
            'batch' => 'nullable|string|max:255',
            'pertanyaan' => 'nullable|string',
            'attachments.*' => 'nullable|file|max:5120', // max 5MB per file
        ]);

        // 🔹 Simpan file lampiran
        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $attachments[] = $file->store('pengaduan_attachments', 'public');
            }
        }

        $data['attachments'] = $attachments;
        $pengaduan = Pengaduan::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Pengaduan berhasil dikirim',
            'data' => $pengaduan,
        ], 201);
    }

    /**
     * 🔹 Lihat detail pengaduan
     */
    public function show($id)
    {
        $pengaduan = Pengaduan::with('admin:id_user,name')->findOrFail($id);

        // Tampilkan URL lampiran penuh
        if ($pengaduan->attachments) {
            $pengaduan->attachments = array_map(fn($a) => Storage::url($a), $pengaduan->attachments);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail pengaduan',
            'data' => $pengaduan,
        ]);
    }

    /**
     * 🔹 Update status & tanggapan (admin)
     */
    public function updateStatus(Request $request, $id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        $request->validate([
            'status' => 'required|in:baru,diproses,selesai',
            'tanggapan' => 'nullable|string',
        ]);

        $pengaduan->update([
            'status' => $request->status,
            'tanggapan' => $request->tanggapan,
            'ditanggapi_oleh' => auth()->id() ?? null,
            'tanggal_tanggapan' => now(),
        ]);

        // 🔹 Kirim email ke pelapor jika ada tanggapan
        if ($pengaduan->email && $request->filled('tanggapan')) {
            try {
                Mail::to($pengaduan->email)->send(new TanggapanPengaduanMail($pengaduan));
            } catch (\Exception $e) {
                // Log error tapi tetap return success
                \Log::error('Gagal kirim email: ' . $e->getMessage());
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Status pengaduan diperbarui',
            'data' => $pengaduan->load('admin:id_user,name'),
        ]);
    }

    /**
     * 🔹 Hapus pengaduan (admin)
     */
    public function destroy($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        // Hapus file lampiran
        if ($pengaduan->attachments) {
            foreach ($pengaduan->attachments as $file) {
                if (Storage::disk('public')->exists($file)) {
                    Storage::disk('public')->delete($file);
                }
            }
        }

        $pengaduan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pengaduan berhasil dihapus',
        ]);
    }
}