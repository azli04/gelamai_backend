<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('parameter_uji', function (Blueprint $table) {
            $table->id('id_parameter');
            $table->string('nama_parameter',255);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('parameter_uji');
    }
};
    