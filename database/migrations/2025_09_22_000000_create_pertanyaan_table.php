<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pertanyaan', function (Blueprint $table) {
            $table->bigIncrements('id_pertanyaan'); // PK
            $table->string('nama');
            $table->string('profesi')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->text('alamat')->nullable();
            $table->string('email')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('topik')->nullable();
            $table->longText('isi_pertanyaan');
            $table->enum('status', [
                'menunggu',
                'disposisi',
                'dijawab_fungsi',
                'dijawab_web',
                'selesai'
            ])->default('menunggu');
            $table->unsignedBigInteger('admin_fungsi_id')->nullable();
            $table->longText('jawaban')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pertanyaan');
    }
};
