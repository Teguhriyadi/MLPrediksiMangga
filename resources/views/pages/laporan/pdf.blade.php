<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ $hasilLaporan['title'] }}</title>
    <style>
        @page {
            margin: 20px 18px 18px 18px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: {{ $paperConfig['font_size'] ?? '9px' }};
            color: #222;
        }

        h2,
        p {
            margin: 0 0 8px 0;
        }

        h2 {
            font-size: 18px;
        }

        .meta {
            margin-bottom: 16px;
            font-size: 10px;
        }

        .summary {
            margin-bottom: 14px;
        }

        .summary span {
            display: inline-block;
            margin-right: 18px;
        }

        .pdf-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            word-wrap: break-word;
            word-break: break-word;
        }

        .pdf-table th,
        .pdf-table td {
            border: 1px solid #444;
            padding: {{ $paperConfig['cell_padding'] ?? '5px' }};
            vertical-align: top;
            overflow-wrap: anywhere;
        }

        .pdf-table th {
            background: #efefef;
            text-align: center;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <h2>{{ $hasilLaporan['title'] }}</h2>
    <p>{{ $hasilLaporan['subtitle'] }}</p>

    <div class="meta">
        <strong>Tahun:</strong> {{ $hasilLaporan['filters']['tahun'] ?? 'Semua' }} |
        <strong>Kecamatan:</strong> {{ $hasilLaporan['filters']['kecamatan_label'] ?? 'Semua' }} |
        <strong>Tanggal Cetak:</strong> {{ now()->format('d-m-Y H:i') }}
    </div>

    <div class="summary">
        @foreach ($hasilLaporan['summary'] as $item)
            <span><strong>{{ $item['label'] }}:</strong> {{ $item['value'] }}</span>
        @endforeach
    </div>

    @include('pages.laporan.partials.pdf-table', ['hasilLaporan' => $hasilLaporan])
</body>

</html>
