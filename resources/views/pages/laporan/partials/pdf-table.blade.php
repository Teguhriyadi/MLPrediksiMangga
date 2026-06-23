<table class="pdf-table">
    <thead>
        <tr>
            @foreach ($hasilLaporan['headers'] as $header)
                <th>{{ $header }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @forelse ($hasilLaporan['rows'] as $row)
            <tr>
                @foreach ($row as $value)
                    <td>{{ $value }}</td>
                @endforeach
            </tr>
        @empty
            <tr>
                <td colspan="{{ count($hasilLaporan['headers']) }}" class="text-center">
                    Tidak ada data untuk filter yang dipilih.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
