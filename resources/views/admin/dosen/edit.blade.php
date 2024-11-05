@extends('admin.layout.main')

@section('content')
<div class="container mt-4">
    <h2>Edit Dosen</h2>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


    <form action="{{ route('dosen.update', $dosen->id_dosen) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nama_dosen">Nama Dosen</label>
            <input type="text" class="form-control" id="nama_dosen" name="nama_dosen" value="{{ old('nama_dosen', $dosen->nama_dosen) }}" required>
        </div>

        <div class="form-group">
            <label for="nidn">NIDN</label>
            <input type="text" class="form-control" id="nidn" name="nidn" value="{{ old('nidn', $dosen->nidn) }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $dosen->user->email ?? '') }}" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Biarkan kosong jika tidak ingin mengganti password">
        </div>

        <div class="form-group">
            <label for="gender">Gender</label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" id="laki-laki" value="1" {{ old('gender', $dosen->gender) == '1' ? 'checked' : '' }} required>
                <label class="form-check-label" for="laki-laki">Laki-laki</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" id="perempuan" value="0" {{ old('gender', $dosen->gender) == '0' ? 'checked' : '' }}>
                <label class="form-check-label" for="perempuan">Perempuan</label>
            </div>
        </div>

        <div class="form-group">
            <label for="jurusan_id">Jurusan</label>
            <select class="form-control" id="jurusan_id" name="jurusan_id" required>
                @foreach($jurusan as $j)
                    <option value="{{ $j->id_jurusan }}" {{ $j->id_jurusan == old('jurusan_id', $dosen->jurusan_id) ? 'selected' : '' }}>
                        {{ $j->nama_jurusan }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="prodi_id">Prodi</label>
            <select class="form-control" id="prodi_id" name="prodi_id" required>
                <option value="">Pilih Prodi</option>
                @foreach($prodi as $p)
                    <option data-jurusan="{{ $p->jurusan_id }}" value="{{ $p->id_prodi }}" {{ $p->id_prodi == old('prodi_id', $dosen->prodi_id) ? 'selected' : '' }}>
                        {{ $p->prodi }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="image">Upload Image</label>
            <input type="file" class="form-control" id="image" name="image">
            <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengganti gambar.</small>
            @if ($dosen->image)
                <div class="mt-2">
                    <img src="{{ asset('images/dosen/' . $dosen->image) }}" alt="{{ $dosen->nama_dosen }}" class="img-thumbnail" style="max-width: 150px;">
                </div>
            @endif
        </div>

        <div class="form-group">
            <label for="golongan">Golongan</label>
            <select name="golongan" class="form-control" required>
                <option value="">-- Pilih Golongan --</option>
                <option value="1" {{ $dosen->golongan == '1' ? 'selected' : '' }}>Asisten Ahli</option>
                <option value="2" {{ $dosen->golongan == '2' ? 'selected' : '' }}>Lector</option>
                <option value="3" {{ $dosen->golongan == '3' ? 'selected' : '' }}>Lector Kepala</option>
                <option value="4" {{ $dosen->golongan == '4' ? 'selected' : '' }}>Guru Besar</option>
            </select>
        </div>

        <div class="form-group">
            <label>Status Dosen</label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status_dosen" id="statusActive" value="1" {{ $dosen->status_dosen == '1' ? 'checked' : '' }} required>
                <label class="form-check-label" for="statusActive">Aktif</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status_dosen" id="statusInactive" value="0" {{ $dosen->status_dosen == '0' ? 'checked' : '' }}>
                <label class="form-check-label" for="statusInactive">Tidak Aktif</label>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('dosen.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<script>
    document.getElementById('jurusan_id').addEventListener('change', function() {
        const selectedJurusan = this.value;
        const prodiOptions = document.querySelectorAll('#prodi_id option');

        prodiOptions.forEach(option => {
            option.style.display = (option.dataset.jurusan == selectedJurusan) ? 'block' : 'none';
            if (option.style.display === 'block') {
                option.selected = true; // Select the first visible option
            } else {
                option.selected = false; // Deselect other options
            }
        });
    });
</script>
@endsection
