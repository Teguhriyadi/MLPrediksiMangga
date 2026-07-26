@extends('master.app')

@push('title', 'Laporan')

@push('modules')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <div>
                <h6 class="m-0 font-weight-bold text-primary">{{ $hasilLaporan['title'] }}</h6>
                <small class="text-muted">{{ $hasilLaporan['subtitle'] }}</small>
            </div>
            <div class="text-right">
                <a href="{{ url('/pages/laporan/excel?' . http_build_query(['jenis' => $jenisLaporan, 'tahun' => $filters['tahun'], 'kecamatan' => $filters['kecamatan']])) }}"
                    class="btn btn-success btn-sm">
                    <i class="fa fa-file-excel"></i> Unduh Excel
                </a>
                <a href="{{ url('/pages/laporan/pdf?' . http_build_query(['jenis' => $jenisLaporan, 'tahun' => $filters['tahun'], 'kecamatan' => $filters['kecamatan']])) }}"
                    class="btn btn-danger btn-sm">
                    <i class="fa fa-file-pdf"></i> Unduh PDF
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ url('/pages/laporan') }}" method="GET">
                <div class="form-row align-items-end">
                    <div class="form-group col-lg-4 col-md-6">
                        <label for="jenis">Jenis Laporan</label>
                        <select name="jenis" id="jenis" class="form-control">
                            @foreach ($opsiJenis as $kode => $label)
                                <option value="{{ $kode }}" {{ $jenisLaporan === $kode ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-lg-3 col-md-6">
                        <label for="tahun">Tahun</label>
                        <select name="tahun" id="tahun" class="form-control">
                            <option value="">Semua Tahun</option>
                            @foreach ($opsiTahun as $tahun)
                                <option value="{{ $tahun }}" {{ (string) $filters['tahun'] === (string) $tahun ? 'selected' : '' }}>
                                    {{ $tahun }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-lg-3 col-md-6">
                        <label for="kecamatan">Kecamatan</label>
                        <select name="kecamatan" id="kecamatan" class="form-control">
                            <option value="">Semua Kecamatan</option>
                            @foreach ($opsiKecamatan as $kecamatan)
                                <option value="{{ $kecamatan->id }}" {{ (string) $filters['kecamatan'] === (string) $kecamatan->id ? 'selected' : '' }}>
                                    {{ $kecamatan->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-lg-2 col-md-6">
                        <button type="submit" class="btn btn-primary btn-sm btn-block mb-2">
                            <i class="fa fa-search"></i> Tampilkan
                        </button>
                        <a href="{{ url('/pages/laporan') }}" class="btn btn-secondary btn-sm btn-block">
                            Reset
                        </a>
                    </div>
                </div>
            </form>

            <div>
                <strong>Filter Aktif:</strong>
                <span class="badge badge-light">Jenis: {{ $opsiJenis[$jenisLaporan] ?? '-' }}</span>
                <span class="badge badge-light">Tahun: {{ $filters['tahun'] ?? 'Semua' }}</span>
                <span class="badge badge-light">Kecamatan: {{ $filters['kecamatan_label'] ?? 'Semua' }}</span>
                <span class="badge badge-primary">{{ $paginatedRows->total() }} baris</span>
            </div>
        </div>
    </div>

    <div class="row">
        @foreach ($hasilLaporan['summary'] as $item)
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">{{ $item['label'] }}</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $item['value'] }}</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Laporan</h6>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap">
                <small class="text-muted">Tabel dibuat scrollable, jadi bisa digeser ke kanan atau kiri tanpa menarik lebar layout.</small>
                <small class="text-muted">
                    Menampilkan {{ $paginatedRows->firstItem() ?? 0 }}-{{ $paginatedRows->lastItem() ?? 0 }}
                    dari {{ $paginatedRows->total() }} data. Geser tabel untuk melihat semua kolom.
                </small>
            </div>
            <div class="table-responsive" style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
                @include('pages.laporan.partials.table', [
                    'headers' => $hasilLaporan['headers'],
                    'rows' => $paginatedRows->items(),
                ])
            </div>

            @if ($paginatedRows->hasPages())
                <div class="d-flex justify-content-between align-items-center flex-wrap mt-3">
                    <small class="text-muted">
                        Halaman {{ $paginatedRows->currentPage() }} dari {{ $paginatedRows->lastPage() }}
                    </small>
                    {{ $paginatedRows->onEachSide(1)->links('pagination::bootstrap-4') }}
                </div>
            @endif
        </div>
    </div>
@endpush
