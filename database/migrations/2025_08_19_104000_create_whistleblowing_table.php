<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('whistleblowing', function (Blueprint $table) {
            $table->id('id_whistle');
            $table->foreignId('id_user')->constrained('users','id_user')->onDelete('cascade');
            $table->string('namaLengkap_user',75)->nullable();
            $table->string('profesi',50)->nullable();
            $table->string('alamat',100)->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->string('email',50)->nullable();
            $table->string('kontak',15)->nullable();
            $table->text('indikasi_pelanggaran')->nullable();
            $table->text('lokasi_pelanggaran')->nullable();
            $table->string('oknum_pelanggaran',100)->nullable();
            $table->text('kronologi')->nullable();
            $table->string('data_pendukung',255)->nullable();
            $table->enum('status',['baru','proses','selesai'])->default('baru');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('whistleblowing');
    }
};
