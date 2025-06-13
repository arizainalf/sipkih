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
        Schema::create('nifas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kehamilan_id')->constrained('kehamilans')->onDelete('CASCADE');
            $table->boolean('periksa_asi')->default(false);
            $table->boolean('periksa_perdarahan')->default(false);
            $table->boolean('periksa_jalan_lahir')->default(false);
            $table->string('vitamin_a')->nullable();
            $table->enum('kb_pasca_kelahiran', ['suntik', 'pil'])->nullable();
            $table->boolean('konseling')->default(false);
            $table->boolean('tata_laksana_kasus')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nifas');
    }
};
