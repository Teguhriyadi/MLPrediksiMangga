<?php

namespace App\Http\Controllers;

use App\Models\ProduksiMangga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppController extends Controller
{
    public function dashboard(Request $request)
    {
        $selectedKecamatan = $request->input('kecamatan');

        $data["opsiKecamatan"] = ProduksiMangga::query()
            ->pluck('kecamatan')
            ->filter()
            ->unique()
            ->sort()
            ->values()
            ->all();

        $data["selectedKecamatan"] = $selectedKecamatan;
        $rawProduksi = ProduksiMangga::query()
            ->when($selectedKecamatan, fn ($query, $kecamatan) => $query->where('kecamatan', $kecamatan))
            ->orderBy('tahun', 'ASC')
            ->orderByRaw($this->quarterOrderSql())
            ->get();

        $data["totalRecord"] = $rawProduksi->count();
        $data["periodeMin"] = $rawProduksi->min('tahun');
        $data["periodeMax"] = $rawProduksi->max('tahun');
        $data["isAgregatKabupaten"] = ! filled($selectedKecamatan);
        $data["produksi"] = filled($selectedKecamatan)
            ? $rawProduksi
            : $rawProduksi
                ->groupBy(fn ($item) => $item->tahun . '-' . $item->triwulan)
                ->map(function ($items) {
                    $sample = $items->first();

                    return (object) [
                        'tahun' => $sample->tahun,
                        'triwulan' => $sample->triwulan,
                        'produksi' => round((float) $items->sum('produksi'), 2),
                    ];
                })
                ->values();

        return view("pages.dashboard", $data);
    }

    public function logout()
    {
        Auth::logout();

        return redirect("/login")->with("success", "Anda Berhasil Logout");
    }

    private function quarterOrderSql(string $direction = 'ASC'): string
    {
        $direction = strtoupper($direction) === 'DESC' ? 'DESC' : 'ASC';

        return "CASE triwulan
            WHEN 'Q1' THEN 1
            WHEN 'Q2' THEN 2
            WHEN 'Q3' THEN 3
            WHEN 'Q4' THEN 4
            ELSE 5
        END {$direction}";
    }
}
