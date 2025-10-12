<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LayananController extends Controller
{
    // Ambil semua layanan (misalnya untuk sidebar, tampilkan juga image thumbnail kalau ada)
    public function index()
    {
        return response()->json(
            Layanan::all(['id', 'title', 'image', 'link_url'])
        );
    }

    // Ambil satu layanan lengkap
    public function show($id)
    {
        $layanan = Layanan::findOrFail($id);

        // kalau ada image, kembalikan URL lengkap
        if ($layanan->image) {
            $layanan->image = Storage::url($layanan->image);
        }

        return response()->json($layanan);
    }

    // Tambah layanan baru
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'    => 'required|string|max:255',
            'details'  => 'nullable|string',
            'link_url' => 'nullable|url|max:255', // <-- validasi link
            'image'    => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('uploads', 'public');
        }

        $layanan = Layanan::create($data);

        if ($layanan->image) {
            $layanan->image = Storage::url($layanan->image);
        }

        return response()->json($layanan, 201);
    }

    // Update layanan
    public function update(Request $request, $id)
    {
        $layanan = Layanan::findOrFail($id);

        $data = $request->validate([
            'title'    => 'required|string|max:255',
            'details'  => 'nullable|string',
            'link_url' => 'nullable|url|max:255', // <-- validasi link
            'image'    => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // hapus file lama kalau ada
            if ($layanan->image && Storage::disk('public')->exists($layanan->image)) {
                Storage::disk('public')->delete($layanan->image);
            }

            $data['image'] = $request->file('image')->store('uploads', 'public');
        }

        $layanan->update($data);

        if ($layanan->image) {
            $layanan->image = Storage::url($layanan->image);
        }

        return response()->json($layanan);
    }

    // Hapus layanan
    public function destroy($id)
    {
        $layanan = Layanan::findOrFail($id);

        if ($layanan->image && Storage::disk('public')->exists($layanan->image)) {
            Storage::disk('public')->delete($layanan->image);
        }

        $layanan->delete();

        return response()->json(['message' => 'Layanan deleted']);
    }
}
