<?php

namespace App\Http\Controllers;

use App\Models\ProduksiMangga;
use Illuminate\Support\Facades\Http;

class PredictController extends Controller
{
    public function store()
    {
        $data = ProduksiMangga::select('tahun', 'triwulan', 'produksi')->get();

        $response = Http::post(env('APP_PYTHON') . "/predict", [
            'data' => $data,
            'steps' => 4
        ]);

        $result = $response->json();

        return redirect('/pages/dashboard')->with('result', $result['data'] ?? []);
    }
}
