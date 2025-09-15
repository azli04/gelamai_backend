<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FaqKategori;

class FaqKategoriSeeder extends Seeder
{
    public function run(): void
    {
        FaqKategori::create([
            'nama' => 'Umum',
            'admin_role_id' => 1, // superadmin
            'deskripsi' => 'Pertanyaan umum'
        ]);

        FaqKategori::create([
            'nama' => 'Produk',
            'admin_role_id' => 2, // admin bidang produk
            'deskripsi' => 'Pertanyaan tentang produk BPOM'
        ]);

        FaqKategori::create([
            'nama' => 'Layanan',
            'admin_role_id' => 3, // admin bidang layanan
            'deskripsi' => 'Pertanyaan tentang layanan BPOM'
        ]);
    }
}

