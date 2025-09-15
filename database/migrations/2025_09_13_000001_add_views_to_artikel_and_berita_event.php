<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('artikel')) {
            Schema::table('artikel', function (Blueprint $table) {
                if (!Schema::hasColumn('artikel', 'views')) {
                    $table->unsignedBigInteger('views')->default(0)->after('tanggal');
                }
            });
        }

        if (Schema::hasTable('berita_event')) {
            Schema::table('berita_event', function (Blueprint $table) {
                if (!Schema::hasColumn('berita_event', 'views')) {
                    $table->unsignedBigInteger('views')->default(0)->after('tanggal');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('artikel')) {
            Schema::table('artikel', function (Blueprint $table) {
                if (Schema::hasColumn('artikel', 'views')) {
                    $table->dropColumn('views');
                }
            });
        }

        if (Schema::hasTable('berita_event')) {
            Schema::table('berita_event', function (Blueprint $table) {
                if (Schema::hasColumn('berita_event', 'views')) {
                    $table->dropColumn('views');
                }
            });
        }
    }
};
