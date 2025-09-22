<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Profil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    // Ambil semua profil (misalnya untuk sidebar, tampilkan juga image thumbnail kalau ada)
    public function index()
    {
        return response()->json(
            Profil::all(['id', 'title', 'image'])
        );
    }

    // Ambil satu profil lengkap
    public function show($id)
    {
        $profil = Profil::findOrFail($id);

        // kalau ada image, kembalikan URL lengkap
        if ($profil->image) {
            $profil->image = Storage::url($profil->image);
        }

        return response()->json($profil);
    }

    // Tambah profil baru
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'   => 'required|string|max:255',
            'details' => 'nullable|string',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('uploads', 'public');
        }

        $profil = Profil::create($data);

        if ($profil->image) {
            $profil->image = Storage::url($profil->image);
        }

        return response()->json($profil, 201);
    }

    // Update profil
    public function update(Request $request, $id)
    {
        $profil = Profil::findOrFail($id);

        $data = $request->validate([
            'title'   => 'required|string|max:255',
            'details' => 'nullable|string',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // hapus file lama kalau ada
            if ($profil->image && Storage::disk('public')->exists($profil->image)) {
                Storage::disk('public')->delete($profil->image);
            }

            $data['image'] = $request->file('image')->store('uploads', 'public');
        }

        $profil->update($data);

        if ($profil->image) {
            $profil->image = Storage::url($profil->image);
        }

        return response()->json($profil);
    }

    // Hapus profil
    public function destroy($id)
    {
        $profil = Profil::findOrFail($id);

        if ($profil->image && Storage::disk('public')->exists($profil->image)) {
            Storage::disk('public')->delete($profil->image);
        }

        $profil->delete();

        return response()->json(['message' => 'Profil deleted']);
    }
}
