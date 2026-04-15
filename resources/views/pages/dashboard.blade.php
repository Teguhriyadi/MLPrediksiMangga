@extends('master.app')

@push('title', 'Dashboard')

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

    <div class="card mt-3">
        <div class="card-body">
            <h5>Metode Peramalan</h5>
            <p>
                Sistem ini menggunakan metode <b>SARIMA (Seasonal ARIMA)</b>
                untuk melakukan prediksi time series berdasarkan data produksi mangga per triwulan.
            </p>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <h5>Dataset</h5>
            <p>Total data: {{ $produksi->count() }} record</p>
            <p>Periode: 2021 - 2026</p>
        </div>
    </div>

    <div class="card shadow mt-3">
        <div class="card-body">

            {{-- 🔥 BUTTON PREDIKSI --}}
            <form action="{{ url('/pages/machine') }}" method="POST">
                @csrf
                <button class="btn btn-success mb-3">
                    Prediksi
                </button>
            </form>

            @php
                $lastActual = $produksi->last()->produksi ?? 0;
                $result = session('result') ?? [];
                $prediksi = array_values($result)[0] ?? 0;

                $growth = $lastActual > 0 ? (($prediksi - $lastActual) / $lastActual) * 100 : 0;
            @endphp

            @if (session('result'))
                <div class="alert alert-success mt-3">
                    <h5>Analisis Hasil Prediksi</h5>

                    <p>
                        Berdasarkan hasil perhitungan menggunakan metode SARIMA,
                        produksi mangga diprediksi sebesar
                        <b>{{ $prediksi }} ton</b>.
                    </p>

                    <p>
                        Dibandingkan dengan data terakhir ({{ $lastActual }} ton),
                        terjadi
                        <b>{{ number_format($growth, 2) }}%</b>
                        {{ $growth > 0 ? 'peningkatan' : 'penurunan' }} produksi.
                    </p>
                </div>
            @endif

            {{-- 🔥 CHART --}}
            <canvas id="chartProduksi"></canvas>

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
