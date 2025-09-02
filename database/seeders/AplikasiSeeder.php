<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AplikasiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('aplikasi')->insert([
            // Internal
            ['nama_aplikasi' => 'SIIP', 'url' => '#', 'kategori' => 'internal'],
            ['nama_aplikasi' => 'Kompetensi SDM', 'url' => '#', 'kategori' => 'internal'],
            ['nama_aplikasi' => 'Pengukuran Kinerja', 'url' => '#', 'kategori' => 'internal'],
            ['nama_aplikasi' => 'Help Desk BPOM Padang', 'url' => '#', 'kategori' => 'internal'],
            ['nama_aplikasi' => 'Whistle Blowing', 'url' => '#', 'kategori' => 'internal'],

            // Eksternal
            ['nama_aplikasi' => 'Buku Tamu', 'url' => '#', 'kategori' => 'external'],
            ['nama_aplikasi' => 'Lapor Pak', 'url' => '#', 'kategori' => 'external'],
            ['nama_aplikasi' => 'Simpelin Aja', 'url' => '#', 'kategori' => 'external'],
            ['nama_aplikasi' => 'Biaya Uji', 'url' => '#', 'kategori' => 'external'],
            ['nama_aplikasi' => 'Pengaduan Masyarakat', 'url' => '#', 'kategori' => 'external'],
            ['nama_aplikasi' => 'Layanan Pertanyaan', 'url' => '#', 'kategori' => 'external'],
        ]);
    }
}
