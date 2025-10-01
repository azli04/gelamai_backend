<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BeritaEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class BeritaEventController extends Controller
{
    // 🔹 Get all berita/event (pagination + filter)
    public function index(Request $request)
    {
        try {
            $perPage = $request->get('per_page', 10);

            $query = BeritaEvent::query();

            // filter tipe (berita / event)
            if ($request->has('type') && in_array($request->type, ['berita', 'event'])) {
                $query->where('tipe', $request->type);
            }

            // search judul / isi
            if ($request->has('search') && $request->search !== '') {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('judul', 'LIKE', "%$search%")
                        ->orWhere('isi', 'LIKE', "%$search%");
                });
            }

            // sorting
            switch ($request->get('sort', 'newest')) {
                case 'oldest':
                    $query->orderBy('tanggal', 'asc');
                    break;
                case 'popular':
                    $query->orderBy('views', 'desc');
                    break;
                default:
                    $query->orderBy('tanggal', 'desc');
                    break;
            }

            $berita = $query->paginate($perPage);

            // tambahin image_url
            $berita->getCollection()->transform(function ($item) {
                $item->image_url = $item->gambar ? url('storage/' . $item->gambar) : null;
                return $item;
            });

            return response()->json([
                'success' => true,
                'data' => $berita->items(),
                'meta' => [
                    'current_page' => $berita->currentPage(),
                    'per_page' => $berita->perPage(),
                    'total' => $berita->total(),
                    'last_page' => $berita->lastPage(),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // 🔹 Upload image
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

            Storage::disk('public')->put("berita_images/$filename", (string) $img);

            $url = url("storage/berita_images/$filename");

            return response()->json(['success' => true, 'url' => $url]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // 🔹 Store berita/event baru
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'judul'   => 'required|string|max:150',
                'isi'     => 'required|string',
                'gambar'  => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'tipe'    => 'required|in:berita,event',
                'tanggal' => 'nullable|date',
                'status'  => 'nullable|in:draft,publish', // ✅ status
            ]);

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

                Storage::disk('public')->put("berita_images/$filename", (string) $img);

                $data['gambar'] = "berita_images/$filename";
            }

            $berita = BeritaEvent::create($data);
            $berita->image_url = $berita->gambar ? url('storage/' . $berita->gambar) : null;

            return response()->json(['success' => true, 'data' => $berita], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // 🔹 Show detail
    public function show($id)
    {
        try {
            $berita = BeritaEvent::findOrFail($id);

            $berita->increment('views');
            $berita->image_url = $berita->gambar ? url('storage/' . $berita->gambar) : null;

            return response()->json(['success' => true, 'data' => $berita]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }
    }

    // 🔹 Update
    public function update(Request $request, $id)
    {
        try {
            $berita = BeritaEvent::findOrFail($id);

            $data = $request->validate([
                'judul'   => 'sometimes|string|max:150',
                'isi'     => 'sometimes|string',
                'gambar'  => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'tipe'    => 'sometimes|in:berita,event',
                'tanggal' => 'nullable|date',
                'status'  => 'sometimes|in:draft,publish',
            ]);

            if ($request->hasFile('gambar')) {
                if ($berita->gambar && Storage::disk('public')->exists($berita->gambar)) {
                    Storage::disk('public')->delete($berita->gambar);
                }

                $file = $request->file('gambar');
                $filename = uniqid() . '.webp';

                $img = Image::read($file)
                    ->resize(1200, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->toWebp(80);

                Storage::disk('public')->put("berita_images/$filename", (string) $img);

                $data['gambar'] = "berita_images/$filename";
            }

            $berita->update($data);
            $berita->refresh();
            $berita->image_url = $berita->gambar ? url('storage/' . $berita->gambar) : null;

            return response()->json(['success' => true, 'data' => $berita]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // 🔹 Delete
    public function destroy($id)
    {
        try {
            $berita = BeritaEvent::findOrFail($id);

            if ($berita->gambar && Storage::disk('public')->exists($berita->gambar)) {
                Storage::disk('public')->delete($berita->gambar);
            }

            $berita->delete();

            return response()->json(['success' => true, 'message' => 'Berita/Event berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // 🔹 Publish berita/event
    public function publish($id)
    {
        try {
            $berita = BeritaEvent::findOrFail($id);

            if ($berita->status === 'publish') {
                return response()->json(['success' => false, 'message' => 'Berita/Event sudah dipublish'], 400);
            }

            $berita->update(['status' => 'publish']);
            $berita->refresh();

            return response()->json([
                'success' => true,
                'message' => 'Berita/Event berhasil dipublish',
                'data' => $berita,
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
