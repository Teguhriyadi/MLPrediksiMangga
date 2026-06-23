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
        Schema::table('produksi_mangga', function (Blueprint $table) {
            $table->string('kecamatan', 150)->nullable();
            $table->string('varietas', 100)->nullable();
            $table->double('jumlah_pohon')->nullable();
            $table->integer('umur_tanaman')->nullable();
            $table->double('pupuk_organik')->nullable();
            $table->double('serangan_hama')->nullable();
            $table->text('catatan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produksi_mangga', function (Blueprint $table) {
            $table->dropColumn([
                'kecamatan',
                'varietas',
                'jumlah_pohon',
                'umur_tanaman',
                'pupuk_organik',
                'serangan_hama',
                'catatan',
            ]);
        });
    }
};
