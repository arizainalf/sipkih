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

            // Checklist KF1 (6-48 jam)
            $table->date('tanggal_kunjungan_kf_1')->default(now());
            $table->string('faskes_kf_1')->nullable();
            $table->text('masalah_kf_1')->nullable();
            $table->text('tindakan_kf_1')->nullable();

            // Checklist KF2 (3-7 hari)
            $table->date('tanggal_kunjungan_kf_2')->nullable();
            $table->string('faskes_kf_2')->nullable();
            $table->text('masalah_kf_2')->nullable();
            $table->text('tindakan_kf_2')->nullable();

            // Checklist KF3 (8-28 hari)
            $table->date('tanggal_kunjungan_kf_3')->nullable();
            $table->string('faskes_kf_3')->nullable();
            $table->text('masalah_kf_3')->nullable();
            $table->text('tindakan_kf_3')->nullable();

            // Checklist KF4 (28 hari ke atas)
            $table->date('tanggal_kunjungan_kf_4')->nullable();
            $table->string('faskes_kf_4')->nullable();
            $table->text('masalah_kf_4')->nullable();
            $table->text('tindakan_kf_4')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kunjungan_nifas');
    }
};
