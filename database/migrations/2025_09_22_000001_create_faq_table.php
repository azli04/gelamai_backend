<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('faq', function (Blueprint $table) {
            $table->id('id_faq');
            $table->unsignedBigInteger('pertanyaan_id');
            $table->longText('jawaban');
            $table->timestamps();

            // Foreign key harus sesuai PK pertanyaan
            $table->foreign('pertanyaan_id')
                  ->references('id_pertanyaan')->on('pertanyaan')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faq');
    }
};
