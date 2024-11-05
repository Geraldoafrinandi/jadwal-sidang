@extends('admin.layout.main')

@section('content')
<div class="container mt-5">
    <h2>Tambah Mahasiswa</h2>
    <form action="{{ route('mahasiswa.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" name="nama" id="nama" class="form-control" required>
            @error('nama')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
            @error('password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="nim">NIM</label>
            <input type="text" name="nim" id="nim" class="form-control" required>
            @error('nim')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- <div class="form-group">
            <label for="role">Role</label>
            <select name="role" id="role" class="form-control" required>
                <option value="">Pilih Role</option>
                <option value="admin">Admin</option>
                <option value="dosen">Dosen</option>
                <option value="mahasiswa">Mahasiswa</option>

            </select>
            @error('role')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div> --}}

        <div class="form-group">
            <label for="prodi_id">Prodi</label>
            <select name="prodi_id" id="prodi_id" class="form-control" required>
                <option value="">Pilih Prodi</option>
                @foreach ($prodi as $item)
                    <option value="{{ $item->id_prodi }}">{{ $item->prodi }}</option>
                @endforeach
            </select>
            @error('prodi_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Gender</label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" id="laki-laki" value="1" required>
                <label class="form-check-label" for="laki-laki">Laki-laki</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" id="perempuan" value="0" required>
                <label class="form-check-label" for="perempuan">Perempuan</label>
            </div>
            @error('gender')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Status Mahasiswa</label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status_mahasiswa" id="aktif" value="1" required>
                <label class="form-check-label" for="aktif">Aktif</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status_mahasiswa" id="tidak-aktif" value="0" required>
                <label class="form-check-label" for="tidak-aktif">Tidak Aktif</label>
            </div>
            @error('status_mahasiswa')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="image">Gambar</label>
            <input type="file" name="image" id="image" class="form-control" accept="image/*">
            @error('image')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Kirim</button>
    </form>
</div>
@endsection
