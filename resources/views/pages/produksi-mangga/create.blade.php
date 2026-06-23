@extends('master.app')

@push('title', 'Tambah Data Produksi Mangga')

@push('modules')

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Validasi gagal.</strong>
            <ul class="mb-0 mt-2 pl-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            <strong>Gagal,</strong> {{ session('error') }}
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Input Produktivitas Mangga</h6>
                </div>
                <div class="card-body">
                    <form action="{{ url('/pages/produksi-mangga') }}" method="POST">
                        @csrf

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="kecamatan">Kecamatan</label>
                                <select name="kecamatan" id="kecamatan" class="form-control" required>
                                    <option value="">-- Pilih Kecamatan --</option>
                                    @foreach ($daftarKecamatan as $kecamatan)
                                        <option value="{{ $kecamatan }}" {{ old('kecamatan') === $kecamatan ? 'selected' : '' }}>
                                            {{ $kecamatan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="tahun">Tahun</label>
                                <input type="number" class="form-control" name="tahun" id="tahun" value="{{ old('tahun', date('Y')) }}" min="2018" max="2100" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="triwulan">Triwulan</label>
                                <select name="triwulan" id="triwulan" class="form-control" required>
                                    <option value="">-- Pilih --</option>
                                    @foreach ($daftarTriwulan as $kode => $label)
                                        <option value="{{ $kode }}" {{ old('triwulan') === $kode ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="varietas_mangga_id">Varietas Mangga</label>
                                <select name="varietas_mangga_id" id="varietas_mangga_id" class="form-control" required>
                                    <option value="">-- Pilih Varietas --</option>
                                    @foreach ($daftarVarietas as $varietas)
                                        <option value="{{ $varietas['id'] }}" {{ old('varietas_mangga_id') === $varietas['id'] ? 'selected' : '' }}>
                                            {{ $varietas['nama_varietas'] }} ({{ $varietas['kode_varietas'] }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="jumlah_pohon">Jumlah Pohon Produktif</label>
                                <input type="number" step="0.01" class="form-control" name="jumlah_pohon" id="jumlah_pohon" value="{{ old('jumlah_pohon') }}" placeholder="Contoh: 275619" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="luas_tanam">Luas Tanam (ha)</label>
                                <input type="number" step="0.01" class="form-control" name="luas_tanam" id="luas_tanam" value="{{ old('luas_tanam') }}" placeholder="Masukkan luas tanam" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="luas_panen">Luas Panen (ha)</label>
                                <input type="number" step="0.01" class="form-control" name="luas_panen" id="luas_panen" value="{{ old('luas_panen') }}" placeholder="Masukkan luas panen" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="umur_tanaman">Umur Tanaman (tahun)</label>
                                <input type="number" class="form-control" name="umur_tanaman" id="umur_tanaman" value="{{ old('umur_tanaman') }}" placeholder="Contoh: 8" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="curah_hujan">Curah Hujan (mm)</label>
                                <input type="number" step="0.01" class="form-control" name="curah_hujan" id="curah_hujan" value="{{ old('curah_hujan') }}" placeholder="Contoh: 180" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="suhu">Suhu Rata-rata (C)</label>
                                <input type="number" step="0.01" class="form-control" name="suhu" id="suhu" value="{{ old('suhu') }}" placeholder="Contoh: 29" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="pupuk_organik">Pupuk Organik (kg)</label>
                                <input type="number" step="0.01" class="form-control" name="pupuk_organik" id="pupuk_organik" value="{{ old('pupuk_organik') }}" placeholder="Masukkan total pupuk organik" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="serangan_hama">Serangan Hama (%)</label>
                                <input type="number" step="0.01" class="form-control" name="serangan_hama" id="serangan_hama" value="{{ old('serangan_hama') }}" placeholder="Contoh: 12.5" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="produksi">Produksi Aktual (ton)</label>
                                <input type="number" step="0.01" class="form-control" name="produksi" id="produksi" value="{{ old('produksi') }}" placeholder="Masukkan produksi aktual" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="catatan">Catatan Lapangan</label>
                            <textarea name="catatan" id="catatan" rows="4" class="form-control" placeholder="Tambahkan catatan kualitas panen, kondisi lahan, atau kejadian khusus">{{ old('catatan') }}</textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ url('/pages/produksi-mangga') }}" class="btn btn-secondary btn-sm">
                                <i class="fa fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fa fa-save"></i> Simpan dan Lihat Detail
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Kenapa Form Ini Lebih Kuat?</h6>
                </div>
                <div class="card-body">
                    <p class="mb-3">Struktur data ini tidak hanya menyimpan produksi, tetapi juga variabel yang mendukung analisis produktivitas perkebunan.</p>
                    <ul class="pl-3 mb-0">
                        <li>Memungkinkan analisis per kecamatan dan per triwulan.</li>
                        <li>Mencatat faktor budidaya seperti umur tanaman dan pupuk organik.</li>
                        <li>Mencatat faktor iklim seperti curah hujan dan suhu.</li>
                        <li>Mencatat faktor risiko seperti serangan hama.</li>
                        <li>Menyediakan histori yang siap dikirim ke service Python SARIMA.</li>
                    </ul>
                </div>
            </div>

            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Saran Input Data</h6>
                </div>
                <div class="card-body">
                    <p class="mb-2">Supaya prediksi SARIMA stabil, usahakan tiap kecamatan memiliki data historis minimal 8 periode.</p>
                    <p class="mb-0">Jika Anda memakai data dari dokumen dinas, masukkan jumlah pohon, periode triwulan, dan produksi aktual secara konsisten.</p>
                </div>
            </div>
        </div>
    </div>

@endpush
