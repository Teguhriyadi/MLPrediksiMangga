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
        Schema::create('varietas_mangga', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('kode_varietas', 50)->unique();
            $table->string('nama_varietas', 100);
            $table->string('asal_varietas', 150)->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('varietas_mangga');
    }
};
