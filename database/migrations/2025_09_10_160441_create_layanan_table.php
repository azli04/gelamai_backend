<?php

// database/migrations/2025_09_10_000001_create_layanans_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('layanans', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->string('image')->nullable(); // cover/thumbnail
    $table->longText('details')->nullable(); // HTML dari ReactQuill
    $table->timestamps();
});
    }

    public function down(): void {
        Schema::dropIfExists('layanans');
    }
};
