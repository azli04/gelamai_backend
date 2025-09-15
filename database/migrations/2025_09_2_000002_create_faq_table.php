<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('faq', function (Blueprint $table) {
            $table->id('id_faq');
            $table->text('pertanyaan');
            $table->text('jawaban')->nullable();
            $table->enum('status', ['pending','dijawab','ditolak'])->default('pending');

            // relasi ke faq_kategori
            $table->unsignedBigInteger('id_faq_kategori');
            $table->foreign('id_faq_kategori')
                  ->references('id_faq_kategori')
                  ->on('faq_kategori')
                  ->cascadeOnDelete();

            // relasi ke users
            $table->unsignedBigInteger('answered_by')->nullable();
            $table->foreign('answered_by')
                  ->references('id_user')
                  ->on('users')
                  ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('faq');
    }
};
