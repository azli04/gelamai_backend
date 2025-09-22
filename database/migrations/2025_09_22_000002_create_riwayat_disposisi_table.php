<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_disposisi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pertanyaan_id');
            $table->unsignedBigInteger('admin_fungsi_id');
            $table->string('catatan')->nullable();
            $table->timestamps();

            $table->foreign('pertanyaan_id')
                  ->references('id_pertanyaan')->on('pertanyaan')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_disposisi');
    }
};
