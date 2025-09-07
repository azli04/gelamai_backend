<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArtikelSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('artikel')->truncate();

       DB::table('artikel')->insert([
    [
        'judul' => 'Tips Memilih Obat yang Aman dan Berkualitas',
        'isi' => 'Dalam memilih obat, masyarakat perlu memperhatikan beberapa hal penting ...',
        'gambar' => 'artikel-obat-aman.jpg',
        'tanggal' => '2024-12-10',
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'judul' => 'Bahaya Makanan Mengandung Formalin dan Cara Menghindarinya',
        'isi' => 'Formalin adalah bahan kimia yang berbahaya ...',
        'gambar' => 'artikel-formalin.jpg',
        'tanggal' => '2024-12-05',
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'judul' => 'Panduan Membaca Label Kemasan Makanan',
        'isi' => 'Label kemasan makanan mengandung informasi penting ...',
        'gambar' => 'artikel-label-kemasan.jpg',
        'tanggal' => '2024-11-28',
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'judul' => 'Mengenal Kosmetik Ilegal dan Dampaknya bagi Kesehatan',
        'isi' => 'Kosmetik ilegal adalah produk kosmetik yang tidak memiliki izin edar ...',
        'gambar' => 'artikel-kosmetik-ilegal.jpg',
        'tanggal' => '2024-11-20',
        'created_at' => now(),
        'updated_at' => now(),
    ],
]);
    }
}
