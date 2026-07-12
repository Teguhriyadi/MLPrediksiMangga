@extends('master.app')

@push('title', 'Prediksi SARIMA')

@push('css')
    <style>
        .dashboard-hero-card {
            position: relative;
            overflow: hidden;
            border: none;
            background: linear-gradient(135deg, #0f172a 0%, #1d4ed8 55%, #38bdf8 100%);
            color: #fff;
        }

        .dashboard-hero-card::after {
            content: '';
            position: absolute;
            top: -40px;
            right: -30px;
            width: 180px;
            height: 180px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.08);
        }

        .dashboard-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.45rem 0.8rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.14);
            font-size: 0.8rem;
            font-weight: 600;
        }

        .dashboard-hero-title {
            font-size: 1.75rem;
            font-weight: 700;
            margin: 0.9rem 0 0.6rem;
            line-height: 1.25;
        }

        .dashboard-hero-text {
            max-width: 760px;
            color: rgba(255, 255, 255, 0.86);
            margin-bottom: 0;
        }

        .dashboard-stat-card {
            height: 100%;
            border: none;
            background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
        }

        .dashboard-stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            margin-bottom: 1rem;
        }

        .dashboard-stat-icon.primary {
            background: rgba(37, 99, 235, 0.12);
            color: #2563eb;
        }

        .dashboard-stat-icon.success {
            background: rgba(22, 163, 74, 0.12);
            color: #16a34a;
        }

        .dashboard-stat-icon.warning {
            background: rgba(245, 158, 11, 0.14);
            color: #d97706;
        }

        .dashboard-stat-label {
            color: #64748b;
            font-size: 0.82rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-bottom: 0.45rem;
        }

        .dashboard-stat-value {
            color: #0f172a;
            font-size: 1.55rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 0.35rem;
        }

        .dashboard-stat-caption {
            color: #64748b;
            font-size: 0.88rem;
            margin-bottom: 0;
        }

        .dashboard-filter-card {
            border: none;
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
        }

        .dashboard-filter-title {
            font-size: 1rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0.25rem;
        }

        .dashboard-filter-subtitle {
            color: #64748b;
            font-size: 0.9rem;
            margin-bottom: 0;
        }

        .dashboard-filter-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-top: 1rem;
        }

        .dashboard-filter-meta .meta-item {
            padding: 0.7rem 0.85rem;
            border-radius: 14px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            min-width: 150px;
        }

        .dashboard-filter-meta .meta-label {
            display: block;
            color: #64748b;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 0.2rem;
        }

        .dashboard-filter-meta .meta-value {
            color: #0f172a;
            font-size: 0.95rem;
            font-weight: 700;
        }

        .dashboard-select {
            min-height: 50px;
            border-radius: 14px;
            border-color: #dbe4f0;
            box-shadow: none;
        }

        .dashboard-btn {
            min-height: 50px;
            border-radius: 14px;
            font-weight: 600;
        }

        .dashboard-analysis-card {
            border: none;
        }

        .dashboard-analysis-header {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 0.9rem;
            margin-bottom: 1rem;
        }

        .dashboard-analysis-title {
            margin-bottom: 0.3rem;
            font-size: 1.05rem;
            font-weight: 700;
            color: #0f172a;
        }

        .dashboard-analysis-subtitle {
            color: #64748b;
            font-size: 0.9rem;
            margin-bottom: 0;
        }

        .dashboard-predict-btn {
            border-radius: 14px;
            min-height: 48px;
            padding: 0.75rem 1.1rem;
            font-weight: 600;
        }

        .prediksi-card {
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 1.5rem;
            background: #fff;
        }

        .prediksi-item {
            padding: 1rem;
            border-radius: 12px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            margin-bottom: 1rem;
        }

        .prediksi-item:last-child {
            margin-bottom: 0;
        }

        @media (max-width: 767.98px) {
            .dashboard-hero-title {
                font-size: 1.35rem;
            }

            .dashboard-stat-value {
                font-size: 1.3rem;
            }

            .dashboard-filter-meta .meta-item {
                width: 100%;
            }

            .dashboard-analysis-header {
                flex-direction: column;
                align-items: stretch;
            }
        }
    </style>
@endpush

