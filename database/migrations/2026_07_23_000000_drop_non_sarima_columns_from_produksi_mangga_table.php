<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produksi_mangga', function (Blueprint $table) {
            $table->dropColumn([
                'curah_hujan',
                'suhu',
                'pupuk_organik',
                'serangan_hama',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('produksi_mangga', function (Blueprint $table) {
            $table->double('curah_hujan')->nullable();
            $table->double('suhu')->nullable();
            $table->double('pupuk_organik')->nullable();
            $table->double('serangan_hama')->nullable();
        });
    }
};
