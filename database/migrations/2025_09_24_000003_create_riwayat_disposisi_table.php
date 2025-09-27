<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('riwayat_disposisi', function (Blueprint $table) {
            $table->id('id_disposisi'); // PK custom

            // relasi ke pertanyaan
            $table->unsignedBigInteger('id_pertanyaan');
            $table->foreign('id_pertanyaan')
                  ->references('id_pertanyaan')
                  ->on('pertanyaan')
                  ->cascadeOnDelete();

            // relasi ke users (dari)
            $table->unsignedBigInteger('dari_user_id');
            $table->foreign('dari_user_id')
                  ->references('id_user')
                  ->on('users')
                  ->cascadeOnDelete();

            // relasi ke users (ke)
            $table->unsignedBigInteger('ke_user_id');
            $table->foreign('ke_user_id')
                  ->references('id_user')
                  ->on('users')
                  ->cascadeOnDelete();

            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('riwayat_disposisi');
    }
};
