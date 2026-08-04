<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\ProduksiMangga;
use App\Models\VarietasMangga;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ProduksiManggaController extends Controller
{
    public function index()
    {
        try {
            $produksi = ProduksiMangga::query()
                ->with(['varietasMangga', 'kecamatanData'])
                ->orderByDesc("tahun")
                ->orderByRaw($this->quarterOrderSql("DESC"))
                ->get();

            return view("pages.produksi-mangga.index", [
                "produksi" => $produksi,
                "ringkasan" => $this->buildRingkasan($produksi),
            ]);
        } catch (\Throwable $e) {
            return back()->with("error", $e->getMessage());
        }
    }

    public function create()
    {
        return view("pages.produksi-mangga.create", [
            "daftarKecamatan" => $this->getDaftarKecamatan(),
            "daftarTriwulan" => $this->getDaftarTriwulan(),
            "daftarVarietas" => $this->getDaftarVarietas(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "kecamatan_id" => ["required", "exists:kecamatans,id"],
            "tahun" => ["required", "integer", "min:2018", "max:2100"],
            "triwulan" => ["required", "in:Q1,Q2,Q3,Q4"],
            "varietas_mangga_id" => ["required", "exists:varietas_mangga,id"],
            "luas_tanam" => ["required", "numeric", "min:0.01"],
            "luas_panen" => ["required", "numeric", "min:0.01", "lte:luas_tanam"],
            "jumlah_pohon" => ["required", "numeric", "min:1"],
            "umur_tanaman" => ["required", "integer", "min:1", "max:50"],
            "produksi" => ["required", "numeric", "min:0.01"],
            "catatan" => ["nullable", "string", "max:500"],
        ], [
            "luas_panen.lte" => "Luas panen tidak boleh melebihi luas tanam.",
        ]);

        $isDuplicate = ProduksiMangga::query()
            ->where("kecamatan_id", $validated["kecamatan_id"])
            ->where("tahun", $validated["tahun"])
            ->where("triwulan", $validated["triwulan"])
            ->exists();

        if ($isDuplicate) {
            return back()
                ->withInput()
                ->with("error", "Data untuk kecamatan, tahun, dan triwulan tersebut sudah tersedia.");
        }

        try {
            DB::beginTransaction();

            $record = ProduksiMangga::create($validated);

            DB::commit();

            return redirect("/pages/produksi-mangga/" . $record->id)
                ->with("success", "Data produksi mangga berhasil ditambahkan.");
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with("error", $e->getMessage());
        }
    }

    public function show(string $id)
    {
        $detail = ProduksiMangga::query()
            ->with(['varietasMangga', 'kecamatanData'])
            ->findOrFail($id);

        $historiKecamatan = ProduksiMangga::query()
            ->with(['varietasMangga', 'kecamatanData'])
            ->where("kecamatan_id", $detail->kecamatan_id)
            ->orderBy("tahun")
            ->orderByRaw($this->quarterOrderSql())
            ->get();

        $prediksi = $this->requestPrediction($historiKecamatan, 4, $detail->kecamatan);

        return view("pages.produksi-mangga.show", [
            "detail" => $detail,
            "historiKecamatan" => $historiKecamatan,
            "indikator" => $this->buildIndikator($detail),
            "prediksi" => $prediksi,
        ]);
    }

    public function edit(string $id)
    {
        $data["edit"] = ProduksiMangga::query()->with('kecamatanData')->where("id", $id)->firstOrFail();
        $data["daftarKecamatan"] = $this->getDaftarKecamatan();
        $data["daftarTriwulan"] = $this->getDaftarTriwulan();
        $data["daftarVarietas"] = $this->getDaftarVarietas();

        return view("pages.produksi-mangga.edit", $data);
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            "kecamatan_id" => ["required", "exists:kecamatans,id"],
            "tahun" => ["required", "integer", "min:2018", "max:2100"],
            "triwulan" => ["required", "in:Q1,Q2,Q3,Q4"],
            "varietas_mangga_id" => ["required", "exists:varietas_mangga,id"],
            "luas_tanam" => ["required", "numeric", "min:0.01"],
            "luas_panen" => ["required", "numeric", "min:0.01", "lte:luas_tanam"],
            "jumlah_pohon" => ["required", "numeric", "min:1"],
            "umur_tanaman" => ["required", "integer", "min:1", "max:50"],
            "produksi" => ["required", "numeric", "min:0.01"],
            "catatan" => ["nullable", "string", "max:500"],
        ], [
            "luas_panen.lte" => "Luas panen tidak boleh melebihi luas tanam.",
        ]);

        $isDuplicate = ProduksiMangga::query()
            ->where("kecamatan_id", $validated["kecamatan_id"])
            ->where("tahun", $validated["tahun"])
            ->where("triwulan", $validated["triwulan"])
            ->where("id", "!=", $id)
            ->exists();

        if ($isDuplicate) {
            return back()
                ->withInput()
                ->with("error", "Data untuk kecamatan, tahun, dan triwulan tersebut sudah tersedia.");
        }

        try {
            DB::beginTransaction();

            ProduksiMangga::query()->where("id", $id)->update($validated);

            DB::commit();

            return back()->with("success", "Data Berhasil di Simpan");
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->with("error", $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();

            ProduksiMangga::query()->where("id", $id)->delete();

            DB::commit();

            return back()->with("success", "Data Berhasil di Hapus");
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->with("error", $e->getMessage());
        }
    }

    private function requestPrediction(Collection $historiKecamatan, int $steps = 4, ?string $kecamatan = null): array
    {
        $serviceUrl = rtrim((string) config('app.env_python'), "/");

        if ($serviceUrl === "" || $historiKecamatan->isEmpty()) {
            return [];
        }

        $payload = [
            "kecamatan" => $kecamatan,
            "steps" => $steps,
            "data" => $historiKecamatan->map(function ($item) {
                // Normalisasi agar nilainya selalu 'Q1', 'Q2', 'Q3', atau 'Q4'
                $triwulanRaw = strtoupper(trim((string) $item->triwulan));
                if (!str_starts_with($triwulanRaw, 'Q')) {
                    $triwulanRaw = 'Q' . preg_replace('/\D/', '', $triwulanRaw);
                }

                return [
                    "tahun" => (int) $item->tahun,
                    "triwulan" => $triwulanRaw,
                    "produksi" => (float) $item->produksi,
                ];
            })->values()->all(),
        ];

        try {
            $response = Http::timeout(20)
                ->acceptJson()
                ->post($serviceUrl . "/predict", $payload);

            if (! $response->successful()) {
                return [
                    "error" => "Service Python merespons status " . $response->status() . ": " . $response->body(),
                ];
            }

            return $response->json() ?? [];
        } catch (\Throwable $e) {
            return [
                "error" => "Service Python gagal dihubungi: " . $e->getMessage(),
            ];
        }
    }

    private function buildIndikator(ProduksiMangga $detail): array
    {
        $luasTanam = (float) ($detail->luas_tanam ?? 0);
        $luasPanen = (float) ($detail->luas_panen ?? 0);
        $jumlahPohon = (float) ($detail->jumlah_pohon ?? 0);
        $produksi = (float) ($detail->produksi ?? 0);

        $produktivitasLahan = $luasPanen > 0 ? $produksi / $luasPanen : 0;
        $rasioPanen = $luasTanam > 0 ? ($luasPanen / $luasTanam) * 100 : 0;
        $produksiPerPohon = $jumlahPohon > 0 ? $produksi / $jumlahPohon : 0;

        return [
            "produktivitas_lahan" => round($produktivitasLahan, 2),
            "rasio_panen" => round($rasioPanen, 2),
            "produksi_per_pohon" => round($produksiPerPohon, 4),
            "status_produktivitas" => $produktivitasLahan >= 0.12 ? "Tinggi" : ($produktivitasLahan >= 0.08 ? "Sedang" : "Rendah"),
        ];
    }

    private function buildRingkasan(Collection $produksi): array
    {
        return [
            "total_data" => $produksi->count(),
            "total_produksi" => round((float) $produksi->sum("produksi"), 2),
            "rata_produksi" => round((float) $produksi->avg("produksi"), 2),
            "kecamatan_aktif" => $produksi->filter(fn($item) => filled($item->kecamatan_id))->unique("kecamatan_id")->count(),
        ];
    }

    private function getDaftarKecamatan()
    {
        return Kecamatan::query()
            ->where('is_active', true)
            ->orderBy('nama')
            ->get(['id', 'nama']);
    }

    private function getDaftarTriwulan(): array
    {
        return [
            "Q1" => "Q1 (Jan - Mar)",
            "Q2" => "Q2 (Apr - Jun)",
            "Q3" => "Q3 (Jul - Sep)",
            "Q4" => "Q4 (Okt - Des)",
        ];
    }

    private function getDaftarVarietas(): array
    {
        return VarietasMangga::query()
            ->orderBy('nama_varietas', 'ASC')
            ->get(['id', 'kode_varietas', 'nama_varietas'])
            ->map(function (VarietasMangga $item) {
                return [
                    'id' => $item->id,
                    'kode_varietas' => $item->kode_varietas,
                    'nama_varietas' => $item->nama_varietas,
                ];
            })
            ->all();
    }

    private function quarterOrderSql(string $direction = "ASC"): string
    {
        $direction = strtoupper($direction) === "DESC" ? "DESC" : "ASC";

        return "CASE triwulan
            WHEN 'Q1' THEN 1
            WHEN 'Q2' THEN 2
            WHEN 'Q3' THEN 3
            WHEN 'Q4' THEN 4
            ELSE 5
        END {$direction}";
    }
}
