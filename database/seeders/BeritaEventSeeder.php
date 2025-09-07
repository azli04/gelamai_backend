<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BeritaEventSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('berita_event')->truncate();

        DB::table('berita_event')->insert([
            // === BERITA ===
            [
                'judul' => 'BBPOM Padang Berhasil Sita Obat Ilegal Senilai Rp 500 Juta',
                'isi' => 'Tim BBPOM Padang berhasil mengamankan obat-obatan ilegal senilai Rp 500 juta dalam operasi gabungan dengan kepolisian. Obat-obatan tersebut tidak memiliki izin edar dan diduga mengandung bahan berbahaya. Operasi dilakukan di beberapa apotek dan toko obat di wilayah Padang dan sekitarnya. Kepala BBPOM Padang menegaskan komitmen untuk terus melakukan pengawasan ketat terhadap peredaran obat ilegal.',
                'gambar' => 'berita-sita-obat-ilegal.jpg',
                'tipe' => 'berita',
                'tanggal' => '2025-05-14',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Razia Makanan Berkemasan di Pasar Tradisional Padang',
                'isi' => 'BBPOM Padang melakukan razia mendadak di berbagai pasar tradisional untuk memeriksa keamanan makanan berkemasan. Dari 150 sampel yang diambil, ditemukan 12 produk yang tidak memenuhi standar keamanan pangan. Produk-produk tersebut langsung ditarik dari peredaran dan pedagang diberikan edukasi tentang pentingnya menjual produk berBPOM.',
                'gambar' => 'berita-razia-pasar.jpg',
                'tipe' => 'berita',
                'tanggal' => '2025-12-16',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Kerja Sama BBPOM Padang dengan Universitas dalam Penelitian Pangan',
                'isi' => 'BBPOM Padang menjalin kerja sama strategis dengan beberapa universitas di Sumatera Barat untuk penelitian keamanan pangan lokal. Program ini bertujuan mengembangkan metode pengujian yang lebih efektif dan mendukung industri pangan tradisional agar memenuhi standar keamanan. Penelitian pertama akan fokus pada makanan tradisional Minangkabau.',
                'gambar' => 'berita-kerjasama-univ.jpg',
                'tipe' => 'berita',
                'tanggal' => '2024-08-22',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // === EVENT ===
            [
                'judul' => 'Sosialisasi Keamanan Pangan untuk Siswa SMA',
                'isi' => 'BBPOM Padang akan mengadakan program sosialisasi keamanan pangan di 20 SMA di wilayah Padang dan sekitarnya. Program ini bertujuan meningkatkan kesadaran remaja tentang bahaya jajanan tidak sehat dan cara memilih makanan yang aman. Setiap sekolah akan mendapat materi edukasi interaktif dan doorprize menarik.',
                'gambar' => 'event-sosialisasi-sma.jpg',
                'tipe' => 'event',
                'tanggal' => '2024-12-20',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Workshop Keamanan Kosmetik untuk Pelaku UMKM',
                'isi' => 'BBPOM Padang mengundang pelaku UMKM kosmetik untuk mengikuti workshop tentang regulasi dan standar keamanan kosmetik. Workshop akan membahas cara mendaftarkan produk ke BPOM, standar produksi yang baik, dan strategi pemasaran produk kosmetik legal. Peserta akan mendapat sertifikat dan konsultasi gratis.',
                'gambar' => 'event-workshop-kosmetik.jpg',
                'tipe' => 'event',
                'tanggal' => '2024-12-25',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Pameran Produk Pangan dan Obat Aman di Mall',
                'isi' => 'BBPOM Padang akan menyelenggarakan pameran edukasi tentang produk pangan dan obat yang aman di Transmart Padang. Pengunjung dapat belajar cara membedakan produk asli dan palsu, konsultasi gratis dengan apoteker, serta mendapat informasi terbaru tentang produk yang ditarik dari peredaran.',
                'gambar' => 'event-pameran-mall.jpg',
                'tipe' => 'event',
                'tanggal' => '2024-12-30',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Pelatihan Analisis Mikrobiologi untuk Laboratorium',
                'isi' => 'BBPOM Padang membuka pelatihan analisis mikrobiologi untuk tenaga laboratorium dari berbagai instansi. Pelatihan selama 5 hari ini akan membahas teknik isolasi bakteri patogen, identifikasi mikroorganisme, dan interpretasi hasil uji. Fasilitas lengkap dan instruktur berpengalaman siap memberikan pelatihan terbaik.',
                'gambar' => 'event-pelatihan-lab.jpg',
                'tipe' => 'event',
                'tanggal' => '2025-01-15',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
