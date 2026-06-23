@extends('master.app')

@push('title', 'Master Varietas Mangga')

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
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTambahVarietas">
                <i class="fa fa-plus"></i> Tambah Varietas
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th>Kode Varietas</th>
                            <th>Nama Varietas</th>
                            <th>Asal Varietas</th>
                            <th>Deskripsi</th>
                            <th class="text-center">Jumlah Digunakan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $nomor = 0;
                        @endphp
                        @foreach ($varietas as $item)
                            <tr>
                                <td class="text-center">{{ ++$nomor }}.</td>
                                <td>{{ $item->kode_varietas }}</td>
                                <td>{{ $item->nama_varietas }}</td>
                                <td>{{ $item->asal_varietas ?? '-' }}</td>
                                <td>{{ $item->deskripsi ?? '-' }}</td>
                                <td class="text-center">{{ $item->produksi_mangga_count }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                        data-target="#modalEditVarietas" onclick="editData(`{{ $item->id }}`)">
                                        <i class="fa fa-edit"></i> Edit
                                    </button>
                                    <form action="{{ url('/pages/varietas-mangga/' . $item->id) }}" method="POST"
                                        style="display: inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus varietas ini?')"
                                            {{ $item->produksi_mangga_count > 0 ? 'disabled' : '' }}>
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

    <div class="modal fade" id="modalTambahVarietas" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fa fa-plus"></i> Tambah Varietas Mangga
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('/pages/varietas-mangga') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="kode_varietas">Kode Varietas</label>
                            <input type="text" class="form-control" name="kode_varietas" id="kode_varietas"
                                placeholder="Masukkan kode varietas" value="{{ old('kode_varietas') }}">
                        </div>
                        <div class="form-group">
                            <label for="nama_varietas">Nama Varietas</label>
                            <input type="text" class="form-control" name="nama_varietas" id="nama_varietas"
                                placeholder="Masukkan nama varietas" value="{{ old('nama_varietas') }}">
                        </div>
                        <div class="form-group">
                            <label for="asal_varietas">Asal Varietas</label>
                            <input type="text" class="form-control" name="asal_varietas" id="asal_varietas"
                                placeholder="Masukkan asal varietas" value="{{ old('asal_varietas') }}">
                        </div>
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4"
                                placeholder="Masukkan deskripsi varietas">{{ old('deskripsi') }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-danger">
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

    <div class="modal fade" id="modalEditVarietas" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fa fa-edit"></i> Edit Varietas Mangga
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
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
                url: "{{ url('/pages/varietas-mangga') }}" + "/" + id + "/edit",
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
