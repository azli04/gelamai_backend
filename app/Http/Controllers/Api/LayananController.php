<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LayananController extends Controller
{
    // ===============================
    // GET ALL LAYANAN (Public)
    // ===============================
    public function index()
    {
        $data = Layanan::select('id', 'title', 'details', 'link_url', 'image')
            ->orderBy('id', 'asc')
            ->get()
            ->map(function ($item) {
                if ($item->image) {
                    $item->image = Storage::url($item->image);
                } else {
                    $item->image = asset('images/default-layanan.png');
                }
                return $item;
            });

        return response()->json([
            'success' => true,
            'message' => 'Daftar layanan',
            'data' => $data
        ]);
    }

    // ===============================
    // GET DETAIL LAYANAN (Public)
    // ===============================
    public function show($id)
    {
        $layanan = Layanan::findOrFail($id);

        if ($layanan->image) {
            $layanan->image = Storage::url($layanan->image);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail layanan',
            'data' => $layanan
        ]);
    }

    // ===============================
    // CREATE LAYANAN (Admin Only)
    // ===============================
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'    => 'required|string|max:255',
            'details'  => 'nullable|string',
            'link_url' => 'nullable|url|max:255',
            'image'    => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('uploads', 'public');
        }

        $layanan = Layanan::create($data);

        if ($layanan->image) {
            $layanan->image = Storage::url($layanan->image);
        }

        return response()->json([
            'success' => true,
            'message' => 'Layanan berhasil ditambahkan',
            'data' => $layanan
        ], 201);
    }

    // ===============================
    // UPDATE LAYANAN (Admin Only)
    // ===============================
    public function update(Request $request, $id)
    {
        $layanan = Layanan::findOrFail($id);

        $data = $request->validate([
            'title'    => 'required|string|max:255',
            'details'  => 'nullable|string',
            'link_url' => 'nullable|url|max:255',
            'image'    => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($layanan->image && Storage::disk('public')->exists($layanan->image)) {
                Storage::disk('public')->delete($layanan->image);
            }

            $data['image'] = $request->file('image')->store('uploads', 'public');
        }

        $layanan->update($data);

        if ($layanan->image) {
            $layanan->image = Storage::url($layanan->image);
        }

        return response()->json([
            'success' => true,
            'message' => 'Layanan berhasil diperbarui',
            'data' => $layanan
        ]);
    }

    // ===============================
    // DELETE LAYANAN (Admin Only)
    // ===============================
    public function destroy($id)
    {
        $layanan = Layanan::findOrFail($id);

        if ($layanan->image && Storage::disk('public')->exists($layanan->image)) {
            Storage::disk('public')->delete($layanan->image);
        }

        $layanan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Layanan berhasil dihapus'
        ]);
    }
}
