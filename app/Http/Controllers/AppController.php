<?php

namespace App\Http\Controllers;

use App\Models\ProduksiMangga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppController extends Controller
{
    public function dashboard()
    {
        $data["produksi"] = ProduksiMangga::orderBy('tahun')
            ->orderBy('triwulan')
            ->get();

        return view("pages.dashboard", $data);
    }

    public function logout()
    {
        Auth::logout();

        return redirect("/login")->with("success", "Anda Berhasil Logout");
    }
}
