<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('yudisiums', function (Blueprint $table) {
            $table->text('link_pembayaran_yudisium')
                ->nullable()
                ->after('link_bebas_keuangan');

            $table->tinyInteger('validasi_pembayaran_yudisium')
                ->default(0)
                ->after('link_pembayaran_yudisium');
        });
    }

    public function down(): void
    {
        Schema::table('yudisiums', function (Blueprint $table) {
            $table->dropColumn([
                'link_pembayaran_yudisium',
                'validasi_pembayaran_yudisium',
            ]);
        });
    }
};