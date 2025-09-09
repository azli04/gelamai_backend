<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Pertanyaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPertanyaanController extends Controller
{
    public function index(Request $request)
    {
        $q = Pertanyaan::orderBy('created_at', 'desc');
        if ($request->has('status')) {
            $q->where('status', $request->status);
        }
        return response()->json($q->paginate(20));
    }

    public function jawabLangsung(Request $request, $id)
    {
        $p = Pertanyaan::findOrFail($id);
        $data = $request->validate([
            'jawaban' => 'required|string',
            'publish_to_faq' => 'sometimes|boolean'
        ]);

        $p->update([
            'jawaban' => $data['jawaban'],
            'status' => 'dijawab',
            'id_admin' => Auth::id(), // ✅ sekarang ambil dari id_user
            'is_published' => $data['publish_to_faq'] ?? false,
        ]);

        if ($p->is_published) {
            $exists = Faq::where('pertanyaan', $p->isi)
                         ->where('jawaban', $p->jawaban)
                         ->exists();

            if (!$exists) {
                Faq::create([
                    'pertanyaan' => $p->isi,
                    'jawaban' => $p->jawaban,
                ]);
            }
        }

        return response()->json(['message' => 'Pertanyaan dijawab', 'data' => $p]);
    }

    public function disposisi(Request $request, $id)
    {
        $p = Pertanyaan::findOrFail($id);
        $data = $request->validate([
            'id_admin_fungsi' => 'required|exists:users,id_user' // ✅ fix validasi
        ]);

        $p->update([
            'status' => 'disposisi',
            'id_admin' => Auth::id(), // ✅ id_user
            'id_admin_fungsi' => $data['id_admin_fungsi'],
        ]);

        return response()->json(['message' => 'Pertanyaan didisposisi', 'data' => $p]);
    }

    public function publishToFaq($id)
    {
        $p = Pertanyaan::findOrFail($id);
        if (!$p->jawaban) {
            return response()->json(['message' => 'Belum ada jawaban'], 422);
        }

        if (!$p->is_published) {
            $exists = Faq::where('pertanyaan', $p->isi)
                         ->where('jawaban', $p->jawaban)
                         ->exists();

            if (!$exists) {
                Faq::create([
                    'pertanyaan' => $p->isi,
                    'jawaban' => $p->jawaban,
                ]);
            }

            $p->update(['is_published' => true, 'status' => 'selesai']);
        }

        return response()->json(['message' => 'Dipublish ke FAQ', 'data' => $p]);
    }
}
