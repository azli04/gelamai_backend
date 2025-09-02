<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pertanyaan', function (Blueprint $table) {
            $table->id('id_pertanyaan');
            $table->foreignId('id_user')->constrained('users','id_user')->onDelete('cascade');
            $table->text('isi_pertanyaan');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('pertanyaan');
    }
};
