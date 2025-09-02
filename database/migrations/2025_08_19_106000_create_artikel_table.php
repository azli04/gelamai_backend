<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('artikel', function (Blueprint $table) {
            $table->id('id_artikel');
            $table->string('judul',150);
            $table->text('isi');
            $table->string('gambar',255)->nullable();
            $table->date('tanggal');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('artikel');
    }
};
