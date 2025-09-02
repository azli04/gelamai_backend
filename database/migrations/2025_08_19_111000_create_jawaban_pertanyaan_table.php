<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('jawaban_pertanyaan', function (Blueprint $table) {
            $table->id('id_jawaban');
            $table->foreignId('id_pertanyaan')->nullable()->constrained('pertanyaan','id_pertanyaan')->onDelete('cascade');
            $table->foreignId('id_user')->constrained('users','id_user')->onDelete('cascade');
            $table->text('isi_jawaban');
            $table->boolean('is_faq')->default(0);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('jawaban_pertanyaan');
    }
};
