@php
    $tableHeaders = $headers ?? ($hasilLaporan['headers'] ?? []);
    $tableRows = $rows ?? ($hasilLaporan['rows'] ?? []);
    $minWidth = max(1200, count($tableHeaders) * 140);
@endphp

<table class="table table-bordered table-sm mb-0" style="min-width: {{ $minWidth }}px;" cellspacing="0">
    <thead>
        <tr>
            @foreach ($tableHeaders as $header)
                <th class="text-center text-nowrap">{{ $header }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @forelse ($tableRows as $row)
            <tr>
                @foreach ($row as $value)
                    <td class="text-nowrap">{{ $value }}</td>
                @endforeach
            </tr>
        @empty
            <tr>
                <td colspan="{{ count($tableHeaders) }}" class="text-center">
                    Tidak ada data untuk filter yang dipilih.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
