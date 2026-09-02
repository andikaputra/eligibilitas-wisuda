<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ijazahs', function (Blueprint $table) {

            $table->id();

            // Relasi ke mahasiswa
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Data Ijazah
            $table->string('nama');
            $table->string('nik');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('nim');
            $table->string('prodi');

            // Status validasi
            // NULL = belum divalidasi
            // 1    = valid
            // 2    = ditolak
            $table->tinyInteger('validasi_nama')->nullable();
            $table->tinyInteger('validasi_nik')->nullable();
            $table->tinyInteger('validasi_tempat_lahir')->nullable();
            $table->tinyInteger('validasi_tanggal_lahir')->nullable();
            $table->tinyInteger('validasi_nim')->nullable();
            $table->tinyInteger('validasi_prodi')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ijazahs');
    }
};