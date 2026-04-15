<?php

namespace App\Http\Controllers;

use App\Models\ProduksiMangga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProduksiManggaController extends Controller
{
    public function index()
    {
        try {
            DB::beginTransaction();

            $data["produksi"] = ProduksiMangga::orderBy("created_at", "DESC")->get();
            DB::commit();

            return view("pages.produksi-mangga.index", $data);
        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with("error", $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            ProduksiMangga::create([
                "tahun" => $request->tahun,
                "triwulan" => $request->triwulan,
                "luas_tanam" => $request->luas_tanam,
                "luas_panen" => $request->luas_panen,
                "curah_hujan" => $request->curah_hujan,
                "suhu" => $request->suhu,
                "produksi" => $request->produksi
            ]);

            DB::commit();

            return back()->with("success", "Data Berhasil di Tambahkan");

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with("error", $e->getMessage());
        }
    }

    public function edit($id)
    {
        $data["edit"] = ProduksiMangga::where("id", $id)->first();

        return view("pages.produksi-mangga.edit", $data);
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            ProduksiMangga::where("id", $id)->update([
                "tahun" => $request->tahun,
                "triwulan" => $request->triwulan,
                "luas_tanam" => $request->luas_tanam,
                "luas_panen" => $request->luas_panen,
                "curah_hujan" => $request->curah_hujan,
                "suhu" => $request->suhu,
                "produksi" => $request->produksi
            ]);

            DB::commit();

            return back()->with("success", "Data Berhasil di Simpan");

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with("error", $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            ProduksiMangga::where("id", $id)->delete();

            DB::commit();

            return back()->with("success", "Data Berhasil di Hapus");

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with("error", $e->getMessage());
        }
    }
}
