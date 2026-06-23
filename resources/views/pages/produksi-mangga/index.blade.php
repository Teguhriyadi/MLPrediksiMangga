@extends('master.app')

@push('title', 'Produksi Mangga')

@push('css')
    <link href="{{ asset('templating/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@push('modules')
    @php
        $canManageProduksi = Auth::user()->hasAnyRole([\App\Models\User::ROLE_ADMIN, \App\Models\User::ROLE_OPERATOR]);
    @endphp

    @if (session('success'))
        <div class="alert alert-success">
            <strong>Berhasil,</strong> {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger">
            <strong>Gagal,</strong> {{ session('error') }}
        </div>
    @endif

    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Data</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $ringkasan['total_data'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Produksi</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($ringkasan['total_produksi'], 2, ',', '.') }} ton</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Rata-rata Produksi</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($ringkasan['rata_produksi'], 2, ',', '.') }} ton</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Kecamatan Aktif</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $ringkasan['kecamatan_aktif'] }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <div>
                <h6 class="m-0 font-weight-bold text-primary">Dataset Produktivitas Mangga</h6>
                <small class="text-muted">Data disusun per kecamatan dan per triwulan untuk mendukung analisis SARIMA.</small>
            </div>
            @if ($canManageProduksi)
                <a href="{{ url('/pages/produksi-mangga/create') }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-plus"></i> Tambah Data
                </a>
            @endif
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">Kecamatan</th>
                            <th class="text-center">Periode</th>
                            <th class="text-center">Varietas</th>
                            <th class="text-center">Luas Panen</th>
                            <th class="text-center">Produksi</th>
                            <th class="text-center">Produktivitas</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $nomer = 0;
                        @endphp
                        @foreach ($produksi as $item)
                            @php
                                $produktivitas = $item['luas_panen'] > 0 ? $item['produksi'] / $item['luas_panen'] : 0;
                                $status = $produktivitas >= 0.12 ? 'Tinggi' : ($produktivitas >= 0.08 ? 'Sedang' : 'Rendah');
                            @endphp
                            <tr>
                                <td class="text-center">{{ ++$nomer }}.</td>
                                <td>{{ $item['kecamatan'] ?? '-' }}</td>
                                <td class="text-center">{{ $item['tahun'] }} {{ $item['triwulan'] }}</td>
                                <td class="text-center">{{ $item->varietasMangga->nama_varietas ?? ($item['varietas'] ?? '-') }}</td>
                                <td class="text-center">{{ number_format((float) $item['luas_panen'], 2, ',', '.') }}</td>
                                <td class="text-center">{{ number_format((float) $item['produksi'], 2, ',', '.') }}</td>
                                <td class="text-center">{{ number_format($produktivitas, 2, ',', '.') }} ton/ha</td>
                                <td class="text-center">
                                    <span class="badge badge-{{ $status === 'Tinggi' ? 'success' : ($status === 'Sedang' ? 'warning' : 'danger') }}">
                                        {{ $status }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ url('/pages/produksi-mangga/' . $item['id']) }}" class="btn btn-info btn-sm">
                                        <i class="fa fa-eye"></i> Detail
                                    </a>
                                    @if ($canManageProduksi)
                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#exampleModalEdit" onclick="editData(`{{ $item['id'] }}`)">
                                            <i class="fa fa-edit"></i> Edit
                                        </button>
                                        <form action="{{ url('/pages/produksi-mangga/' . $item['id']) }}" method="POST" style="display: inline">
                                            @csrf
                                            @method("DELETE")
                                            <button onclick="return confirm('Apakah Anda Yakin? Ingin Menghapus Data Ini?')" type="submit" class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fa fa-edit"></i> Edit Data
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div id="modal-content-edit"></div>
            </div>
        </div>
    </div>

@endpush

@push('js')
    <script src="{{ asset('templating/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('templating/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('templating/js/demo/datatables-demo.js') }}"></script>
    <script type="text/javascript">
        function editData(id) {
            $.ajax({
                url: "{{ url('/pages/produksi-mangga') }}" + "/" + id + "/edit",
                type: "GET",
                success: function(response) {
                    $("#modal-content-edit").html(response)
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
    </script>
@endpush
