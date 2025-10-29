<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('whistleblowing', function (Blueprint $table) {
            $table->id('id_whistle');

            // 🔹 Data pelapor
            $table->string('nama_lengkap_user', 75)->nullable();
            $table->string('profesi', 50)->nullable();
            $table->string('alamat', 100)->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->string('email', 50)->nullable();
            $table->string('kontak', 15)->nullable();

            // 🔹 Data laporan
            $table->text('indikasi_pelanggaran')->nullable();
            $table->text('lokasi_pelanggaran')->nullable();
            $table->text('oknum_pelanggaran')->nullable();
            $table->text('kronologi')->nullable();

            // 🔹 File bukti pendukung
            $table->string('data_pendukung', 255)->nullable();

            // 🔹 Status laporan
            $table->enum('status', ['baru', 'proses', 'selesai'])->default('baru');

            // 🔹 Admin yang memproses laporan (jika ada)
            $table->unsignedBigInteger('id_admin')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('whistleblowing');
    }
};
