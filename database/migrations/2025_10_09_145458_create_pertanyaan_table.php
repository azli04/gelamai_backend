<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pertanyaan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('profesi');
            $table->date('tanggal_lahir');
            $table->text('alamat');
            $table->string('email');
            $table->string('no_hp', 20);
            $table->string('topik');
            $table->text('isi_pertanyaan');
            $table->enum('status', ['pending', 'processed', 'published', 'rejected'])->default('pending');
            $table->timestamps();

            // Index untuk pencarian
            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pertanyaan');
    }
};
