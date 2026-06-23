<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('produksi_mangga', function (Blueprint $table) {
            $table->uuid('varietas_mangga_id')->nullable()->after('triwulan');
            $table->foreign('varietas_mangga_id')
                ->references('id')
                ->on('varietas_mangga')
                ->nullOnDelete();
        });

        $existingVarietas = DB::table('produksi_mangga')
            ->select('varietas')
            ->whereNotNull('varietas')
            ->where('varietas', '!=', '')
            ->distinct()
            ->pluck('varietas');

        foreach ($existingVarietas as $index => $namaVarietas) {
            $existingId = DB::table('varietas_mangga')
                ->where('nama_varietas', $namaVarietas)
                ->value('id');

            $varietasId = $existingId ?: (string) Str::uuid();

            if (! $existingId) {
                DB::table('varietas_mangga')->insert([
                    'id' => $varietasId,
                    'kode_varietas' => 'AUTO-' . str_pad((string) ($index + 1), 3, '0', STR_PAD_LEFT),
                    'nama_varietas' => $namaVarietas,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::table('produksi_mangga')
                ->where('varietas', $namaVarietas)
                ->update(['varietas_mangga_id' => $varietasId]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produksi_mangga', function (Blueprint $table) {
            $table->dropForeign(['varietas_mangga_id']);
            $table->dropColumn('varietas_mangga_id');
        });
    }
};
