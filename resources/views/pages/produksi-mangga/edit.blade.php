<form action="{{ url('/pages/produksi-mangga/' . $edit['id']) }}" method="POST">
    @csrf
    @method("PUT")
    <div class="modal-body">
        <div class="form-group">
            <label for="tahun" class="form-label"> Tahun </label>
            <input type="number" class="form-control" name="tahun" id="tahun" placeholder="Masukkan Tahun" value="{{ $edit['tahun'] }}">
        </div>

        <div class="form-group">
            <label for="triwulan" class="form-label"> Triwulan </label>
            <select name="triwulan" class="form-control" id="triwulan">
                <option value="">-- Pilih Triwulan --</option>
                @foreach ($daftarTriwulan as $kode => $label)
                    <option {{ $edit['triwulan'] == $kode ? 'selected' : '' }} value="{{ $kode }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="varietas_mangga_id" class="form-label"> Varietas Mangga </label>
            <select name="varietas_mangga_id" class="form-control" id="varietas_mangga_id">
                <option value="">-- Pilih Varietas --</option>
                @foreach ($daftarVarietas as $varietas)
                    <option value="{{ $varietas['id'] }}" {{ $edit['varietas_mangga_id'] == $varietas['id'] ? 'selected' : '' }}>
                        {{ $varietas['nama_varietas'] }} ({{ $varietas['kode_varietas'] }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="luas_tanam" class="form-label"> Luas Tanam </label>
            <input type="number" class="form-control" name="luas_tanam" id="luas_tanam"
                placeholder="Masukkan Luas Tanam" value="{{ $edit['luas_tanam'] }}">
        </div>

        <div class="form-group">
            <label for="luas_panen" class="form-label"> Luas Panen </label>
            <input type="number" class="form-control" name="luas_panen" id="luas_panen"
                placeholder="Masukkan Luas Panen" value="{{ $edit['luas_panen'] }}">
        </div>

        <div class="form-group">
            <label for="jumlah_pohon" class="form-label"> Jumlah Pohon Produktif </label>
            <input type="number" class="form-control" name="jumlah_pohon" id="jumlah_pohon"
                placeholder="Masukkan Jumlah Pohon" value="{{ $edit['jumlah_pohon'] }}">
        </div>

        <div class="form-group">
            <label for="umur_tanaman" class="form-label"> Umur Tanaman </label>
            <input type="number" class="form-control" name="umur_tanaman" id="umur_tanaman" placeholder="Masukkan Umur Tanaman" value="{{ $edit['umur_tanaman'] }}">
        </div>

        <div class="form-group">
            <label for="produksi" class="form-label"> Produksi </label>
            <input type="number" class="form-control" name="produksi" id="produksi" placeholder="Masukkan Produksi" value="{{ $edit['produksi'] }}">
        </div>

        <div class="form-group">
            <label for="catatan" class="form-label"> Catatan Lapangan </label>
            <textarea class="form-control" name="catatan" id="catatan" rows="3"
                placeholder="Tambahkan catatan jika diperlukan">{{ $edit['catatan'] }}</textarea>
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
