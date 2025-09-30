<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tb_biaya_uji', function (Blueprint $table) {
            $table->id('id_biaya');
            $table->foreignId('id_kategori')
                  ->constrained('kategori', 'id_kategori')
                  ->onDelete('cascade');
            $table->string('parameter', 150); // langsung simpan nama parameter
            $table->decimal('biaya', 12, 2);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('tb_biaya_uji');
    }
};
