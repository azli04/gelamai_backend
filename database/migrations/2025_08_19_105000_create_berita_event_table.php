<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('berita_event', function (Blueprint $table) {
            $table->id('id_berita');
            $table->string('judul', 150);
            $table->text('isi');
            $table->string('gambar', 255)->nullable();
            $table->enum('tipe', ['berita', 'event'])->default('berita'); // ✅ bedain berita/event
            $table->date('tanggal')->nullable(); // ✅ kalau mau set tanggal manual
            $table->timestamps(); // ✅ simpan otomatis created_at & updated_at
        });
    }

    public function down(): void {  
        Schema::dropIfExists('berita_event');
    }
};
