<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('faq_kategori', function (Blueprint $table) {
            $table->id('id_faq_kategori');
            $table->string('nama', 100);
            $table->foreignId('admin_role_id')
      ->constrained(table: 'roles', column: 'id_role')
      ->cascadeOnDelete();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('faq_kategori');
    }
};