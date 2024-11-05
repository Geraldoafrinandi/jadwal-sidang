@extends('admin.layout.main')

@section('content')
<div class="container mt-5">

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <h2>Edit Mahasiswa</h2>
    <form action="{{ route('mahasiswa.update', $mahasiswa->id_mahasiswa) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', $mahasiswa->nama) }}" required>
        </div>

        <div class="form-group">
            <label for="nim">NIM</label>
            <input type="text" name="nim" id="nim" class="form-control" value="{{ old('nim', $mahasiswa->nim) }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $mahasiswa->user->email) }}" required>
        </div>

        <div class="form-group">
            <label for="password">Password (leave blank to keep current password):</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>

        <div class="form-group">
            <label for="role">Role</label>
            <select name="role" id="role" class="form-control" required>
                <option value="">Pilih Role</option>
                <option value="admin" {{ $mahasiswa->user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="dosen" {{ $mahasiswa->user->role == 'dosen' ? 'selected' : '' }}>Dosen</option>
                <option value="mahasiswa" {{ $mahasiswa->user->role == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
            </select>
        </div>

        <div class="form-group">
            <label for="prodi_id">Prodi</label>
            <select name="prodi_id" id="prodi_id" class="form-control" required>
                <option value="">Pilih Prodi</option>
                @foreach ($prodi as $item)
                    <option value="{{ $item->id_prodi }}" {{ $item->id_prodi == $mahasiswa->prodi_id ? 'selected' : '' }}>
                        {{ $item->prodi }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Gender Radio Button -->
        <div class="form-group">
            <label for="gender">Gender</label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" id="laki-laki" value="1" {{ $mahasiswa->gender == '1' ? 'checked' : '' }} required>
                <label class="form-check-label" for="laki-laki">Laki-laki</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" id="perempuan" value="0" {{ $mahasiswa->gender == '0' ? 'checked' : '' }} required>
                <label class="form-check-label" for="perempuan">Perempuan</label>
            </div>
        </div>

        <!-- Status Radio Button -->
        <div class="form-group">
            <label for="status_mahasiswa">Status Mahasiswa</label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status_mahasiswa" id="aktif" value="1" {{ $mahasiswa->status_mahasiswa == '1' ? 'checked' : '' }} required>
                <label class="form-check-label" for="aktif">Aktif</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status_mahasiswa" id="tidak-aktif" value="0" {{ $mahasiswa->status_mahasiswa == '0' ? 'checked' : '' }} required>
                <label class="form-check-label" for="tidak-aktif">Tidak Aktif</label>
            </div>
        </div>

        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" id="image" class="form-control">
            <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti foto.</small>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
