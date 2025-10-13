<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pengaduans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->integer('umur')->nullable();
            $table->string('nama_perusahaan')->nullable();
            $table->string('jenis_perusahaan')->nullable();
            $table->string('jenis_pengaduan')->nullable();
            $table->string('jenis_produk')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('jam')->nullable();
            $table->string('email')->nullable();
            $table->string('no_telepon')->nullable();
            $table->text('alamat')->nullable();
            $table->string('nama_produk')->nullable();
            $table->string('no_registrasi')->nullable();
            $table->date('kadaluarsa')->nullable();
            $table->string('nama_pabrik')->nullable();
            $table->text('alamat_pabrik')->nullable();
            $table->string('batch')->nullable();
            $table->text('pertanyaan')->nullable();
            $table->json('attachments')->nullable();
            $table->enum('status', ['baru', 'diproses', 'selesai'])->default('baru');
            $table->text('tanggapan')->nullable();

            // 🔹 Ganti foreign key supaya cocok dengan struktur tabel users kamu
            $table->unsignedBigInteger('ditanggapi_oleh')->nullable();
            $table->foreign('ditanggapi_oleh')
                  ->references('id_user') 
                  ->on('users')
                  ->onDelete('set null');

            $table->timestamp('tanggal_tanggapan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaduans');
    }
};
