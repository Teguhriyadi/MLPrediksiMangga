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
                <option {{ $edit['triwulan'] == "Q1" ? 'selected' : '' }} value="Q1">Q1 (Jan - Mar)</option>
                <option {{ $edit['triwulan'] == "Q2" ? 'selected' : '' }} value="Q2">Q2 (Apr - Jun)</option>
                <option {{ $edit['triwulan'] == "Q3" ? 'selected' : '' }} value="Q3">Q3 (Jul - Sep)</option>
                <option {{ $edit['triwulan'] == "Q4" ? 'selected' : '' }} value="Q4">Q4 (Okt - Des)</option>
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
            <label for="curah_hujan" class="form-label"> Curah Hujan </label>
            <input type="number" class="form-control" name="curah_hujan" id="curah_hujan"
                placeholder="Masukkan Curah Hujan" value="{{ $edit['curah_hujan'] }}">
        </div>

        <div class="form-group">
            <label for="suhu" class="form-label"> Suhu </label>
            <input type="number" class="form-control" name="suhu" id="suhu" placeholder="Masukkan Suhu" value="{{ $edit['suhu'] }}">
        </div>

        <div class="form-group">
            <label for="produksi" class="form-label"> Produksi </label>
            <input type="number" class="form-control" name="produksi" id="produksi" placeholder="Masukkan Produksi" value="{{ $edit['produksi'] }}">
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
