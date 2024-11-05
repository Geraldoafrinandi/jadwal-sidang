@extends('admin.layout.main')

@section('content')
<div class="container mt-4">
    <h1>Registrasi PKL</h1>

    <form action="{{ route('usulan_pkl.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="mahasiswa_id">Mahasiswa</label>
            <select name="mahasiswa_id" class="form-control" required>
                <option value="">Pilih Mahasiswa</option>
                @foreach($mahasiswas as $mahasiswa)
                    <option value="{{ $mahasiswa->id_mahasiswa }}">{{ $mahasiswa->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="perusahaan_id">Perusahaan</label>
            <select name="perusahaan_id" class="form-control" required>
                <option value="">Pilih Perusahaan</option>
                @foreach($perusahaans as $perusahaan)
                    <option value="{{ $perusahaan->id_perusahaan }}">{{ $perusahaan->nama_perusahaan }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="konfirmasi">Konfirmasi</label>
            <select name="konfirmasi" class="form-control" required>
                <option value="0">Belum</option>
                <option value="1">Sudah</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
