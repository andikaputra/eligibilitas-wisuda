<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('wisudas', function (Blueprint $table) {

            // Bukti Bebas Perpustakaan untuk Wisuda
            $table->string('link_bukti_bebas_perpus')
                ->nullable();

            // Validasi Bebas Perpustakaan untuk Wisuda
            $table->tinyInteger('validasi_bebas_perpus')
                ->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('wisudas', function (Blueprint $table) {

            $table->dropColumn([
                'link_bukti_bebas_perpus',
                'validasi_bebas_perpus',
            ]);
        });
    }
};