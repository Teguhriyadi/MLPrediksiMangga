<form action="{{ url('/pages/users/' . $edit['id']) }}" method="POST">
    @csrf
    @method("PUT")
    <div class="modal-body">
        <div class="form-group">
            <label for="nama" class="form-label"> Nama </label>
            <input type="text" class="form-control" name="nama" id="nama" placeholder="Masukkan Nama" value="{{ old('nama', $edit['nama']) }}">
        </div>
        <div class="form-group">
            <label for="email" class="form-label"> Email </label>
            <input type="email" class="form-control" name="email" id="email" placeholder="Masukkan Email" value="{{ old('email', $edit['email']) }}">
        </div>
        <div class="form-group">
            <label for="username" class="form-label"> Username </label>
            <input type="text" class="form-control" name="username" id="username" placeholder="Masukkan Username" value="{{ old('username', $edit['username']) }}">
        </div>
        <div class="form-group">
            <label for="role" class="form-label"> Role </label>
            <select name="role" id="role" class="form-control">
                @foreach ($roles as $roleValue => $roleLabel)
                    <option value="{{ $roleValue }}" {{ old('role', $edit['role']) === $roleValue ? 'selected' : '' }}>
                        {{ $roleLabel }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="kecamatan" class="form-label"> Kecamatan (untuk Role UPTD) </label>
            <select name="kecamatan" id="kecamatan" class="form-control">
                <option value="">Pilih Kecamatan</option>
                @foreach ($kecamatans as $kecamatan)
                    <option value="{{ $kecamatan }}" {{ old('kecamatan', $edit['kecamatan']) === $kecamatan ? 'selected' : '' }}>
                        {{ $kecamatan }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="nomor_hp" class="form-label"> Nomor HP </label>
            <input type="text" class="form-control" name="nomor_hp" id="nomor_hp" placeholder="Masukkan Nomor HP" value="{{ old('nomor_hp', $edit['nomor_hp']) }}">
        </div>
        <div class="form-group">
            <label for="alamat" class="form-label"> Alamat </label>
            <textarea name="alamat" class="form-control" id="alamat" rows="5" placeholder="Masukkan Alamat">{{ old('alamat', $edit['alamat']) }}</textarea>
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
