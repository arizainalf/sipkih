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
        Schema::create('kehamilans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ibu_id')->constrained('ibus')->onDelete('CASCADE');
            $table->string('anak_ke');
            $table->string('bulan')->nullable();
            $table->string('tahun')->nullable();
            $table->enum('kendaraan', ['pribadi', 'ambulance'])->default('pribadi');
            $table->string('kontrasepsi')->nullable();
            $table->string('sumbangan_darah')->nullable();
            $table->enum('dana_persalinan', ['sendiri', 'jkn', 'jampersal'])->default('sendiri');
            $table->string('bidan')->nullable();
            $table->unique(['ibu_id', 'anak_ke']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kehamilans');
    }
};
