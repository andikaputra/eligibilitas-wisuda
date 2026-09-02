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
        Schema::create('yudisiums', function (Blueprint $table) {
            $table->id();

            // Username mahasiswa
            $table->string('user_id');

            // Folder Google Drive berisi:
            // 1. Pas Foto
            // 2. Foto Orang Tua / Keluarga
            $table->text('link_foto')->nullable();

            // Validasi Foto
            // 0 = Belum divalidasi
            // 1 = Disetujui
            // 2 = Ditolak / Perlu diperbaiki
            $table->unsignedTinyInteger('validasi_foto')->default(0);

            // Pembayaran Alumni & Kemahasiswaan
            $table->text('link_pembayaran_alumni')->nullable();

            // Validasi Pembayaran Alumni
            // 0 = Belum divalidasi
            // 1 = Disetujui
            // 2 = Ditolak / Perlu diperbaiki
            $table->unsignedTinyInteger('validasi_pembayaran_alumni')->default(0);

            // Bebas Administrasi Keuangan
            $table->text('link_bebas_keuangan')->nullable();

            // Validasi Bebas Administrasi Keuangan
            // 0 = Belum divalidasi
            // 1 = Disetujui
            // 2 = Ditolak / Perlu diperbaiki
            $table->unsignedTinyInteger('validasi_bebas_keuangan')->default(0);

            // Catatan dari Superadmin
            $table->text('catatan')->nullable();

            $table->timestamps();

            // Index agar pencarian berdasarkan mahasiswa lebih cepat
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yudisiums');
    }
};