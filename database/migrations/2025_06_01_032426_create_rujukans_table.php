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
        Schema::create('rujukans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ibu_id')->nullable()->constrained('ibus')->nullOnDelete()->cascadeOnUpdate();
            $table->string('alasan');
            $table->date('tanggal_rujukan');
            $table->string('diagnosa_akhir');
            $table->string('anjuran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rujukans');
    }
};
