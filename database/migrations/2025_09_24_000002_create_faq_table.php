<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('faq', function (Blueprint $table) {
            $table->id('id_faq'); // PK custom
            $table->string('pertanyaan');
            $table->text('jawaban');
            $table->boolean('status')->default(true);

            // relasi ke pertanyaan
            $table->unsignedBigInteger('id_pertanyaan')->nullable();
            $table->foreign('id_pertanyaan')
                  ->references('id_pertanyaan')
                  ->on('pertanyaan')
                  ->nullOnDelete();

            // relasi ke users
            $table->unsignedBigInteger('published_by');
            $table->foreign('published_by')
                  ->references('id_user')
                  ->on('users')
                  ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('faq');
    }
};
