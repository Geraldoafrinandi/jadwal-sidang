@extends('admin.layout.main')

@section('content')
<div class="container mt-4">
    <h1>Edit Usulan PKL</h1>

    <form action="{{ route('usulan_pkl.update', $usulanPkl->id_usulan_pkl) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="mahasiswa_id">Mahasiswa</label>
            <select name="mahasiswa_id" class="form-control" required>
                @foreach($mahasiswas as $mahasiswa)
                    <option value="{{ $mahasiswa->id_mahasiswa }}" {{ $mahasiswa->id_mahasiswa == $usulanPkl->mahasiswa_id ? 'selected' : '' }}>
                        {{ $mahasiswa->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="perusahaan_id">Perusahaan</label>
            <select name="perusahaan_id" class="form-control" required>
                @foreach($perusahaans as $perusahaan)
                    <option value="{{ $perusahaan->id_perusahaan }}" {{ $perusahaan->id_perusahaan == $usulanPkl->perusahaan_id ? 'selected' : '' }}>
                        {{ $perusahaan->nama_perusahaan }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="konfirmasi">Konfirmasi</label>
            <select name="konfirmasi" class="form-control" required>
                <option value="0" {{ $usulanPkl->konfirmasi == '0' ? 'selected' : '' }}>Belum</option>
                <option value="1" {{ $usulanPkl->konfirmasi == '1' ? 'selected' : '' }}>Sudah</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
