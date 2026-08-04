<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\ProduksiMangga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
            ->when($selectedKecamatanId, fn($query, $kecamatanId) => $query->where('kecamatan_id', $kecamatanId))
            ->orderBy('tahun', 'ASC')
            ->orderByRaw($this->quarterOrderSql())
            ->get(['tahun', 'triwulan', 'produksi']);

        // Map data secara aman agar menghasilkan Plain Array untuk JSON Payload Python
        if (filled($selectedKecamatan)) {
            $dataFormatted = $rawData->map(function ($item) {
                // Normalisasi triwulan agar selalu Q1, Q2, Q3, Q4
                $triwulanRaw = strtoupper(trim((string) $item->triwulan));
                if (! str_starts_with($triwulanRaw, 'Q')) {
                    $triwulanRaw = 'Q' . preg_replace('/\D/', '', $triwulanRaw);
                }

                return [
                    'tahun' => (int) $item->tahun,
                    'triwulan' => $triwulanRaw,
                    'produksi' => (float) $item->produksi,
                ];
            })->values()->all();
        } else {
            $dataFormatted = $rawData
                ->groupBy(fn($item) => $item->tahun . '-' . $item->triwulan)
                ->map(function ($items) {
                    $sample = $items->first();

                    $triwulanRaw = strtoupper(trim((string) $sample->triwulan));
                    if (! str_starts_with($triwulanRaw, 'Q')) {
                        $triwulanRaw = 'Q' . preg_replace('/\D/', '', $triwulanRaw);
                    }

                    return [
                        'tahun' => (int) $sample->tahun,
                        'triwulan' => $triwulanRaw,
                        'produksi' => (float) round((float) $items->sum('produksi'), 2),
                    ];
                })
                ->values()
                ->all(); // Mengubah Collection ke Native PHP Array
        }

        if (empty($dataFormatted)) {
            return redirect('/pages/dashboard?kecamatan=' . urlencode((string) $selectedKecamatan))
                ->with('error', 'Data kecamatan yang dipilih belum tersedia untuk diprediksi.');
        }

        try {
            $serviceUrl = rtrim((string) config('app.env_python'));

            $response = Http::timeout(20)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])
                ->post($serviceUrl . '/predict', [
                    'data' => $dataFormatted,
                    'steps' => 4,
                    'kecamatan' => $selectedKecamatanLabel ? (string) $selectedKecamatanLabel : null,
                ]);

            if (! $response->successful()) {
                // Log pesan error asli jika Python mengembalikan respons kegagalan
                Log::error('Dashboard Store Python API Error: ' . $response->status() . ' - ' . $response->body());

                return redirect('/pages/dashboard?kecamatan=' . urlencode((string) $selectedKecamatan))
                    ->with('error', 'Service Python gagal dipanggil dengan status ' . $response->status() . '.');
            }

            $result = $response->json();

            return redirect('/pages/dashboard?kecamatan=' . urlencode((string) $selectedKecamatan))
                ->with('result', $result['data'] ?? [])
                ->with('prediction_summary', $result['summary'] ?? []);
        } catch (\Throwable $e) {
            Log::error('Dashboard Store Python API Connection Error: ' . $e->getMessage());

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
