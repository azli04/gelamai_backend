<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pertanyaan', function (Blueprint $table) {
            $table->id('id_pertanyaan');

            // Identitas pelapor
            $table->string('nama_lengkap');
            $table->string('profesi')->nullable();
            $table->date('tanggal_lahir');
            $table->text('alamat');
            $table->string('email');
            $table->string('no_hp');

            // Relasi ke kategori
            $table->unsignedBigInteger('id_kategori');
            $table->foreign('id_kategori')
                  ->references('id_faq_kategori') 
                  ->on('faq_kategori')
                  ->onDelete('cascade');

            // Isi pertanyaan
            $table->longText('isi_pertanyaan');

            // Jawaban admin
            $table->longText('jawaban')->nullable();
            $table->enum('status', ['pending', 'answered', 'rejected'])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('pertanyaan');
    }
};
