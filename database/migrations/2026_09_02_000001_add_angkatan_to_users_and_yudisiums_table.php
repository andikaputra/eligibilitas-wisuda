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
        // Tambahkan kolom angkatan di tabel users secara aman (nullable)
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'angkatan')) {
                $table->string('angkatan', 20)->nullable()->after('prodi');
            }
        });

        // Tambahkan kolom angkatan di tabel yudisiums secara aman (nullable)
        Schema::table('yudisiums', function (Blueprint $table) {
            if (!Schema::hasColumn('yudisiums', 'angkatan')) {
                $table->string('angkatan', 20)->nullable()->after('user_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'angkatan')) {
                $table->dropColumn('angkatan');
            }
        });

        Schema::table('yudisiums', function (Blueprint $table) {
            if (Schema::hasColumn('yudisiums', 'angkatan')) {
                $table->dropColumn('angkatan');
            }
        });
    }
};
