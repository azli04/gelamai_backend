<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('berita_event', function (Blueprint $table) {
            $table->enum('status', ['draft', 'publish'])
                  ->default('draft')
                  ->after('views'); // taruh setelah kolom 'views'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('berita_event', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
