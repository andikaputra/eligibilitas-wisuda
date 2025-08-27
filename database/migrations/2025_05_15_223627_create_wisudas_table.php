<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWisudasTable extends Migration
{
    public function up()
    {
        Schema::create('wisudas', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('link_bukti_pembayaran')->nullable();
            $table->string('link_pasphoto')->nullable();
            $table->string('link_repositori')->nullable();
            $table->string('link_publish_jurnal')->nullable();
            $table->string('link_bukti_skripsi')->nullable();
            $table->string('link_bukti_perpus')->nullable();

            // Status validasi oleh bendahara dan admin_perpus
            $table->integer('validasi_bendahara')->default(0);
            $table->integer('validasi_repo')->default(0);
            $table->integer('validasi_jurnal')->default(0);
            $table->integer('validasi_skripsi')->default(0);
            $table->integer('validasi_perpus')->default(0);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wisudas');
    }
}
