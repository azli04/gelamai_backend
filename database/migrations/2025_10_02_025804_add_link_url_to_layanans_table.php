<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('layanans', function (Blueprint $table) {
            $table->string('link_url')->nullable()->after('details');
            // nullable biar opsional, after untuk urutan kolom
        });
    }

    public function down(): void
    {
        Schema::table('layanans', function (Blueprint $table) {
            $table->dropColumn('link_url');
        });
    }
};
