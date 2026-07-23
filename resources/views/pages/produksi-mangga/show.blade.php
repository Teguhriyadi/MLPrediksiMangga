@extends('master.app')

@push('title', 'Detail Produktivitas Mangga')

@push('modules')

    @php
        $canManageProduksi = Auth::user()->hasAnyRole([\App\Models\User::ROLE_ADMIN, \App\Models\User::ROLE_OPERATOR]);
        $forecastList = $prediksi['forecasts'] ?? [];
        $summaryPrediksi = $prediksi['summary'] ?? [];
        $evaluation = $prediksi['evaluation'] ?? [];
        $insight = $prediksi['insight'] ?? [];
        $chartLabels = $historiKecamatan->map(fn ($item) => $item->tahun . ' ' . $item->triwulan)->values()->all();
        $chartActual = $historiKecamatan->pluck('produksi')->map(fn ($value) => (float) $value)->values()->all();

        $futureLabels = collect($forecastList)->pluck('periode')->values()->all();
        $forecastValues = collect($forecastList)->pluck('prediksi')->map(fn ($value) => (float) $value)->values()->all();

        $combinedLabels = array_merge($chartLabels, $futureLabels);
        $actualSeries = array_merge($chartActual, array_fill(0, count($futureLabels), null));
        $forecastSeries = array_merge(array_fill(0, count($chartActual), null), $forecastValues);
    @endphp

    @if (session('success'))
        <div class="alert alert-success">
            <strong>Berhasil,</strong> {{ session('success') }}
        </div>
    @endif

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="mb-1">{{ $detail->kecamatan ?? 'Kecamatan belum diisi' }} - {{ $detail->tahun }} {{ $detail->triwulan }}</h4>
            <p class="mb-0 text-muted">Detail data produksi, indikator produktivitas, dan hasil integrasi prediksi SARIMA.</p>
        </div>
        <div>
            <a href="{{ url('/pages/produksi-mangga') }}" class="btn btn-secondary btn-sm">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
            @if ($canManageProduksi)
                <a href="{{ url('/pages/produksi-mangga/create') }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-plus"></i> Tambah Data
                </a>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Produksi Aktual</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format((float) $detail->produksi, 2, ',', '.') }} ton</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Produktivitas Lahan</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($indikator['produktivitas_lahan'], 2, ',', '.') }} ton/ha</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Rasio Panen</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($indikator['rasio_panen'], 2, ',', '.') }}%</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Produksi per Pohon</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($indikator['produksi_per_pohon'], 4, ',', '.') }} ton</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Data Observasi</h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <th width="40%">Kecamatan</th>
                            <td>{{ $detail->kecamatan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Varietas</th>
                            <td>{{ $detail->varietasMangga->nama_varietas ?? ($detail->varietas ?? '-') }}</td>
                        </tr>
                        <tr>
                            <th>Tahun / Triwulan</th>
                            <td>{{ $detail->tahun }} / {{ $detail->triwulan }}</td>
                        </tr>
                        <tr>
                            <th>Luas Tanam</th>
                            <td>{{ number_format((float) $detail->luas_tanam, 2, ',', '.') }} ha</td>
                        </tr>
                        <tr>
                            <th>Luas Panen</th>
                            <td>{{ number_format((float) $detail->luas_panen, 2, ',', '.') }} ha</td>
                        </tr>
                        <tr>
                            <th>Jumlah Pohon</th>
                            <td>{{ number_format((float) ($detail->jumlah_pohon ?? 0), 0, ',', '.') }} pohon</td>
                        </tr>
                        <tr>
                            <th>Umur Tanaman</th>
                            <td>{{ $detail->umur_tanaman ?? '-' }} tahun</td>
                        </tr>
                        <tr>
                            <th>Status Produktivitas</th>
                            <td>
                                <span class="badge badge-{{ $indikator['status_produktivitas'] === 'Tinggi' ? 'success' : ($indikator['status_produktivitas'] === 'Sedang' ? 'warning' : 'danger') }}">
                                    {{ $indikator['status_produktivitas'] }}
                                </span>
                            </td>
                        </tr>
                    </table>
                    <div class="mt-3">
                        <h6 class="font-weight-bold">Catatan Lapangan</h6>
                        <p class="mb-0 text-muted">{{ $detail->catatan ?: 'Tidak ada catatan tambahan.' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Ringkasan Prediksi SARIMA</h6>
                </div>
                <div class="card-body">
                    @if (!empty($prediksi['error']))
                        <div class="alert alert-warning mb-3">
                            {{ $prediksi['error'] }}
                        </div>
                    @endif

                    @if (!empty($summaryPrediksi))
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="border rounded p-3 h-100">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-2">Rata-rata Forecast</div>
                                    <div class="h5 mb-1">{{ number_format((float) ($summaryPrediksi['forecast_average'] ?? 0), 2, ',', '.') }} ton</div>
                                    <small class="text-muted">Rata-rata prediksi {{ count($forecastList) }} periode mendatang.</small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="border rounded p-3 h-100">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-2">Arah Tren</div>
                                    <div class="h5 mb-1 text-capitalize">{{ $summaryPrediksi['trend'] ?? '-' }}</div>
                                    <small class="text-muted">Perubahan terhadap data aktual terakhir: {{ number_format((float) ($summaryPrediksi['growth_percent'] ?? 0), 2, ',', '.') }}%.</small>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-light border mb-3">
                            Ringkasan prediksi akan tampil setelah data histori mencukupi dan service Python aktif.
                        </div>
                    @endif

                    @if (!empty($evaluation))
                        <div class="alert alert-light border mb-3">
                            <strong>Evaluasi Model:</strong>
                            MAE {{ number_format((float) ($evaluation['mae'] ?? 0), 2, ',', '.') }},
                            MAPE {{ number_format((float) ($evaluation['mape'] ?? 0), 2, ',', '.') }}%.
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="border rounded p-3 h-100">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-2">Jumlah Data Historis</div>
                                <div class="h5 mb-1">{{ $historiKecamatan->count() }} periode</div>
                                <small class="text-muted">Data histori per kecamatan yang digunakan untuk analisis dan prediksi.</small>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="border rounded p-3 h-100">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-2">Periode Forecast</div>
                                <div class="h5 mb-1">{{ count($forecastList) }} periode</div>
                                <small class="text-muted">Jumlah periode yang diproyeksikan oleh model SARIMA untuk tahap berikutnya.</small>
                            </div>
                        </div>
                    </div>

                    <div class="border rounded p-3 bg-light">
                        <div class="font-weight-bold text-dark mb-2">Interpretasi Singkat</div>
                        <p class="mb-0 text-muted">
                            Bagian ini merangkum arah tren produksi, evaluasi akurasi model, dan kesiapan histori produksi triwulanan
                            yang menjadi input utama metode SARIMA.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Histori Kecamatan {{ $detail->kecamatan ?? '-' }}</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Histori ini menjadi dasar pembentukan pola musiman untuk analisis produktivitas mangga per triwulan.</small>
                    </div>
                    <div class="table-responsive" style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">Periode</th>
                                    <th class="text-center">Produksi</th>
                                    <th class="text-center">Luas Panen</th>
                                    <th class="text-center">Jumlah Pohon</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($historiKecamatan as $item)
                                    <tr>
                                        <td class="text-center">{{ $item->tahun }} {{ $item->triwulan }}</td>
                                        <td class="text-center">{{ number_format((float) $item->produksi, 2, ',', '.') }}</td>
                                        <td class="text-center">{{ number_format((float) $item->luas_panen, 2, ',', '.') }}</td>
                                        <td class="text-center">{{ number_format((float) ($item->jumlah_pohon ?? 0), 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Belum ada histori kecamatan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Insight Sistem</h6>
                </div>
                <div class="card-body">
                    @if (!empty($insight))
                        <ul class="pl-3 mb-0">
                            @foreach ($insight as $item)
                                <li class="mb-2">{{ $item }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="mb-0 text-muted">Insight akan muncul setelah service Python aktif dan histori data mencukupi.</p>
                    @endif
                </div>
            </div>

            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Forecast Mendatang</h6>
                </div>
                <div class="card-body">
                    @if (!empty($forecastList))
                        <div class="mb-3">
                            <small class="text-muted">Forecast berikut menunjukkan proyeksi produksi beberapa periode mendatang berdasarkan pola historis kecamatan yang sama.</small>
                        </div>
                        <div class="table-responsive" style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
                            <table class="table table-sm table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-center">Periode</th>
                                        <th class="text-center">Prediksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($forecastList as $item)
                                        <tr>
                                            <td class="text-center">{{ $item['periode'] ?? '-' }}</td>
                                            <td class="text-center">{{ number_format((float) ($item['prediksi'] ?? 0), 2, ',', '.') }} ton</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="mb-0 text-muted">Belum ada hasil forecast yang dapat ditampilkan.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Grafik Tren Produksi dan Prediksi SARIMA</h6>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <small class="text-muted">
                    Grafik ditaruh di bagian paling bawah dengan tinggi tetap agar tampilan tidak tertarik saat jumlah histori atau data forecast semakin banyak.
                </small>
            </div>
            <div style="position: relative; height: 380px;">
                <canvas id="chartPrediksiKecamatan"></canvas>
            </div>
        </div>
    </div>

@endpush

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const labelsPrediksi = @json($combinedLabels);
        const dataAktual = @json($actualSeries);
        const dataForecast = @json($forecastSeries);

        const ctxPrediksi = document.getElementById('chartPrediksiKecamatan');

        if (ctxPrediksi) {
            new Chart(ctxPrediksi, {
                type: 'line',
                data: {
                    labels: labelsPrediksi,
                    datasets: [{
                            label: 'Produksi Aktual',
                            data: dataAktual,
                            borderColor: '#4e73df',
                            backgroundColor: 'rgba(78, 115, 223, 0.1)',
                            borderWidth: 2,
                            tension: 0.3
                        },
                        {
                            label: 'Prediksi SARIMA',
                            data: dataForecast,
                            borderColor: '#1cc88a',
                            backgroundColor: 'rgba(28, 200, 138, 0.1)',
                            borderDash: [6, 6],
                            borderWidth: 2,
                            tension: 0.3
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    </script>
@endpush
