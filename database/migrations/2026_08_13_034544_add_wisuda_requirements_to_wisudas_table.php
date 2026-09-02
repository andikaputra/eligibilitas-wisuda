<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('wisudas', function (Blueprint $table) {

            $table->string('link_tracer_study')
                ->nullable()
                ->after('link_repositori');

            $table->string('link_pembayaran_wisuda')
                ->nullable()
                ->after('link_tracer_study');

            $table->unsignedTinyInteger('validasi_repositori')
                ->default(0)
                ->after('link_pembayaran_wisuda');

            $table->unsignedTinyInteger('validasi_tracer_study')
                ->default(0)
                ->after('validasi_repositori');

            $table->unsignedTinyInteger('validasi_pembayaran_wisuda')
                ->default(0)
                ->after('validasi_tracer_study');
        });
    }

    public function down(): void
    {
        Schema::table('wisudas', function (Blueprint $table) {

            $table->dropColumn([
                'link_tracer_study',
                'link_pembayaran_wisuda',
                'validasi_repositori',
                'validasi_tracer_study',
                'validasi_pembayaran_wisuda',
            ]);

        });
    }
};