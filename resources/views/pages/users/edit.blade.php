<form action="{{ url('/pages/users/' . $edit['id']) }}" method="POST">
    @csrf
    @method("PUT")
    <div class="modal-body">
        <div class="form-group">
            <label for="nama" class="form-label">
                Nama
                <small class="text-danger">*</small>
            </label>
            <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" id="nama" placeholder="Masukkan Nama" value="{{ old('nama', $edit['nama']) }}">

            @error('nama')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="email" class="form-label"> Email </label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Masukkan Email" value="{{ old('email', $edit['email']) }}">

            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="username" class="form-label"> Username </label>
            <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" id="username" placeholder="Masukkan Username" value="{{ old('username', $edit['username']) }}">
            
            @error('username')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="role" class="form-label"> Role </label>
            <select name="role" id="role" class="form-control @error('role') is-invalid @enderror">
                @foreach ($roles as $roleValue => $roleLabel)
                    <option value="{{ $roleValue }}" {{ old('role', $edit['role']) === $roleValue ? 'selected' : '' }}>
                        {{ $roleLabel }}
                    </option>
                @endforeach
            </select>

            @error('role')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="kecamatan_id" class="form-label"> Kecamatan (untuk Role UPTD) </label>
            <select name="kecamatan_id" id="kecamatan_id" class="form-control">
                <option value="">Pilih Kecamatan</option>
                @foreach ($kecamatans as $kecamatan)
                    <option value="{{ $kecamatan->id }}" {{ (string) old('kecamatan_id', $edit['kecamatan_id']) === (string) $kecamatan->id ? 'selected' : '' }}>
                        {{ $kecamatan->nama }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="nomor_hp" class="form-label">
                Nomor HP
                <small class="text-danger">*</small>
            </label>
            <input type="text" class="form-control @error('nomor_hp') is-invalid @enderror" name="nomor_hp" id="nomor_hp" placeholder="Masukkan Nomor HP" value="{{ old('nomor_hp', $edit['nomor_hp']) }}">

            @error('nomor_hp')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="alamat" class="form-label"> Alamat </label>
            <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" id="alamat" rows="5" placeholder="Masukkan Alamat">{{ old('alamat', $edit['alamat']) }}</textarea>

            @error('alamat')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
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
