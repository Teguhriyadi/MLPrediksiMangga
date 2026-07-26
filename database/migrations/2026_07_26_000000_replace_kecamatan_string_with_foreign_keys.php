<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'kecamatan_id')) {
                $table->foreignId('kecamatan_id')->nullable()->after('role');
            }
        });

        Schema::table('produksi_mangga', function (Blueprint $table) {
            if (! Schema::hasColumn('produksi_mangga', 'kecamatan_id')) {
                $table->foreignId('kecamatan_id')->nullable()->after('id');
            }
        });

        $kecamatanMap = DB::table('kecamatans')
            ->pluck('id', 'nama');

        if (Schema::hasColumn('users', 'kecamatan')) {
            DB::table('users')
                ->select('id', 'kecamatan')
                ->whereNotNull('kecamatan')
                ->orderBy('id')
                ->get()
                ->each(function ($user) use ($kecamatanMap) {
                    $kecamatanId = $kecamatanMap[$user->kecamatan] ?? null;

                    DB::table('users')
                        ->where('id', $user->id)
                        ->update(['kecamatan_id' => $kecamatanId]);
                });
        }

        if (Schema::hasColumn('produksi_mangga', 'kecamatan')) {
            DB::table('produksi_mangga')
                ->select('id', 'kecamatan')
                ->whereNotNull('kecamatan')
                ->orderBy('id')
                ->get()
                ->each(function ($produksi) use ($kecamatanMap) {
                    $kecamatanId = $kecamatanMap[$produksi->kecamatan] ?? null;

                    DB::table('produksi_mangga')
                        ->where('id', $produksi->id)
                        ->update(['kecamatan_id' => $kecamatanId]);
                });
        }

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('kecamatan_id')->references('id')->on('kecamatans')->nullOnDelete();
        });

        Schema::table('produksi_mangga', function (Blueprint $table) {
            $table->foreign('kecamatan_id')->references('id')->on('kecamatans')->nullOnDelete();
        });

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'kecamatan')) {
                $table->dropColumn('kecamatan');
            }
        });

        Schema::table('produksi_mangga', function (Blueprint $table) {
            if (Schema::hasColumn('produksi_mangga', 'kecamatan')) {
                $table->dropColumn('kecamatan');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'kecamatan')) {
                $table->string('kecamatan')->nullable()->after('role');
            }
        });

        Schema::table('produksi_mangga', function (Blueprint $table) {
            if (! Schema::hasColumn('produksi_mangga', 'kecamatan')) {
                $table->string('kecamatan', 150)->nullable()->after('id');
            }
        });

        $kecamatanMap = DB::table('kecamatans')
            ->pluck('nama', 'id');

        DB::table('users')
            ->select('id', 'kecamatan_id')
            ->whereNotNull('kecamatan_id')
            ->orderBy('id')
            ->get()
            ->each(function ($user) use ($kecamatanMap) {
                DB::table('users')
                    ->where('id', $user->id)
                    ->update(['kecamatan' => $kecamatanMap[$user->kecamatan_id] ?? null]);
            });

        DB::table('produksi_mangga')
            ->select('id', 'kecamatan_id')
            ->whereNotNull('kecamatan_id')
            ->orderBy('id')
            ->get()
            ->each(function ($produksi) use ($kecamatanMap) {
                DB::table('produksi_mangga')
                    ->where('id', $produksi->id)
                    ->update(['kecamatan' => $kecamatanMap[$produksi->kecamatan_id] ?? null]);
            });

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['kecamatan_id']);
            $table->dropColumn('kecamatan_id');
        });

        Schema::table('produksi_mangga', function (Blueprint $table) {
            $table->dropForeign(['kecamatan_id']);
            $table->dropColumn('kecamatan_id');
        });
    }
};
