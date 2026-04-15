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
        Schema::create('produksi_mangga', function (Blueprint $table) {
            $table->uuid("id", 50)->primary();
            $table->integer("tahun");
            $table->string("triwulan", 100);
            $table->double("luas_tanam");
            $table->double("luas_panen");
            $table->double("curah_hujan");
            $table->double("suhu");
            $table->double("produksi");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produksi_mangga');
    }
};
