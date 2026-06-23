<form action="{{ url('/pages/varietas-mangga/' . $edit->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="modal-body">
        <div class="form-group">
            <label for="kode_varietas_edit">Kode Varietas</label>
            <input type="text" class="form-control" name="kode_varietas" id="kode_varietas_edit"
                placeholder="Masukkan kode varietas" value="{{ old('kode_varietas', $edit->kode_varietas) }}">
        </div>
        <div class="form-group">
            <label for="nama_varietas_edit">Nama Varietas</label>
            <input type="text" class="form-control" name="nama_varietas" id="nama_varietas_edit"
                placeholder="Masukkan nama varietas" value="{{ old('nama_varietas', $edit->nama_varietas) }}">
        </div>
        <div class="form-group">
            <label for="asal_varietas_edit">Asal Varietas</label>
            <input type="text" class="form-control" name="asal_varietas" id="asal_varietas_edit"
                placeholder="Masukkan asal varietas" value="{{ old('asal_varietas', $edit->asal_varietas) }}">
        </div>
        <div class="form-group">
            <label for="deskripsi_edit">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi_edit" class="form-control" rows="4"
                placeholder="Masukkan deskripsi varietas">{{ old('deskripsi', $edit->deskripsi) }}</textarea>
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
