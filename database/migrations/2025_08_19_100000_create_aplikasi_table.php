<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('aplikasi', function (Blueprint $table) {
            $table->id('id_aplikasi');
            $table->string('nama_app', 100); // 🔹 ubah jadi nama_app
            $table->string('url', 255);
            $table->string('image', 255)->nullable();
            $table->enum('kategori', ['internal', 'eksternal'])->default('eksternal');
            
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('aplikasi');
    }
};
