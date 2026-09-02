<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('wisudas', function (Blueprint $table) {
            $table->integer('validasi_bebas_perpus_wisuda')
                ->default(0)
                ->after('validasi_pembayaran_wisuda');
        });
    }

    public function down(): void
    {
        Schema::table('wisudas', function (Blueprint $table) {
            $table->dropColumn('validasi_bebas_perpus_wisuda');
        });
    }
};