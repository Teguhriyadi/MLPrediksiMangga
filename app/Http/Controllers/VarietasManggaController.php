<?php

namespace App\Http\Controllers;

use App\Models\VarietasMangga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VarietasManggaController extends Controller
{
    public function index()
    {
        $data['varietas'] = VarietasMangga::query()
            ->withCount('produksiMangga')
            ->orderBy('nama_varietas', 'ASC')
            ->get();

        return view('pages.varietas-mangga.index', $data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_varietas' => ['required', 'string', 'max:50', 'unique:varietas_mangga,kode_varietas'],
            'nama_varietas' => ['required', 'string', 'max:100'],
            'asal_varietas' => ['nullable', 'string', 'max:150'],
            'deskripsi' => ['nullable', 'string', 'max:500'],
        ]);

        try {
            DB::beginTransaction();

            VarietasMangga::create($validated);

            DB::commit();

            return back()->with('success', 'Data varietas mangga berhasil ditambahkan.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $data['edit'] = VarietasMangga::query()->findOrFail($id);

        return view('pages.varietas-mangga.edit', $data);
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'kode_varietas' => ['required', 'string', 'max:50', 'unique:varietas_mangga,kode_varietas,' . $id],
            'nama_varietas' => ['required', 'string', 'max:100'],
            'asal_varietas' => ['nullable', 'string', 'max:150'],
            'deskripsi' => ['nullable', 'string', 'max:500'],
        ]);

        try {
            DB::beginTransaction();

            VarietasMangga::query()->where('id', $id)->update($validated);

            DB::commit();

            return back()->with('success', 'Data varietas mangga berhasil diperbarui.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();

            $varietas = VarietasMangga::query()->withCount('produksiMangga')->findOrFail($id);

            if ($varietas->produksi_mangga_count > 0) {
                DB::rollBack();

                return back()->with('error', 'Varietas tidak dapat dihapus karena masih digunakan pada data produksi.');
            }

            VarietasMangga::query()->where('id', $id)->delete();

            DB::commit();

            return back()->with('success', 'Data varietas mangga berhasil dihapus.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }
}
