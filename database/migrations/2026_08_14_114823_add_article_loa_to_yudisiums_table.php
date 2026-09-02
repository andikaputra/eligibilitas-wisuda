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
        Schema::table('yudisiums', function (Blueprint $table) {

            // Bukti Artikel Publish / LOA
            $table->text('link_artikel_loa')
                ->nullable()
                ->after('link_pembayaran_yudisium');

            // Validasi Artikel / LOA
            // 0 = Belum divalidasi
            // 1 = Disetujui
            // 2 = Ditolak / Perlu diperbaiki
            $table->unsignedTinyInteger('validasi_artikel_loa')
                ->default(0)
                ->after('link_artikel_loa');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('yudisiums', function (Blueprint $table) {

            $table->dropColumn([
                'link_artikel_loa',
                'validasi_artikel_loa',
            ]);

        });
    }
};