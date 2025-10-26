<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Pertanyaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class FaqController extends Controller
{
    /**
     * List FAQ (Public)
     */
    public function index(Request $request)
    {
        $query = Faq::with(['pertanyaanRelation', 'publisher'])
                    ->active()
                    ->ordered();

        // Filter berdasarkan topik
        if ($request->has('topik')) {
            $query->byTopic($request->topik);
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('pertanyaan', 'like', '%' . $search . '%')
                  ->orWhere('jawaban', 'like', '%' . $search . '%');
            });
        }

        $faqs = $query->get();

        return response()->json([
            'success' => true,
            'data' => $faqs
        ]);
    }

    /**
     * Detail FAQ dan increment view count (Public)
     */
    public function show($id)
    {
        $faq = Faq::with(['pertanyaanRelation', 'publisher'])->find($id);

        if (!$faq || !$faq->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'FAQ tidak ditemukan'
            ], 404);
        }

        // Increment view count
        $faq->incrementViewCount();

        return response()->json([
            'success' => true,
            'data' => $faq
        ]);
    }

    /**
     * List all FAQ untuk admin (termasuk yang tidak aktif)
     */
    public function adminIndex(Request $request)
    {
        $query = Faq::with(['pertanyaanRelation', 'publisher']);

        // Filter berdasarkan status aktif
        if ($request->has('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        // Filter berdasarkan topik
        if ($request->has('topik')) {
            $query->byTopic($request->topik);
        }

        $faqs = $query->ordered()
                     ->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $faqs
        ]);
    }

    /**
     * Create FAQ dari pertanyaan (Admin only)
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question_id' => 'nullable|exists:pertanyaan,id',
            'topik' => 'required|string|max:255',
            'pertanyaan' => 'required|string',
            'jawaban' => 'required|string',
            'urutan' => 'nullable|integer',
            'is_active' => 'nullable|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        // Perbaikan: Cek user terlebih dahulu
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized - Silakan login terlebih dahulu'
            ], 401);
        }

        $data = $validator->validated();
        $data['published_by'] = $user->id_user;
        $data['published_at'] = now();

        $faq = Faq::create($data);

        // Update status pertanyaan jika ada
        if ($request->question_id) {
            Pertanyaan::find($request->question_id)->update([
                'status' => 'published'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'FAQ berhasil dipublikasikan',
            'data' => $faq->load(['pertanyaanRelation', 'publisher'])
        ], 201);
    }

    /**
     * Update FAQ (Admin only)
     */
    public function update(Request $request, $id)
    {
        $faq = Faq::find($id);

        if (!$faq) {
            return response()->json([
                'success' => false,
                'message' => 'FAQ tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'topik' => 'sometimes|required|string|max:255',
            'pertanyaan' => 'sometimes|required|string',
            'jawaban' => 'sometimes|required|string',
            'urutan' => 'nullable|integer',
            'is_active' => 'nullable|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $faq->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'FAQ berhasil diperbarui',
            'data' => $faq->load(['pertanyaanRelation', 'publisher'])
        ]);
    }

    /**
     * Delete FAQ (Admin only)
     */
    public function destroy($id)
    {
        $faq = Faq::find($id);

        if (!$faq) {
            return response()->json([
                'success' => false,
                'message' => 'FAQ tidak ditemukan'
            ], 404);
        }

        $faq->delete();

        return response()->json([
            'success' => true,
            'message' => 'FAQ berhasil dihapus'
        ]);
    }

    /**
     * Toggle status aktif FAQ (Admin only)
     */
    public function toggleActive($id)
    {
        $faq = Faq::find($id);

        if (!$faq) {
            return response()->json([
                'success' => false,
                'message' => 'FAQ tidak ditemukan'
            ], 404);
        }

        $faq->update(['is_active' => !$faq->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Status FAQ berhasil diubah',
            'data' => $faq
        ]);
    }

    /**
     * Get daftar topik yang tersedia
     */
    public function getTopics()
    {
        $topics = Faq::active()
                    ->distinct()
                    ->pluck('topik');

        return response()->json([
            'success' => true,
            'data' => $topics
        ]);
    }
}
