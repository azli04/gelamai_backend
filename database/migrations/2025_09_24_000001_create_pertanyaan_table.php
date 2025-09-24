<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pertanyaan', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('profesi')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('alamat')->nullable();
            $table->string('email')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('topik')->nullable();
            $table->text('isi_pertanyaan');
            $table->text('jawaban')->nullable();
            $table->enum('status', [
                'menunggu',
                'disposisi',
                'dijawab fungsi',
                'dijawab web',
                'selesai'
            ])->default('menunggu');
            $table->foreignId('fungsi_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('pertanyaan');
    }
};
