<table>
    <tr>
        <td colspan="{{ count($hasilLaporan['headers']) }}">
            <strong>{{ $hasilLaporan['title'] }}</strong>
        </td>
    </tr>
    <tr>
        <td colspan="{{ count($hasilLaporan['headers']) }}">
            {{ $hasilLaporan['subtitle'] }}
        </td>
    </tr>
    <tr>
        <td colspan="{{ count($hasilLaporan['headers']) }}">
            Tahun: {{ $hasilLaporan['filters']['tahun'] ?? 'Semua' }} |
            Kecamatan: {{ $hasilLaporan['filters']['kecamatan_label'] ?? 'Semua' }} |
            Tanggal Cetak: {{ now()->format('d-m-Y H:i') }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        @foreach ($hasilLaporan['headers'] as $header)
            <th>{{ $header }}</th>
        @endforeach
    </tr>

    @forelse ($hasilLaporan['rows'] as $row)
        <tr>
            @foreach ($row as $value)
                <td>{{ $value }}</td>
            @endforeach
        </tr>
    @empty
        <tr>
            <td colspan="{{ count($hasilLaporan['headers']) }}">Tidak ada data untuk filter yang dipilih.</td>
        </tr>
    @endforelse
</table>
