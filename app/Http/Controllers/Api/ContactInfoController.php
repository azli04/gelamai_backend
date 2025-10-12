<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactInfo;
use Illuminate\Http\Request;

class ContactInfoController extends Controller
{
    // GET /api/contact-info
    public function index()
    {
        $contact = ContactInfo::first();

        if (!$contact) {
            return response()->json([
                'message' => 'Data kontak belum tersedia.'
            ], 404);
        }

        return response()->json($contact);
    }

    // PUT /api/contact-info
    public function update(Request $request)
    {
        $contact = ContactInfo::first();

        // Kalau belum ada data, buat baru otomatis
        if (!$contact) {
            $contact = ContactInfo::create([]);
        }

        $validated = $request->validate([
            'address' => 'nullable|string',
            'call_center_1' => 'nullable|string',
            'call_center_2' => 'nullable|string',
            'email' => 'nullable|email',
            'working_hours' => 'nullable|string',
            'twitter' => 'nullable|string',
            'youtube' => 'nullable|string',
            'instagram' => 'nullable|string',
            'facebook' => 'nullable|string',
        ]);

        $contact->update($validated);

        return response()->json([
            'message' => 'Data kontak berhasil diperbarui.',
            'data' => $contact
        ]);
    }
}
