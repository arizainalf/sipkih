<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kesimpulan_nifas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('persalinan_id')->constrained()->onDelete('cascade');

            // Keadaan Ibu
            $table->enum('keadaan_ibu', ['Sehat', 'Sakit', 'Meninggal']);

            // Komplikasi Nifas (boolean flags)
            $table->boolean('perdarahan')->default(false);
            $table->boolean('infeksi')->default(false);
            $table->boolean('hipertensi')->default(false);
            $table->string('komplikasi_lain')->nullable();

            // Keadaan Bayi
            $table->enum('keadaan_bayi', ['Sehat', 'Sakit', 'Meninggal']);
            $table->string('kelainan_bawaan')->nullable();

            $table->text('catatan')->nullable();
            $table->text('kesimpulan')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kesimpulan_nifas');
    }
};
