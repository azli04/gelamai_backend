<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class ArtikelController extends Controller
{
    // 🔹 Get all artikel (pakai pagination)
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);

        $artikel = Artikel::orderBy('tanggal', 'desc')->paginate($perPage);

        // tambahin image_url biar frontend bisa langsung load
        $artikel->getCollection()->transform(function ($item) {
            $item->image_url = $item->gambar ? url('storage/' . $item->gambar) : null;
            return $item;
        });

        return response()->json([
            'success' => true,
            'data' => $artikel->items(),
            'meta' => [
                'current_page' => $artikel->currentPage(),
                'per_page' => $artikel->perPage(),
                'total' => $artikel->total(),
                'last_page' => $artikel->lastPage(),
            ],
        ]);
    }

    // 🔹 Upload image khusus artikel
    public function uploadImage(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ]);

            $file = $request->file('image');
            $filename = uniqid() . '.webp';

            $img = Image::read($file)
                ->resize(1200, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->toWebp(80);

            Storage::disk('public')->put("artikel_images/$filename", (string) $img);

            $url = url("storage/artikel_images/$filename");

            return response()->json([
                'success' => true,
                'url' => $url,
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => $e->getMessage(),
                ],
                500,
            );
        }
    }

    // 🔹 Store artikel baru
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'judul'   => 'required|string|max:150',
                'isi'     => 'required|string',
                'gambar'  => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'tanggal' => 'nullable|date',
                'status'  => 'nullable|in:draft,publish', // ✅ TAMBAH VALIDATION STATUS
            ]);

            // default status = draft kalau tidak ada
            $data['status'] = $data['status'] ?? 'draft';

            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');
                $filename = uniqid() . '.webp';

                $img = Image::read($file)
                    ->resize(1200, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->toWebp(80);

                Storage::disk('public')->put("artikel_images/$filename", (string) $img);

                $data['gambar'] = "artikel_images/$filename";
            }

            $artikel = Artikel::create($data);
            $artikel->image_url = $artikel->gambar ? url('storage/' . $artikel->gambar) : null;

            return response()->json(['success' => true, 'data' => $artikel], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // 🔹 Show detail artikel
    public function show($id)
    {
        try {
            $artikel = Artikel::findOrFail($id);

            // Tambah views otomatis
            $artikel->increment('views');
            $artikel->image_url = $artikel->gambar ? url('storage/' . $artikel->gambar) : null;

            return response()->json([
                'success' => true,
                'message' => 'Detail artikel',
                'data' => $artikel,
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }
    }

    // 🔹 Update artikel - FIXED VERSION
    public function update(Request $request, $id)
    {
        try {
            $artikel = Artikel::findOrFail($id);

            $data = $request->validate([
                'judul'   => 'sometimes|string|max:150',
                'isi'     => 'sometimes|string',
                'gambar'  => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'tanggal' => 'nullable|date',
                'status'  => 'sometimes|in:draft,publish', // ✅ TAMBAH STATUS VALIDATION
            ]);



            if ($request->hasFile('gambar')) {
                // hapus gambar lama kalau ada
                if ($artikel->gambar && Storage::disk('public')->exists($artikel->gambar)) {
                    Storage::disk('public')->delete($artikel->gambar);
                }

                $file = $request->file('gambar');
                $filename = uniqid() . '.webp';

                $img = Image::read($file)
                    ->resize(1200, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->toWebp(80);

                Storage::disk('public')->put("artikel_images/$filename", (string) $img);

                $data['gambar'] = "artikel_images/$filename";
            }

            // Update artikel dengan data yang sudah tervalidasi (termasuk status)
            $artikel->update($data);
            $artikel->refresh(); // Reload dari database
            $artikel->image_url = $artikel->gambar ? url('storage/' . $artikel->gambar) : null;

            // 🔍 Debug log setelah update

            return response()->json(['success' => true, 'data' => $artikel]);
        } catch (\Exception $e) {


            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // 🔹 Delete artikel
    public function destroy($id)
    {
        try {
            $artikel = Artikel::findOrFail($id);

            if ($artikel->gambar && Storage::disk('public')->exists($artikel->gambar)) {
                Storage::disk('public')->delete($artikel->gambar);
            }

            $artikel->delete();

            return response()->json(['success' => true, 'message' => 'Artikel berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // 🔹 Publish artikel
    public function publish($id)
    {
        try {
            $artikel = Artikel::findOrFail($id);

            if ($artikel->status === 'publish') {
                return response()->json([
                    'success' => false,
                    'message' => 'Artikel sudah dipublish'
                ], 400);
            }

            $artikel->update(['status' => 'publish']);
            $artikel->refresh();

            return response()->json([
                'success' => true,
                'message' => 'Artikel berhasil dipublish',
                'data' => $artikel
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
