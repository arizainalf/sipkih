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
        Schema::create('pelayanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kehamilan_id')->constrained('kehamilans')->onDelete('CASCADE');
            $table->string('trismester');
            $table->string('tanggal_periksa');
            $table->decimal('tb');
            $table->decimal('bb');
            $table->decimal('lingkar_lengan_atas');
            $table->string('detak_jantung_janin');
            $table->decimal('tinggi_rahim');
            $table->string('konseling');
            $table->string('test_hb');
            $table->string('test_golongan_darah');
            $table->string('test_protein_urin');
            $table->string('test_gula_darah');
            $table->enum('ppia',['reaktif','non reaktif']);
            $table->string('tata_laksana_kasus')->nullable();
            $table->string('usg');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelayanans');
    }
};
