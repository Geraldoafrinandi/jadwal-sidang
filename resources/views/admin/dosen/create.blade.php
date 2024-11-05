@extends('admin.layout.main')

@section('content')
<div class="container mt-4">
    <h2>Tambah Dosen</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('dosen.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="nama_dosen">Nama Dosen</label>
            <input type="text" class="form-control" id="nama_dosen" name="nama_dosen" required>
        </div>

        <div class="form-group">
            <label for="nidn">NIDN</label>
            <input type="text" class="form-control" id="nidn" name="nidn" required>
        </div>

        <div class="form-group">
            <label for="gender">Gender</label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" id="laki-laki" value="1" required>
                <label class="form-check-label" for="laki-laki">Laki-laki</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" id="perempuan" value="0">
                <label class="form-check-label" for="perempuan">Perempuan</label>
            </div>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>

        {{-- <div class="form-group">
            <label for="role">Role</label>
            <select name="role" id="role" class="form-control" required>
                <option value="" disabled selected>Pilih Role</option> <!-- Opsi default untuk memilih role -->
                <option value="admin">Admin</option>
                <option value="dosen">Dosen</option>
                <option value="mahasiswa">Mahasiswa</option>
            </select>
            @error('role')
                <div class="text-danger">{{ $message }}</div> <!-- Menampilkan error jika ada -->
            @enderror
        </div> --}}



        <div class="form-group">
            <label for="jurusan_id">Jurusan</label>
            <select class="form-control" id="jurusan_id" name="jurusan_id" required>
                <option value="">Pilih Jurusan</option>
                @foreach($jurusan as $j)
                    <option value="{{ $j->id_jurusan }}">{{ $j->nama_jurusan }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="prodi_id">Prodi</label>
            <select class="form-control" id="prodi_id" name="prodi_id" required>
                <option value="">Pilih Prodi</option>
                @foreach($prodi as $p)
                    <option data-jurusan="{{ $p->jurusan_id }}" value="{{ $p->id_prodi }}">{{ $p->prodi }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="image">Upload Image</label>
            <input type="file" class="form-control" id="image" name="image">
        </div>

        <div class="form-group">
            <label for="golongan">Golongan</label>
            <select name="golongan" class="form-control" required>
                <option value="">--- Pilih Golongan ---</option>
                <option value="1">Assisten Ahli</option>
                    <option value="2">Lector</option>
                    <option value="3">Lector Kepala</option>
                    <option value="4">Guru Besar</option>
            </select>
        </div>

        <div class="form-group">
            <label>Status Dosen</label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status_dosen" id="statusActive" value="1" required>
                <label class="form-check-label" for="statusActive">Aktif</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status_dosen" id="statusInactive" value="0">
                <label class="form-check-label" for="statusInactive">Tidak Aktif</label>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('dosen.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<script>
    document.getElementById('jurusan_id').addEventListener('change', function() {
        const selectedJurusan = this.value;
        const prodiOptions = document.querySelectorAll('#prodi_id option');

        prodiOptions.forEach(option => {
            if (option.getAttribute('data-jurusan') === selectedJurusan || option.value === "") {
                option.style.display = 'block'; // Tampilkan jika cocok atau option kosong
            } else {
                option.style.display = 'none'; // Sembunyikan jika tidak cocok
            }
        });

        // Reset prodi_id ke option default jika jurusan diubah
        document.getElementById('prodi_id').value = '';
    });
</script>

@endsection