@push('modules')

    @if (session('success'))
        <div class="alert alert-success">
            <strong>Berhasil,</strong> {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger">
            <strong>Gagal,</strong> {{ session('error') }}
        </div>
    @endif

    <div class="card dashboard-hero-card mt-3">
        <div class="card-body p-4 p-lg-5">
            <span class="dashboard-chip">
                <i class="fas fa-chart-line"></i>
                Metode Peramalan SARIMA
            </span>
            <h4 class="dashboard-hero-title">Halaman Prediksi Produktivitas Mangga</h4>
            <p class="dashboard-hero-text">
                Halaman ini khusus untuk menampilkan prediksi SARIMA dengan komponen terpisah. Anda dapat melihat prediksi
                untuk setiap triwulan berikutnya secara detail.
            </p>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-lg-4 mb-3">
            <div class="card dashboard-stat-card">
                <div class="card-body">
                    <div class="dashboard-stat-icon primary">
                        <i class="fas fa-database"></i>
                    </div>
                    <div class="dashboard-stat-label">Dataset Aktif</div>
                    <div class="dashboard-stat-value">{{ number_format($totalRecord, 0, ',', '.') }} Record</div>
                    <p class="dashboard-stat-caption">Total histori produksi yang digunakan untuk analisis dan pemodelan.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-3">
            <div class="card dashboard-stat-card">
                <div class="card-body">
                    <div class="dashboard-stat-icon success">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="dashboard-stat-label">Periode Dataset</div>
                    <div class="dashboard-stat-value">{{ $periodeMin ?? '-' }} - {{ $periodeMax ?? '-' }}</div>
                    <p class="dashboard-stat-caption">Rentang tahun histori produksi mangga yang tersedia di sistem.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-3">
            <div class="card dashboard-stat-card">
                <div class="card-body">
                    <div class="dashboard-stat-icon warning">
                        <i class="fas fa-map-marked-alt"></i>
                    </div>
                    <div class="dashboard-stat-label">Mode Analisis</div>
                    <div class="dashboard-stat-value">{{ $selectedKecamatan ?: 'Semua Kecamatan' }}</div>
                    <p class="dashboard-stat-caption">
                        {{ $isAgregatKabupaten ? 'Menampilkan akumulasi kabupaten per triwulan.' : 'Menampilkan seri khusus kecamatan terpilih.' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="card dashboard-filter-card mt-1">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-lg-5 mb-3 mb-lg-0">
                    <h5 class="dashboard-filter-title">Filter Kecamatan</h5>
                    <p class="dashboard-filter-subtitle">
                        Pilih wilayah analisis untuk menyesuaikan data dan hasil prediksi.
                    </p>
                </div>
                <div class="col-lg-7">
                    <form action="{{ route('prediksi.index') }}" method="GET">
                        <div class="form-row align-items-end">
                            <div class="form-group col-md-8 mb-2">
                                <label for="kecamatan" class="font-weight-semibold">Pilih Kecamatan</label>
                                <select name="kecamatan" id="kecamatan" class="form-control dashboard-select" {{ Auth::user()->role === \App\Models\User::ROLE_UPTD ? 'disabled' : '' }}>
                                    <option value="">Semua Kecamatan</option>
                                    @foreach ($opsiKecamatan as $kecamatan)
                                        <option value="{{ $kecamatan }}" {{ $selectedKecamatan === $kecamatan ? 'selected' : '' }}>
                                            {{ $kecamatan }}
                                        </option>
                                    @endforeach
                                </select>
                                @if (Auth::user()->role === \App\Models\User::ROLE_UPTD)
                                    <input type="hidden" name="kecamatan" value="{{ $selectedKecamatan }}">
                                @endif
                            </div>
                            @if (Auth::user()->role !== \App\Models\User::ROLE_UPTD)
                                <div class="form-group col-md-4 mb-2">
                                    <button type="submit" class="btn btn-primary btn-block dashboard-btn">
                                        <i class="fas fa-filter me-1"></i> Terapkan
                                    </button>
                                </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <div class="dashboard-filter-meta">
                <div class="meta-item">
                    <span class="meta-label">Kecamatan Aktif</span>
                    <span class="meta-value">{{ $selectedKecamatan ?: 'Seluruh Wilayah' }}</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Mode Grafik</span>
                    <span class="meta-value">{{ $isAgregatKabupaten ? 'Agregat Kabupaten' : 'Spesifik Kecamatan' }}</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Jumlah Opsi</span>
                    <span class="meta-value">{{ count($opsiKecamatan) }} Kecamatan</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mt-3 dashboard-analysis-card">
        <div class="card-body">
            @php
                $lastActual = $produksi->last()->produksi ?? 0;
                $result = session('result') ?? [];
                $predictionSummary = session('prediction_summary') ?? [];
            @endphp

            <div class="dashboard-analysis-header">
                <div>
                    <h5 class="dashboard-analysis-title">Analisis Prediksi Produksi Mangga</h5>
                    <p class="dashboard-analysis-subtitle">
                        Jalankan prediksi berdasarkan histori <b>{{ $selectedKecamatan ?: 'seluruh kecamatan' }}</b>.
                    </p>
                </div>

                <form action="{{ url('/pages/machine') }}" method="POST" class="mb-0">
                    @csrf
                    <input type="hidden" name="kecamatan" value="{{ $selectedKecamatan }}">
                    <button class="btn btn-success dashboard-predict-btn">
                        <i class="fas fa-play-circle me-1"></i>
                        Jalankan Prediksi
                    </button>
                </form>
            </div>

            @if ($produksi->isEmpty())
                <div class="alert alert-warning">
                    Data untuk kecamatan yang dipilih belum tersedia. Silakan pilih kecamatan lain atau tambahkan data produksi terlebih dahulu.
                </div>
            @endif

            @if (session('result'))
                <div class="alert alert-success mt-3">
                    <h5 class="mb-3">Hasil Prediksi SARIMA (4 Triwulan Berikutnya)</h5>
                    <div class="row">
                        @foreach ($result as $periode => $nilai)
                            <div class="col-md-6 col-lg-3 mb-3">
                                <div class="prediksi-item">
                                    <div class="text-muted small mb-1">
                                        <i class="fas fa-calendar"></i> {{ $periode }}
                                    </div>
                                    <div class="h4 mb-0 font-weight-bold">
                                        {{ number_format($nilai, 2, ',', '.') }} Ton
                                    </div>
                                    @if ($lastActual > 0)
                                        @php
                                            $growth = (($nilai - $lastActual) / $lastActual) * 100;
                                        @endphp
                                        <div class="small mt-1 {{ $growth > 0 ? 'text-success' : 'text-danger' }}">
                                            <i class="fas fa-{{ $growth > 0 ? 'arrow-up' : 'arrow-down' }}"></i>
                                            {{ number_format($growth, 2) }}% dari terakhir
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if (!empty($predictionSummary))
                        <hr>
                        <p class="mb-0">
                            <strong>Trend Model:</strong> {{ $predictionSummary['trend'] ?? '-' }} |
                            <strong>Rata-rata Prediksi:</strong> {{ number_format((float) ($predictionSummary['forecast_average'] ?? 0), 2) }} Ton
                        </p>
                    @endif
                </div>
            @endif

            {{-- 🔥 CHART --}}
            <div class="mb-3 text-muted">
                Grafik menampilkan histori produksi dan prediksi untuk <b>{{ $selectedKecamatan ?: 'seluruh kecamatan' }}</b>.
            </div>

            <canvas id="chartProduksi" height="120"></canvas>

        </div>
    </div>

    {{-- CHART.JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        let produksiData = @json($produksi);
        let prediksi = @json(session('result') ?? null);

        let labels = [];
        let dataAktual = [];
        let dataPrediksi = [];

        // 🔥 DATA AKTUAL
        produksiData.forEach(item => {
            labels.push(item.tahun + ' ' + item.triwulan);
            dataAktual.push(item.produksi);
        });

        // 🔥 DATA PREDIKSI
        if (prediksi) {
            let prediksiLabels = Object.keys(prediksi);
            let prediksiValues = Object.values(prediksi);

            prediksiLabels.forEach(label => {
                labels.push(label);
            });

            dataPrediksi = [
                ...Array(dataAktual.length).fill(null),
                ...prediksiValues
            ];
        }

        const ctx = document.getElementById('chartProduksi');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                        label: 'Data Aktual Produksi',
                        data: dataAktual,
                        borderWidth: 2,
                        tension: 0.3,
                        borderColor: '#2563eb',
                        backgroundColor: 'rgba(37, 99, 235, 0.1)'
                    },
                    {
                        label: 'Hasil Prediksi',
                        data: dataPrediksi,
                        borderDash: [5, 5],
                        borderWidth: 2,
                        tension: 0.3,
                        borderColor: '#16a34a',
                        backgroundColor: 'rgba(22, 163, 74, 0.1)'
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Produksi (Ton)'
                        }
                    }
                }
            }
        });
    </script>

@endpush
