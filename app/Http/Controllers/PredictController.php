<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\ProduksiMangga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PredictController extends Controller
{
    public function store(Request $request)
    {
        $selectedKecamatan = $request->input('kecamatan');

        if (Auth::user()?->role === \App\Models\User::ROLE_UPTD && Auth::user()?->kecamatan_id) {
            $selectedKecamatan = (string) Auth::user()->kecamatan_id;
        }

        $selectedKecamatanId = filled($selectedKecamatan) ? (int) $selectedKecamatan : null;
        $selectedKecamatanLabel = $selectedKecamatanId
            ? Kecamatan::query()->whereKey($selectedKecamatanId)->value('nama')
            : null;

        $rawData = ProduksiMangga::query()
            ->when($selectedKecamatanId, fn ($query, $kecamatanId) => $query->where('kecamatan_id', $kecamatanId))
            ->orderBy('tahun', 'ASC')
            ->orderByRaw($this->quarterOrderSql())
            ->get(['tahun', 'triwulan', 'produksi']);

        $data = filled($selectedKecamatan)
            ? $rawData
            : $rawData
                ->groupBy(fn ($item) => $item->tahun . '-' . $item->triwulan)
                ->map(function ($items) {
                    $sample = $items->first();

                    return [
                        'tahun' => (int) $sample->tahun,
                        'triwulan' => $sample->triwulan,
                        'produksi' => round((float) $items->sum('produksi'), 2),
                    ];
                })
                ->values();

        if ($data->isEmpty()) {
            return redirect('/pages/dashboard?kecamatan=' . urlencode((string) $selectedKecamatan))
                ->with('error', 'Data kecamatan yang dipilih belum tersedia untuk diprediksi.');
        }

        try {
            $response = Http::timeout(20)->post(rtrim((string) config('app.env_python')) . "/predict", [
                'data' => $data,
                'steps' => 4,
                'kecamatan' => $selectedKecamatanLabel,
            ]);

            if (! $response->successful()) {
                return redirect('/pages/dashboard?kecamatan=' . urlencode((string) $selectedKecamatan))
                    ->with('error', 'Service Python gagal dipanggil.');
            }

            $result = $response->json();

            return redirect('/pages/dashboard?kecamatan=' . urlencode((string) $selectedKecamatan))
                ->with('result', $result['data'] ?? [])
                ->with('prediction_summary', $result['summary'] ?? []);
        } catch (\Throwable) {
            return redirect('/pages/dashboard?kecamatan=' . urlencode((string) $selectedKecamatan))
                ->with('error', 'Service Python belum aktif atau tidak dapat dihubungi.');
        }
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
