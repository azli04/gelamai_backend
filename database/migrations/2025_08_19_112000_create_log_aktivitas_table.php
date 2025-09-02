<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('log_aktivitas', function (Blueprint $table) {
            $table->id('id_log');
            $table->foreignId('id_user')->constrained('users','id_user')->onDelete('cascade');
            $table->text('aktivitas');
            $table->timestamp('waktu')->useCurrent();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('log_aktivitas');
    }
};
