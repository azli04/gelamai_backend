<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('balasan_pengaduan', function (Blueprint $table) {
            $table->id('id_balasan');
            $table->foreignId('id_pengaduan')->constrained('pengaduan','id_pengaduan')->onDelete('cascade');
            $table->foreignId('id_user')->constrained('users','id_user')->onDelete('cascade');
            $table->text('isi_balasan');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('balasan_pengaduan');
    }
};
