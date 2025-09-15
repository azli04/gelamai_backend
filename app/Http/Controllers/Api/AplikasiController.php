<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Aplikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class AplikasiController extends Controller
{
    // 🔹 Get all aplikasi
    public function index()
    {
        $aplikasi = Aplikasi::all();

        // tambahin image_url biar frontend bisa langsung load
        $aplikasi->map(function ($item) {
            $item->image_url = $item->image ? url('storage/' . $item->image) : null;
            return $item;
        });

        return response()->json($aplikasi);
    }

    // 🔹 Store aplikasi baru
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_app'  => 'required|string|max:50',
            'url'       => 'nullable|string',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'kategori'  => 'required|in:internal,eksternal,lainnya',
            'deskripsi' => 'nullable|string',
        ]);

        // handle upload image
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = uniqid() . '.webp';

            $img = Image::read($file)
                ->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->toWebp(80);

            Storage::disk('public')->put("aplikasi_images/$filename", (string) $img);

            $data['image'] = "aplikasi_images/$filename";
        }

        $aplikasi = Aplikasi::create($data);

        return response()->json($aplikasi, 201);
    }

    // 🔹 Show aplikasi by id
    public function show($id)
    {
        $aplikasi = Aplikasi::findOrFail($id);
        $aplikasi->image_url = $aplikasi->image ? url('storage/' . $aplikasi->image) : null;

        return response()->json($aplikasi);
    }

    // 🔹 Update aplikasi
    public function update(Request $request, $id)
    {
        $aplikasi = Aplikasi::findOrFail($id);

        $data = $request->validate([
            'nama_app'  => 'sometimes|string|max:50',
            'url'       => 'nullable|string',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'kategori'  => 'sometimes|in:internal,eksternal,lainnya',
            'deskripsi' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            // hapus gambar lama kalau ada
            if ($aplikasi->image && Storage::disk('public')->exists($aplikasi->image)) {
                Storage::disk('public')->delete($aplikasi->image);
            }

            $file = $request->file('image');
            $filename = uniqid() . '.webp';

            $img = Image::read($file)
                ->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->toWebp(80);

            Storage::disk('public')->put("aplikasi_images/$filename", (string) $img);

            $data['image'] = "aplikasi_images/$filename";
        }

        $aplikasi->update($data);

        return response()->json($aplikasi);
    }

    // 🔹 Delete aplikasi
    public function destroy($id)
    {
        $aplikasi = Aplikasi::findOrFail($id);

        if ($aplikasi->image && Storage::disk('public')->exists($aplikasi->image)) {
            Storage::disk('public')->delete($aplikasi->image);
        }

        $aplikasi->delete();

        return response()->json(['message' => 'Aplikasi deleted successfully']);
    }
}
