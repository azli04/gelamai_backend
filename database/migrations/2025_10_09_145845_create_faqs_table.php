<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel pertanyaan (bukan questions)
            $table->foreignId('question_id')->nullable()
                  ->constrained('pertanyaan')
                  ->onDelete('set null');

            $table->string('topik');
            $table->text('pertanyaan');
            $table->text('jawaban');
            $table->integer('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->integer('view_count')->default(0);

            // Relasi ke tabel users dengan kolom id_user
            $table->unsignedBigInteger('published_by')->nullable();
            $table->foreign('published_by')
                  ->references('id_user')
                  ->on('users')
                  ->onDelete('set null');

            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            // Index untuk optimasi pencarian/sorting
            $table->index('topik');
            $table->index('is_active');
            $table->index('urutan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faqs');
    }
};
