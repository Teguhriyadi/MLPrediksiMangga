<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanExport implements FromView
{
    public function __construct(
        private readonly array $hasilLaporan
    ) {
    }

    public function view(): View
    {
        return view('pages.laporan.excel', [
            'hasilLaporan' => $this->hasilLaporan,
        ]);
    }
}
