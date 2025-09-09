<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pertanyaan', function (Blueprint $table) {
            $table->bigIncrements('id_pertanyaan');
            $table->string('nama_user', 100);
            $table->string('email', 150);
            $table->text('isi');
            $table->enum('status', ['menunggu', 'dijawab', 'disposisi', 'selesai'])->default('menunggu');
            $table->unsignedBigInteger('id_admin')->nullable();        // admin pengaduan yang handle
            $table->unsignedBigInteger('id_admin_fungsi')->nullable(); // admin fungsi (jika disposisi)
            $table->text('jawaban')->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamps();

            // ✅ FK diarahkan ke users.id_user, bukan users.id
            $table->foreign('id_admin')
                ->references('id_user')
                ->on('users')
                ->onDelete('set null');

            $table->foreign('id_admin_fungsi')
                ->references('id_user')
                ->on('users')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pertanyaan');
    }
};
