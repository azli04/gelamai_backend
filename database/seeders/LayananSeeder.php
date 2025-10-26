<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Layanan;

class LayananSeeder extends Seeder
{
    public function run(): void
    {
        $layanans = [
            [
                'title' => 'Pengaduan Masyarakat dan Informasi Obat dan Makanan',
                'details' => '<b>Deskripsi Layanan:</b><br>Layanan untuk menerima pengaduan masyarakat terkait pelanggaran peraturan di bidang obat dan makanan, serta permintaan informasi.<br><b>Waktu Pelayanan:</b> Maksimal 5 hari kerja.<br><b>Biaya:</b> Gratis.',
                'link_url' => 'https://lapor.go.id',
                'image' => null,
            ],
            [
                'title' => 'Pengujian Obat dan Makanan (Sampel dari Pihak Ketiga)',
                'details' => '<b>Deskripsi Layanan:</b><br>Layanan pengujian laboratorium untuk masyarakat, instansi, atau pelaku usaha melalui mekanisme Pihak Ketiga.<br><b>Waktu:</b> Maksimal 20 hari kerja.<br><b>Biaya:</b> Sesuai PNBP.',
                'link_url' => 'https://uji.bpom.go.id',
                'image' => null,
            ],
            [
                'title' => 'Penerbitan Surat Keterangan Ekspor (SKE) Obat dan Makanan',
                'details' => '<b>Deskripsi Layanan:</b><br>Penerbitan SKE untuk produk obat, kosmetik, dan pangan olahan yang akan diekspor.<br><b>Waktu:</b> Maksimal 3 hari kerja.<br><b>Biaya:</b> Gratis.',
                'link_url' => 'https://e-ske.pom.go.id',
                'image' => null,
            ],
            [
                'title' => 'Penerbitan Surat Keterangan Impor (SKI) Obat dan Makanan',
                'details' => '<b>Deskripsi Layanan:</b><br>Penerbitan SKI untuk pemasukan obat dan makanan ke Indonesia melalui e-SKI BPOM.<br><b>Waktu:</b> Maksimal 2 hari kerja.<br><b>Biaya:</b> Gratis.',
                'link_url' => 'https://e-ski.pom.go.id',
                'image' => null,
            ],
            [
                'title' => 'Pemeriksaan Pedagang Besar Farmasi (PBF) dan Evaluasi CAPA – Sertifikasi CDOB',
                'details' => '<b>Deskripsi Layanan:</b><br>Pemeriksaan sarana distribusi PBF dalam rangka sertifikasi Cara Distribusi Obat yang Baik (CDOB).<br><b>Biaya:</b> Gratis.',
                'link_url' => 'https://sertifikasi.pom.go.id',
                'image' => null,
            ],
            [
                'title' => 'Rekomendasi Pemenuhan Aspek Cara Pembuatan Obat Tradisional yang Baik (CPOTB)',
                'details' => '<b>Deskripsi Layanan:</b><br>Rekomendasi pemenuhan aspek CPOTB bagi industri obat tradisional.<br><b>Biaya:</b> Gratis.',
                'link_url' => 'https://cpotb.pom.go.id',
                'image' => null,
            ],
            [
                'title' => 'Rekomendasi Pemenuhan Aspek Cara Pembuatan Kosmetika yang Baik (CPKB)',
                'details' => '<b>Deskripsi Layanan:</b><br>Rekomendasi pemenuhan aspek CPKB untuk industri kosmetika.<br><b>Biaya:</b> Gratis.',
                'link_url' => 'https://cpkb.pom.go.id',
                'image' => null,
            ],
            [
                'title' => 'Rekomendasi sebagai Pemohon Notifikasi Kosmetika',
                'details' => '<b>Deskripsi Layanan:</b><br>Rekomendasi kepada pelaku usaha kosmetik sebagai pemohon notifikasi kosmetika.<br><b>Biaya:</b> Gratis.',
                'link_url' => 'https://notifkos.pom.go.id',
                'image' => null,
            ],
            [
                'title' => 'Penerbitan Sertifikat/Rekomendasi Izin Penerapan CPPOB',
                'details' => '<b>Deskripsi Layanan:</b><br>Penerbitan sertifikat atau rekomendasi penerapan Cara Produksi Pangan Olahan yang Baik (CPPOB).<br><b>Biaya:</b> Gratis.',
                'link_url' => 'https://cppob.pom.go.id',
                'image' => null,
            ],
        ];

        foreach ($layanans as $layanan) {
            Layanan::updateOrCreate(['title' => $layanan['title']], $layanan);
        }
    }
}