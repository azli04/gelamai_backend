<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AplikasiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('aplikasi')->insert([
            [
                'nama_app' => 'SIIP',
                'url' => 'https://siip.bbpompadang.id',
                'kategori' => 'internal',
                'image' => 'siip.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_app' => 'Buku Tamu',
                'url' => 'https://bukutamu.bbpompadang.id',
                'kategori' => 'eksternal',
                'image' => 'bukutamu.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_app' => 'Lapor Pak',
                'url' => 'https://laporpak.bbpompadang.id',
                'kategori' => 'eksternal',
                'image' => 'laporpak.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_app' => 'Kompetensi SDM',
                'url' => 'https://kompetensi.bbpompadang.id',
                'kategori' => 'internal',
                'image' => 'kompetensi.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_app' => 'Pengukuran Kinerja',
                'url' => 'https://kinerja.bbpompadang.id',
                'kategori' => 'internal',
                'image' => 'kinerja.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_app' => 'Help Desk BBPOM Padang',
                'url' => 'https://helpdesk.bbpompadang.id',
                'kategori' => 'internal',
                'image' => 'helpdesk.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_app' => 'Simpelin Aja',
                'url' => 'https://simpelin.bbpompadang.id',
                'kategori' => 'eksternal',
                'image' => 'simpelin.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_app' => 'Biaya Uji',
                'url' => 'https://biayauji.bbpompadang.id',
                'kategori' => 'eksternal',
                'image' => 'biayauji.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_app' => 'Pengaduan Masyarakat',
                'url' => 'https://pengaduan.bbpompadang.id',
                'kategori' => 'eksternal',
                'image' => 'pengaduan.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
