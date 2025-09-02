<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pengaduan', function (Blueprint $table) {
            $table->id('id_pengaduan');
            $table->foreignId('id_user')->constrained('users','id_user')->onDelete('cascade');
            $table->string('judul',150);
            $table->text('isi_pengaduan');
            $table->string('lampiran',255)->nullable();
            $table->date('tanggal');
            $table->time('jam');
            $table->enum('status',['baru','proses','selesai'])->default('baru');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('pengaduan');
    }
};

