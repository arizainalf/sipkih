<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 public function up(): void
    {
        Schema::create('ibus', function (Blueprint $table) {
            $table->id();
            $table->string('nik')->unique();
            $table->string('nama');
            $table->enum('pembiayaan', ['Mandiri','KIS', 'KIP']);
            $table->string('no_jkn');
            $table->string('golongan_darah');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('pendidikan', ['sd', 'smp', 'sma', 'd3', 's1', 's2', 's3']);
            $table->string('pekerjaan');
            $table->text('alamat');
            $table->string('telepon');
            $table->string('suami');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ibus');
    }
};
