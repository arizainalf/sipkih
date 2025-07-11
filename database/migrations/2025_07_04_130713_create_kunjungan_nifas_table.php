<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kunjungan_nifas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('persalinan_id')->constrained()->onDelete('cascade');

            // Data Umum Kunjungan
            $table->date('tanggal_kunjungan')->default(now());
            $table->string('faskes')->nullable(); // Fasilitas Kesehatan

            // Masalah yang Ditemukan
            $table->text('masalah')->nullable();

            // Tindakan
            $table->text('tindakan')->nullable();

            // Checklist KF1 (6-48 jam)
            $table->boolean('asi')->default(false);
            $table->boolean('belum_asi')->default(false);
            $table->boolean('trauma')->default(false);
            $table->text('message')->nullable();

            // Checklist KF2 (3-7 hari)
            $table->boolean('belum_bab')->default(false);

            // Checklist KF3 (8-28 hari)
            $table->boolean('tetanus')->default(false);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kunjungan_nifas');
    }
};
