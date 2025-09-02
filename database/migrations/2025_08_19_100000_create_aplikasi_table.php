<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('aplikasi', function (Blueprint $table) {
            $table->id('id_aplikasi');
            $table->string('nama_aplikasi', 100);
            $table->string('url', 255);
            $table->enum('kategori', ['internal', 'eksternal'])->default('eksternal');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('aplikasi');
    }
};
