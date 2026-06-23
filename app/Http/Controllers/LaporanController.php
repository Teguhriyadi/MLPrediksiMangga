<?php

namespace App\Http\Controllers;

use App\Exports\LaporanExport;
use App\Models\ProduksiMangga;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $reportType = $this->normalizeJenisLaporan($request->input('jenis'));
        $filters = $this->extractFilters($request);
        $reportData = $this->buildReport($reportType, $filters);
        $paginatedRows = $this->paginateRows($reportData['rows'] ?? [], $request);

        return view('pages.laporan.index', [
            'jenisLaporan' => $reportType,
            'filters' => $filters,
            'hasilLaporan' => $reportData,
            'paginatedRows' => $paginatedRows,
            'opsiKecamatan' => $this->getDaftarKecamatan(),
            'opsiTahun' => $this->getDaftarTahun(),
            'opsiJenis' => $this->getJenisLaporanOptions(),
        ]);
    }

    public function exportExcel(Request $request)
    {
        $reportType = $this->normalizeJenisLaporan($request->input('jenis'));
        $filters = $this->extractFilters($request);
        $reportData = $this->buildReport($reportType, $filters);

        $filename = 'laporan-' . $reportType . '-' . now()->format('Ymd-His') . '.xlsx';

        return Excel::download(new LaporanExport($reportData), $filename);
    }

    public function exportPdf(Request $request)
    {
        $reportType = $this->normalizeJenisLaporan($request->input('jenis'));
        $filters = $this->extractFilters($request);
        $reportData = $this->buildReport($reportType, $filters);
        $paperConfig = $this->resolvePdfPaper($reportData);

        $pdf = Pdf::loadView('pages.laporan.pdf', [
            'hasilLaporan' => $reportData,
            'paperConfig' => $paperConfig,
        ])->setPaper($paperConfig['size'], $paperConfig['orientation']);

        $filename = 'laporan-' . $reportType . '-' . now()->format('Ymd-His') . '.pdf';

        return $pdf->download($filename);
    }

    private function buildReport(string $reportType, array $filters): array
    {
        return match ($reportType) {
            'rekap-kecamatan' => $this->buildKecamatanReport($filters),
            'rekap-tahunan' => $this->buildTahunanReport($filters),
            'prediksi-sarima' => $this->buildPrediksiReport($filters),
            default => $this->buildProduksiReport($filters),
        };
    }

    private function buildProduksiReport(array $filters): array
    {
        $rows = $this->baseFilteredQuery($filters)
            ->with('varietasMangga')
            ->orderByDesc('tahun')
            ->orderByRaw($this->quarterOrderSql('DESC'))
            ->get();

        $mappedRows = $rows->map(function ($item, $index) {
            $produktvitas = (float) $item->luas_panen > 0 ? ((float) $item->produksi / (float) $item->luas_panen) : 0;

            return [
                'No' => $index + 1,
                'Kecamatan' => $item->kecamatan ?? '-',
                'Tahun' => $item->tahun,
                'Triwulan' => $item->triwulan,
                'Varietas' => $item->varietasMangga->nama_varietas ?? ($item->varietas ?? '-'),
                'Luas Tanam (ha)' => number_format((float) $item->luas_tanam, 2, ',', '.'),
                'Luas Panen (ha)' => number_format((float) $item->luas_panen, 2, ',', '.'),
                'Jumlah Pohon' => number_format((float) ($item->jumlah_pohon ?? 0), 0, ',', '.'),
                'Curah Hujan (mm)' => number_format((float) $item->curah_hujan, 2, ',', '.'),
                'Suhu (C)' => number_format((float) $item->suhu, 2, ',', '.'),
                'Produksi (ton)' => number_format((float) $item->produksi, 2, ',', '.'),
                'Produktivitas (ton/ha)' => number_format($produktvitas, 2, ',', '.'),
            ];
        });

        return [
            'title' => 'Laporan Data Produksi Mangga',
            'subtitle' => 'Menampilkan data produksi mangga per kecamatan dan per triwulan.',
            'filters' => $filters,
            'headers' => array_keys($mappedRows->first() ?? ['Data' => 'Tidak tersedia']),
            'rows' => $mappedRows,
            'summary' => [
                ['label' => 'Jumlah Data', 'value' => $rows->count()],
                ['label' => 'Total Produksi (ton)', 'value' => number_format((float) $rows->sum('produksi'), 2, ',', '.')],
                ['label' => 'Rata-rata Produksi (ton)', 'value' => number_format((float) $rows->avg('produksi'), 2, ',', '.')],
                ['label' => 'Kecamatan Tercatat', 'value' => $rows->pluck('kecamatan')->filter()->unique()->count()],
            ],
        ];
    }

    private function buildKecamatanReport(array $filters): array
    {
        $rows = $this->baseFilteredQuery($filters)
            ->selectRaw('kecamatan')
            ->selectRaw('COUNT(*) as jumlah_record')
            ->selectRaw('SUM(produksi) as total_produksi')
            ->selectRaw('AVG(produksi) as rata_produksi')
            ->selectRaw('SUM(luas_panen) as total_luas_panen')
            ->selectRaw('AVG(curah_hujan) as rata_curah_hujan')
            ->selectRaw('AVG(suhu) as rata_suhu')
            ->groupBy('kecamatan')
            ->orderBy('kecamatan')
            ->get();

        $mappedRows = $rows->map(function ($item, $index) {
            $produktvitas = (float) $item->total_luas_panen > 0 ? ((float) $item->total_produksi / (float) $item->total_luas_panen) : 0;

            return [
                'No' => $index + 1,
                'Kecamatan' => $item->kecamatan ?? '-',
                'Jumlah Record' => (int) $item->jumlah_record,
                'Total Produksi (ton)' => number_format((float) $item->total_produksi, 2, ',', '.'),
                'Rata-rata Produksi (ton)' => number_format((float) $item->rata_produksi, 2, ',', '.'),
                'Total Luas Panen (ha)' => number_format((float) $item->total_luas_panen, 2, ',', '.'),
                'Produktivitas (ton/ha)' => number_format($produktvitas, 2, ',', '.'),
                'Rata Curah Hujan (mm)' => number_format((float) $item->rata_curah_hujan, 2, ',', '.'),
                'Rata Suhu (C)' => number_format((float) $item->rata_suhu, 2, ',', '.'),
            ];
        });

        return [
            'title' => 'Laporan Rekap Produksi per Kecamatan',
            'subtitle' => 'Rekap akumulasi produksi dan indikator produktivitas berdasarkan kecamatan.',
            'filters' => $filters,
            'headers' => array_keys($mappedRows->first() ?? ['Data' => 'Tidak tersedia']),
            'rows' => $mappedRows,
            'summary' => [
                ['label' => 'Jumlah Kecamatan', 'value' => $rows->count()],
                ['label' => 'Total Produksi (ton)', 'value' => number_format((float) $rows->sum('total_produksi'), 2, ',', '.')],
                ['label' => 'Rata-rata Produksi/Kecamatan', 'value' => number_format((float) $rows->avg('rata_produksi'), 2, ',', '.')],
                ['label' => 'Total Luas Panen (ha)', 'value' => number_format((float) $rows->sum('total_luas_panen'), 2, ',', '.')],
            ],
        ];
    }

    private function buildTahunanReport(array $filters): array
    {
        $rows = $this->baseFilteredQuery($filters)
            ->selectRaw('tahun')
            ->selectRaw('COUNT(*) as jumlah_record')
            ->selectRaw('SUM(produksi) as total_produksi')
            ->selectRaw('AVG(produksi) as rata_produksi')
            ->selectRaw('SUM(luas_panen) as total_luas_panen')
            ->selectRaw('AVG(serangan_hama) as rata_serangan_hama')
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->get();

        $mappedRows = $rows->map(function ($item, $index) {
            $produktvitas = (float) $item->total_luas_panen > 0 ? ((float) $item->total_produksi / (float) $item->total_luas_panen) : 0;

            return [
                'No' => $index + 1,
                'Tahun' => $item->tahun,
                'Jumlah Record' => (int) $item->jumlah_record,
                'Total Produksi (ton)' => number_format((float) $item->total_produksi, 2, ',', '.'),
                'Rata-rata Produksi (ton)' => number_format((float) $item->rata_produksi, 2, ',', '.'),
                'Total Luas Panen (ha)' => number_format((float) $item->total_luas_panen, 2, ',', '.'),
                'Produktivitas (ton/ha)' => number_format($produktvitas, 2, ',', '.'),
                'Rata Serangan Hama (%)' => number_format((float) $item->rata_serangan_hama, 2, ',', '.'),
            ];
        });

        return [
            'title' => 'Laporan Rekap Produksi Tahunan',
            'subtitle' => 'Ringkasan capaian produksi mangga berdasarkan tahun pengamatan.',
            'filters' => $filters,
            'headers' => array_keys($mappedRows->first() ?? ['Data' => 'Tidak tersedia']),
            'rows' => $mappedRows,
            'summary' => [
                ['label' => 'Jumlah Tahun', 'value' => $rows->count()],
                ['label' => 'Total Produksi (ton)', 'value' => number_format((float) $rows->sum('total_produksi'), 2, ',', '.')],
                ['label' => 'Rata-rata Produksi Tahunan', 'value' => number_format((float) $rows->avg('total_produksi'), 2, ',', '.')],
                ['label' => 'Rata-rata Serangan Hama (%)', 'value' => number_format((float) $rows->avg('rata_serangan_hama'), 2, ',', '.')],
            ],
        ];
    }

    private function buildPrediksiReport(array $filters): array
    {
        $grouped = $this->baseFilteredQuery($filters)
            ->orderBy('kecamatan')
            ->orderBy('tahun')
            ->orderByRaw($this->quarterOrderSql())
            ->get()
            ->filter(fn ($item) => filled($item->kecamatan))
            ->groupBy('kecamatan');

        $compiledRows = $grouped->map(function (Collection $items, string $kecamatan) {
            $prediction = $this->requestPrediction($items, 4, $kecamatan);
            $summary = $prediction['summary'] ?? [];
            $evaluation = $prediction['evaluation'] ?? [];
            $firstForecast = collect($prediction['forecasts'] ?? [])->first();
            $lastData = $items->last();
            $forecastAverage = (float) ($summary['forecast_average'] ?? 0);
            $growthPercent = (float) ($summary['growth_percent'] ?? 0);
            $mape = (float) ($evaluation['mape'] ?? 0);
            $trend = ucfirst((string) ($summary['trend'] ?? '-'));

            return [
                'display' => [
                    'Kecamatan' => $kecamatan,
                    'Data Historis' => $items->count(),
                    'Periode Terakhir' => ($lastData?->tahun ? $lastData->tahun . ' ' . $lastData->triwulan : '-'),
                    'Produksi Terakhir (ton)' => number_format((float) ($summary['last_actual'] ?? 0), 2, ',', '.'),
                    'Forecast Berikutnya' => $firstForecast['periode'] ?? '-',
                    'Prediksi Berikutnya (ton)' => number_format((float) ($firstForecast['prediksi'] ?? 0), 2, ',', '.'),
                    'Rata-rata Forecast (ton)' => number_format($forecastAverage, 2, ',', '.'),
                    'Tren' => $trend,
                    'Growth (%)' => number_format($growthPercent, 2, ',', '.'),
                    'MAPE (%)' => number_format($mape, 2, ',', '.'),
                    'Status Model' => ! empty($prediction['error']) ? 'Service Offline' : strtoupper((string) ($summary['model_type'] ?? '-')),
                ],
                'forecast_average_raw' => $forecastAverage,
                'growth_percent_raw' => $growthPercent,
                'trend_raw' => $trend,
            ];
        })->values();

        $displayRows = $compiledRows->map(function ($row, $index) {
            return ['No' => $index + 1] + $row['display'];
        });

        return [
            'title' => 'Laporan Hasil Prediksi SARIMA',
            'subtitle' => 'Forecast produktivitas mangga per kecamatan berdasarkan histori data triwulan.',
            'filters' => $filters,
            'headers' => array_keys($displayRows->first() ?? ['Data' => 'Tidak tersedia']),
            'rows' => $displayRows,
            'summary' => [
                ['label' => 'Jumlah Kecamatan Diprediksi', 'value' => $compiledRows->count()],
                ['label' => 'Rata-rata Forecast (ton)', 'value' => number_format((float) $compiledRows->avg('forecast_average_raw'), 2, ',', '.')],
                ['label' => 'Rata-rata Growth (%)', 'value' => number_format((float) $compiledRows->avg('growth_percent_raw'), 2, ',', '.')],
                ['label' => 'Kecamatan Tren Naik', 'value' => $compiledRows->filter(fn ($item) => $item['trend_raw'] === 'Naik')->count()],
            ],
        ];
    }

    private function baseFilteredQuery(array $filters)
    {
        return ProduksiMangga::query()
            ->when($filters['tahun'], fn ($query, $tahun) => $query->where('tahun', $tahun))
            ->when($filters['kecamatan'], fn ($query, $kecamatan) => $query->where('kecamatan', $kecamatan));
    }

    private function extractFilters(Request $request): array
    {
        return [
            'tahun' => $request->filled('tahun') ? (int) $request->input('tahun') : null,
            'kecamatan' => $request->filled('kecamatan') ? (string) $request->input('kecamatan') : null,
        ];
    }

    private function normalizeJenisLaporan(?string $jenis): string
    {
        return in_array($jenis, ['produksi', 'rekap-kecamatan', 'rekap-tahunan'], true)
            || $jenis === 'prediksi-sarima'
            ? $jenis
            : 'produksi';
    }

    private function getJenisLaporanOptions(): array
    {
        return [
            'produksi' => 'Data Produksi Mangga',
            'rekap-kecamatan' => 'Rekap per Kecamatan',
            'rekap-tahunan' => 'Rekap Tahunan',
            'prediksi-sarima' => 'Hasil Prediksi SARIMA',
        ];
    }

    private function getDaftarKecamatan(): array
    {
        return ProduksiMangga::query()
            ->pluck('kecamatan')
            ->filter()
            ->unique()
            ->sort()
            ->values()
            ->all();
    }

    private function getDaftarTahun(): array
    {
        return ProduksiMangga::query()
            ->pluck('tahun')
            ->filter()
            ->unique()
            ->sort()
            ->values()
            ->all();
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

    private function resolvePdfPaper(array $reportData): array
    {
        $columnCount = count($reportData['headers'] ?? []);

        if ($columnCount >= 10) {
            return [
                'size' => 'a3',
                'orientation' => 'landscape',
                'font_size' => '8.5px',
                'cell_padding' => '4px',
            ];
        }

        if ($columnCount >= 7) {
            return [
                'size' => 'a4',
                'orientation' => 'landscape',
                'font_size' => '9px',
                'cell_padding' => '5px',
            ];
        }

        return [
            'size' => 'a4',
            'orientation' => 'portrait',
            'font_size' => '10px',
            'cell_padding' => '6px',
        ];
    }

    private function paginateRows(iterable $rows, Request $request, int $perPage = 25): LengthAwarePaginator
    {
        $collection = $rows instanceof Collection ? $rows->values() : collect($rows)->values();
        $currentPage = max(1, (int) $request->input('page', 1));
        $currentItems = $collection->slice(($currentPage - 1) * $perPage, $perPage)->values();

        return new LengthAwarePaginator(
            $currentItems,
            $collection->count(),
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );
    }

    private function requestPrediction(Collection $historiKecamatan, int $steps = 4, ?string $kecamatan = null): array
    {
        $serviceUrl = rtrim((string) env('APP_PYTHON'), '/');

        if ($serviceUrl === '' || $historiKecamatan->isEmpty()) {
            return [];
        }

        $payload = [
            'kecamatan' => $kecamatan,
            'steps' => $steps,
            'data' => $historiKecamatan->map(function ($item) {
                return [
                    'tahun' => (int) $item->tahun,
                    'triwulan' => $item->triwulan,
                    'produksi' => (float) $item->produksi,
                    'luas_panen' => (float) ($item->luas_panen ?? 0),
                    'curah_hujan' => (float) ($item->curah_hujan ?? 0),
                    'suhu' => (float) ($item->suhu ?? 0),
                ];
            })->values()->all(),
        ];

        try {
            $response = Http::timeout(20)
                ->acceptJson()
                ->post($serviceUrl . '/predict', $payload);

            if (! $response->successful()) {
                return [
                    'error' => 'Service Python merespons dengan status ' . $response->status() . '.',
                ];
            }

            return $response->json() ?? [];
        } catch (\Throwable) {
            return [
                'error' => 'Service Python belum aktif atau tidak dapat dihubungi.',
            ];
        }
    }
}
