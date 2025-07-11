<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('persalinans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kehamilan_id')->constrained()->onDelete('cascade');

            // Data Persalinan
            $table->date('tanggal_persalinan')->nullable();
            $table->time('waktu_persalinan')->nullable();
            $table->integer('umur_kehamilan_minggu')->nullable();
            $table->enum('penolong_persalinan', ['SpOG', 'Dokter Umum', 'Bidan', 'Lainnya'])->default('Bidan')->nullable();
            $table->enum('cara_persalinan', ['Normal', 'Forceps', 'Vakum', 'Sectio Caesarea', 'Lainnya'])->default('Normal')->nullable();
            $table->enum('keadaan_ibu', ['Sehat', 'Sakit', 'Meninggal'])->default('Sehat')->nullable();
            $table->text('detail_keadaan_ibu')->nullable(); // Untuk pendarahan/demam/kejang/dll
            $table->string('kb_pasca_persalinan')->nullable();
            $table->text('keterangan_tambahan')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('persalinans');
    }
};
