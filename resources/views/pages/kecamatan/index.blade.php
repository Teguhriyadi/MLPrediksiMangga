@extends('master.app')

@push('title', 'Master Kecamatan')

@push('css')
    <link href="{{ asset('templating/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
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

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambahModal">
                <i class="fa fa-plus"></i> Tambah Kecamatan
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th>Nama Kecamatan</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $nomer = 0; @endphp
                        @foreach ($kecamatans as $kecamatan)
                            <tr>
                                <td class="text-center">{{ ++$nomer }}.</td>
                                <td>{{ $kecamatan->nama }}</td>
                                <td class="text-center">
                                    @if ($kecamatan->is_active)
                                        <span class="badge badge-success">Aktif</span>
                                    @else
                                        <span class="badge badge-danger">Non-Aktif</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                        data-target="#editModal{{ $kecamatan->id }}">
                                        <i class="fa fa-edit"></i> Edit
                                    </button>
                                    <form action="{{ route('kecamatan.toggle', $kecamatan->id) }}" method="POST" style="display: inline">
                                        @csrf
                                        <button type="submit" class="btn btn-info btn-sm">
                                            <i class="fa fa-{{ $kecamatan->is_active ? 'times' : 'check' }}"></i>
                                            {{ $kecamatan->is_active ? 'Non-Aktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>
                                    <form action="{{ route('kecamatan.destroy', $kecamatan->id) }}" method="POST" style="display: inline">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Apakah Anda yakin ingin menghapus kecamatan ini?')" type="submit" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @foreach ($kecamatans as $kecamatan)
        <div class="modal fade" id="editModal{{ $kecamatan->id }}" tabindex="-1" role="dialog"
            aria-labelledby="editModalLabel{{ $kecamatan->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel{{ $kecamatan->id }}">
                            <i class="fa fa-edit"></i> Edit Kecamatan
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('kecamatan.update', $kecamatan->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nama{{ $kecamatan->id }}">
                                    Nama Kecamatan
                                    <small class="text-danger">*</small>
                                </label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama{{ $kecamatan->id }}" placeholder="Masukkan Nama Kecamatan" name="nama"
                                    value="{{ old('nama', $kecamatan->nama) }}">

                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">
                                <i class="fa fa-times"></i> Batal
                            </button>
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Modal Tambah -->
    <div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahModalLabel">
                        <i class="fa fa-plus"></i> Tambah Kecamatan
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('kecamatan.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama">
                                Nama Kecamatan
                                <small class="text-danger">*</small>
                            </label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" placeholder="Masukkan Nama Kecamatan">

                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">
                            <i class="fa fa-times"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endpush

@push('js')
    <script src="{{ asset('templating/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('templating/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('templating/js/demo/datatables-demo.js') }}"></script>
@endpush
