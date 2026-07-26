<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\ProduksiMangga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AppController extends Controller
{
    public function dashboard(Request $request)
    {
        $selectedKecamatan = $request->input('kecamatan');
        $opsiKecamatan = Kecamatan::where('is_active', true)->orderBy('nama')->get(['id', 'nama']);

        // Jika user adalah UPTD, gunakan kecamatan dari user dan tidak bisa diubah
        if (Auth::user()->role === \App\Models\User::ROLE_UPTD && Auth::user()->kecamatan_id) {
            $selectedKecamatan = (string) Auth::user()->kecamatan_id;
        }

        $selectedKecamatanId = filled($selectedKecamatan) ? (int) $selectedKecamatan : null;
        $data["selectedKecamatan"] = $selectedKecamatan;
        $data["selectedKecamatanLabel"] = $selectedKecamatanId
            ? optional($opsiKecamatan->firstWhere('id', $selectedKecamatanId) ?? Kecamatan::find($selectedKecamatanId))->nama
            : null;
        $data["opsiKecamatan"] = $opsiKecamatan;
        $rawProduksi = ProduksiMangga::query()
            ->when($selectedKecamatanId, fn ($query, $kecamatanId) => $query->where('kecamatan_id', $kecamatanId))
            ->orderBy('tahun', 'ASC')
            ->orderByRaw($this->quarterOrderSql())
            ->get(['tahun', 'triwulan', 'produksi']);

        $data["totalRecord"] = $rawProduksi->count();
        $data["periodeMin"] = $rawProduksi->min('tahun');
        $data["periodeMax"] = $rawProduksi->max('tahun');
        $data["isAgregatKabupaten"] = !filled($selectedKecamatan);
        $data["sarimaConfig"] = [
            'variabel_input' => 'Produksi per triwulan',
            'indeks_waktu' => 'Tahun dan triwulan',
            'periode_musiman' => 4,
            'horizon_prediksi' => 4,
        ];
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

    public function prediksi(Request $request)
    {
        $selectedKecamatan = $request->input('kecamatan');
        $opsiKecamatan = Kecamatan::where('is_active', true)->orderBy('nama')->get(['id', 'nama']);

        // Jika user adalah UPTD, gunakan kecamatan dari user dan tidak bisa diubah
        if (Auth::user()->role === \App\Models\User::ROLE_UPTD && Auth::user()->kecamatan_id) {
            $selectedKecamatan = (string) Auth::user()->kecamatan_id;
        }

        $selectedKecamatanId = filled($selectedKecamatan) ? (int) $selectedKecamatan : null;
        $data["selectedKecamatan"] = $selectedKecamatan;
        $data["selectedKecamatanLabel"] = $selectedKecamatanId
            ? optional($opsiKecamatan->firstWhere('id', $selectedKecamatanId) ?? Kecamatan::find($selectedKecamatanId))->nama
            : null;
        $data["opsiKecamatan"] = $opsiKecamatan;
        $rawProduksi = ProduksiMangga::query()
            ->when($selectedKecamatanId, fn ($query, $kecamatanId) => $query->where('kecamatan_id', $kecamatanId))
            ->orderBy('tahun', 'ASC')
            ->orderByRaw($this->quarterOrderSql())
            ->get();

        $data["totalRecord"] = $rawProduksi->count();
        $data["periodeMin"] = $rawProduksi->min('tahun');
        $data["periodeMax"] = $rawProduksi->max('tahun');
        $data["isAgregatKabupaten"] = !filled($selectedKecamatan);
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

        return view("pages.prediksi", $data);
    }

    public function logout()
    {
        Auth::logout();

        return redirect("/login")->with("success", "Anda Berhasil Logout");
    }

    public function forceResetPassword(Request $request)
    {
        $user = Auth::user();

        if (!$user || !$user->must_reset_password) {
            return redirect('/pages/dashboard');
        }

        $validated = $request->validate([
            'password_lama' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'password_lama.required' => 'Password saat ini wajib diisi.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        if (!Hash::check($validated['password_lama'], $user->password)) {
            return back()->with('error', 'Password saat ini tidak sesuai.');
        }

        $user->forceFill([
            'password' => Hash::make($validated['password']),
            'must_reset_password' => false,
        ])->save();

        return redirect('/pages/dashboard')->with('success', 'Password berhasil diperbarui. Silakan gunakan password baru saat login berikutnya.');
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
