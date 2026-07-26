@extends('master.app')

@push('title', 'Dashboard')

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

    @if (auth()->user() && auth()->user()->must_reset_password)
        <div style="position:fixed;inset:0;background:rgba(15,23,42,0.55);backdrop-filter:blur(6px);z-index:2000;padding:24px;display:flex;align-items:center;justify-content:center;">
            <div style="width:100%;max-width:540px;background:#ffffff;border:1px solid #e2e8f0;border-radius:24px;box-shadow:0 30px 60px rgba(15,23,42,0.22);overflow:hidden;">
                <div style="padding:22px 22px 18px;background:linear-gradient(135deg,#0f172a 0%,#1d4ed8 58%,#38bdf8 100%);color:#ffffff;">
                    <div style="display:inline-flex;align-items:center;gap:8px;padding:8px 12px;border-radius:999px;background:rgba(255,255,255,0.14);font-size:12px;font-weight:700;letter-spacing:0.04em;">
                        <i class="fas fa-shield-alt"></i>
                        KEAMANAN AKUN
                    </div>
                    <h4 style="margin:14px 0 8px;font-size:24px;font-weight:700;line-height:1.25;">
                        Ganti Password Pertama Kali
                    </h4>
                    <p style="margin:0;font-size:14px;line-height:1.8;color:rgba(255,255,255,0.88);">
                        Akun ini masih menggunakan password default. Silakan buat password baru terlebih dahulu sebelum melanjutkan ke menu lain.
                    </p>
                </div>

                <form action="{{ route('password.force-reset') }}" method="POST">
                    @csrf
                    <div style="padding:22px 22px 10px;">
                        @if ($errors->any())
                            <div class="alert alert-danger" style="border-radius:16px;">
                                <strong>Periksa kembali:</strong>
                                <ul class="mb-0 mt-2 pl-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div style="padding:14px 16px;border-radius:16px;border:1px solid #e2e8f0;background:#f8fafc;margin-bottom:18px;">
                            <div style="font-size:13px;font-weight:700;color:#1d4ed8;margin-bottom:6px;">
                                Informasi
                            </div>
                            <div style="font-size:13px;line-height:1.8;color:#475569;">
                                Setelah password berhasil diganti, permintaan ini tidak akan muncul lagi saat login berikutnya.
                            </div>
                        </div>

                        <div class="form-group">
                            <label style="font-weight:600;color:#0f172a;">Password saat ini</label>
                            <input type="password" name="password_lama" class="form-control"
                                placeholder="Masukkan password default saat ini" required
                                style="border-radius:14px;min-height:48px;">
                        </div>

                        <div class="form-group">
                            <label style="font-weight:600;color:#0f172a;">Password baru</label>
                            <input type="password" name="password" class="form-control"
                                placeholder="Minimal 8 karakter" required
                                style="border-radius:14px;min-height:48px;">
                        </div>

                        <div class="form-group mb-0">
                            <label style="font-weight:600;color:#0f172a;">Konfirmasi password baru</label>
                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="Ulangi password baru" required
                                style="border-radius:14px;min-height:48px;">
                        </div>
                    </div>

                    <div style="padding:0 22px 22px;display:flex;gap:12px;justify-content:flex-end;flex-wrap:wrap;">
                        <a href="{{ url('/pages/logout') }}" class="btn btn-outline-secondary"
                            style="border-radius:14px;min-height:46px;font-weight:600;padding:10px 18px;">
                            Logout
                        </a>
                        <button type="submit" class="btn btn-primary"
                            style="border-radius:14px;min-height:46px;font-weight:600;padding:10px 18px;">
                            Simpan Password Baru
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <div class="card dashboard-hero-card mt-3">
        <div class="card-body p-4 p-lg-5">
            <span class="dashboard-chip">
                <i class="fas fa-chart-line"></i>
                Metode Peramalan SARIMA
            </span>
            <h4 class="dashboard-hero-title">Dashboard Prediksi Produktivitas Mangga Berbasis Time Series</h4>
            <p class="dashboard-hero-text">
                Dashboard ini hanya menggunakan deret waktu <b>produksi mangga per triwulan</b> sebagai input model
                <b>SARIMA (Seasonal ARIMA)</b>. Variabel seperti curah hujan, suhu, dan faktor non-time-series tidak
                dipakai pada proses prediksi di halaman ini.
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
                    <div class="dashboard-stat-label">Observasi Time Series</div>
                    <div class="dashboard-stat-value">{{ number_format($totalRecord, 0, ',', '.') }} Titik</div>
                    <p class="dashboard-stat-caption">Jumlah titik data produksi triwulanan yang dipakai sebagai input model.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-3">
            <div class="card dashboard-stat-card">
                <div class="card-body">
                    <div class="dashboard-stat-icon success">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="dashboard-stat-label">Musiman SARIMA</div>
                    <div class="dashboard-stat-value">{{ $sarimaConfig['periode_musiman'] }} Triwulan</div>
                    <p class="dashboard-stat-caption">Satu siklus musiman mewakili 4 triwulan dalam satu tahun pengamatan.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-3">
            <div class="card dashboard-stat-card">
                <div class="card-body">
                    <div class="dashboard-stat-icon warning">
                        <i class="fas fa-map-marked-alt"></i>
                    </div>
                    <div class="dashboard-stat-label">Variabel Input</div>
                    <div class="dashboard-stat-value">{{ $sarimaConfig['variabel_input'] }}</div>
                    <p class="dashboard-stat-caption">
                        Model membaca indeks waktu {{ $sarimaConfig['indeks_waktu'] }} dan nilai produksi sebagai seri utama.
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
                        Pilih wilayah analisis untuk membentuk satu seri produksi triwulanan yang akan dihitung oleh model SARIMA.
                    </p>
                </div>
                <div class="col-lg-7">
                    <form action="{{ url('/pages/dashboard') }}" method="GET">
                        <div class="form-row align-items-end">
                            <div class="form-group col-md-8 mb-2">
                                <label for="kecamatan" class="font-weight-semibold">Pilih Kecamatan</label>
                                <select name="kecamatan" id="kecamatan" class="form-control dashboard-select" {{ Auth::user()->role === \App\Models\User::ROLE_UPTD ? 'disabled' : '' }}>
                                    <option value="">Semua Kecamatan</option>
                                    @foreach ($opsiKecamatan as $kecamatan)
                                        <option value="{{ $kecamatan->id }}" {{ (string) $selectedKecamatan === (string) $kecamatan->id ? 'selected' : '' }}>
                                            {{ $kecamatan->nama }}
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
                                        <i class="fas fa-filter mr-1"></i> Terapkan
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
                    <span class="meta-value">{{ $selectedKecamatanLabel ?: 'Seluruh Wilayah' }}</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Rentang Tahun</span>
                    <span class="meta-value">{{ $periodeMin ?? '-' }} - {{ $periodeMax ?? '-' }}</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Horizon Prediksi</span>
                    <span class="meta-value">{{ $sarimaConfig['horizon_prediksi'] }} Triwulan</span>
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
                $prediksi = array_values($result)[0] ?? 0;
                $labelKecamatanAktif = $selectedKecamatanLabel ?: 'seluruh kecamatan';

                $growth = $lastActual > 0 ? (($prediksi - $lastActual) / $lastActual) * 100 : 0;
            @endphp

            <div class="dashboard-analysis-header">
                <div>
                    <h5 class="dashboard-analysis-title">Analisis Prediksi Produksi Mangga</h5>
                    <p class="dashboard-analysis-subtitle">
                        Jalankan prediksi berdasarkan histori produksi <b>{{ $labelKecamatanAktif }}</b>
                        untuk memproyeksikan {{ $sarimaConfig['horizon_prediksi'] }} triwulan berikutnya.
                    </p>
                </div>

                <form action="{{ url('/pages/machine') }}" method="POST" class="mb-0">
                    @csrf
                    <input type="hidden" name="kecamatan" value="{{ $selectedKecamatan }}">
                    <button class="btn btn-success dashboard-predict-btn">
                        <i class="fas fa-play-circle mr-1"></i>
                        Prediksi {{ $selectedKecamatanLabel ?: 'Semua Data' }}
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
                    <h5>Analisis Hasil Prediksi</h5>

                    <p>
                        Berdasarkan hasil perhitungan metode SARIMA yang hanya memanfaatkan seri produksi per triwulan,
                        untuk wilayah <b>{{ $selectedKecamatanLabel ?: 'gabungan seluruh data' }}</b>,
                        produksi mangga diprediksi sebesar
                        <b>{{ $prediksi }} ton</b>.
                    </p>

                    <p>
                        Dibandingkan dengan data terakhir ({{ $lastActual }} ton),
                        terjadi
                        <b>{{ number_format($growth, 2) }}%</b>
                        {{ $growth > 0 ? 'peningkatan' : 'penurunan' }} produksi.
                    </p>

                    @if (!empty($predictionSummary))
                        <p class="mb-0">
                            Tren umum model:
                            <b>{{ $predictionSummary['trend'] ?? '-' }}</b>
                            dengan rata-rata forecast
                            <b>{{ number_format((float) ($predictionSummary['forecast_average'] ?? 0), 2) }} ton</b>.
                        </p>
                    @endif
                </div>
            @endif

            {{-- 🔥 CHART --}}
            <div class="mb-3 text-muted">
                Grafik menampilkan seri input SARIMA berupa histori produksi triwulanan untuk <b>{{ $selectedKecamatanLabel ?: 'seluruh kecamatan' }}</b>.
                @if ($isAgregatKabupaten)
                    Saat semua kecamatan dipilih, data ditampilkan sebagai akumulasi kabupaten per triwulan agar grafik tetap valid.
                @else
                    Jika Anda mengganti kecamatan, maka titik data dan hasil prediksi juga ikut berubah mengikuti kecamatan tersebut.
                @endif
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
                        tension: 0.3
                    },
                    {
                        label: 'Hasil Prediksi',
                        data: dataPrediksi,
                        borderDash: [5, 5],
                        borderWidth: 2,
                        tension: 0.3
                    }
                ]
            },
            options: {
                responsive: true
            }
        });
    </script>

@endpush
