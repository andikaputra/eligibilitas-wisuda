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
        Schema::table('wisudas', function (Blueprint $table) {

            // Bukti Artikel Publish / LOA
            $table->text('link_artikel_loa')
                ->nullable()
                ->after('link_bukti_perpus');

            // Bukti Setor Hardcopy
            $table->text('link_bukti_hardcopy')
                ->nullable()
                ->after('link_artikel_loa');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wisudas', function (Blueprint $table) {

            $table->dropColumn([
                'link_artikel_loa',
                'link_bukti_hardcopy',
            ]);

        });
    }
};