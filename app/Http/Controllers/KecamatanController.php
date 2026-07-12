<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KecamatanController extends Controller
{
    public function index()
    {
        $kecamatans = Kecamatan::orderBy('nama')->get();
        return view('pages.kecamatan.index', compact('kecamatans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:kecamatans,nama',
        ]);

        try {
            DB::beginTransaction();
            Kecamatan::create([
                'nama' => $request->nama,
                'is_active' => true,
            ]);
            DB::commit();
            return back()->with('success', 'Kecamatan berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:kecamatans,nama,' . $id,
        ]);

        try {
            DB::beginTransaction();
            $kecamatan = Kecamatan::findOrFail($id);
            $kecamatan->update([
                'nama' => $request->nama,
            ]);
            DB::commit();
            return back()->with('success', 'Kecamatan berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function toggleStatus($id)
    {
        try {
            DB::beginTransaction();
            $kecamatan = Kecamatan::findOrFail($id);
            $kecamatan->update([
                'is_active' => !$kecamatan->is_active,
            ]);
            DB::commit();
            return back()->with('success', 'Status kecamatan berhasil diubah');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $kecamatan = Kecamatan::findOrFail($id);
            $kecamatan->delete();
            DB::commit();
            return back()->with('success', 'Kecamatan berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}
