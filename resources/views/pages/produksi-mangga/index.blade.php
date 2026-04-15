@extends('master.app')

@push('title', 'Produksi Mangga')

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
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
                <i class="fa fa-plus"></i> Tambah Data
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">Tahun</th>
                            <th class="text-center">Triwulan</th>
                            <th class="text-center">Luas Tanam</th>
                            <th class="text-center">Luas Panen</th>
                            <th class="text-center">Curah Hujan</th>
                            <th class="text-center">Suhu</th>
                            <th class="text-center">Produksi</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $nomer = 0;
                        @endphp
                        @foreach ($produksi as $item)
                            <tr>
                                <td class="text-center">{{ ++$nomer }}.</td>
                                <td class="text-center">{{ $item['tahun'] }}</td>
                                <td class="text-center">{{ $item['triwulan'] }}</td>
                                <td class="text-center">{{ $item['luas_tanam'] }}</td>
                                <td class="text-center">{{ $item['luas_panen'] }}</td>
                                <td class="text-center">{{ $item['curah_hujan'] }}</td>
                                <td class="text-center">{{ $item['suhu'] }}</td>
                                <td class="text-center">{{ $item['produksi'] }}</td>
                                <td class="text-center">
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
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fa fa-plus"></i> Tambah Data
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form action="{{ url('/pages/produksi-mangga') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="tahun" class="form-label"> Tahun </label>
                            <input type="number" class="form-control" name="tahun" id="tahun"
                                placeholder="Masukkan Tahun">
                        </div>

                        <div class="form-group">
                            <label for="triwulan" class="form-label"> Triwulan </label>
                            <select name="triwulan" class="form-control" id="triwulan">
                                <option value="">-- Pilih Triwulan --</option>
                                <option value="Q1">Q1 (Jan - Mar)</option>
                                <option value="Q2">Q2 (Apr - Jun)</option>
                                <option value="Q3">Q3 (Jul - Sep)</option>
                                <option value="Q4">Q4 (Okt - Des)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="luas_tanam" class="form-label"> Luas Tanam </label>
                            <input type="number" class="form-control" name="luas_tanam" id="luas_tanam"
                                placeholder="Masukkan Luas Tanam">
                        </div>

                        <div class="form-group">
                            <label for="luas_panen" class="form-label"> Luas Panen </label>
                            <input type="number" class="form-control" name="luas_panen" id="luas_panen"
                                placeholder="Masukkan Luas Panen">
                        </div>

                        <div class="form-group">
                            <label for="curah_hujan" class="form-label"> Curah Hujan </label>
                            <input type="number" class="form-control" name="curah_hujan" id="curah_hujan"
                                placeholder="Masukkan Curah Hujan">
                        </div>

                        <div class="form-group">
                            <label for="suhu" class="form-label"> Suhu </label>
                            <input type="number" class="form-control" name="suhu" id="suhu"
                                placeholder="Masukkan Suhu">
                        </div>

                        <div class="form-group">
                            <label for="produksi" class="form-label"> Produksi </label>
                            <input type="number" class="form-control" name="produksi" id="produksi"
                                placeholder="Masukkan Produksi">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-danger btn-sm">
                            <i class="fa fa-times"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="fa fa-save"></i> Simpan
                        </button>
                    </div>
                </form>
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
