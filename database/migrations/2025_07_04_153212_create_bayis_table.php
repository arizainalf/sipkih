<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bayis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('persalinan_id')->constrained()->onDelete('cascade');

            // Data Bayi
            $table->integer('berat_lahir_gram')->nullable();
            $table->integer('panjang_badan_cm')->nullable();
            $table->integer('lingkar_kepala_cm')->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan', 'Tidak bisa ditentukan'])->nullable();

            // Kondisi bayi saat lahir (boolean flags)
            $table->boolean('segera_menangis')->default(false);
            $table->boolean('menangis_beberapa_saat')->default(false);
            $table->boolean('tidak_menangis')->default(false);
            $table->boolean('seluruh_tubuh_kemerahan')->default(false);
            $table->boolean('anggota_gerak_kebiruan')->default(false);
            $table->boolean('seluruh_tubuh_biru')->default(false);
            $table->string('kelainan_bawaan')->nullable();
            $table->boolean('meninggal')->default(false);

            // Asuhan bayi baru lahir (boolean flags)
            $table->boolean('imd')->default(false);
            $table->boolean('vitamin_k1')->default(false);
            $table->boolean('salep_mata')->default(false);
            $table->boolean('imunisasi_hb0')->default(false);

            $table->text('keterangan_tambahan')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bayis');
    }
};
