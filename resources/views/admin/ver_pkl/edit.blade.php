@extends('admin.layout.main')

@section('content')
<div class="container">
    <h1>Edit Data PKL</h1>
    <form action="{{ route('ver_pkl.update', $ver_pkl->id_ver_pkl) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="mahasiswa_id">Mahasiswa</label>
            <select name="mahasiswa_id" class="form-control @error('mahasiswa_id') is-invalid @enderror" required>
                <option value="">Pilih Mahasiswa</option>
                @foreach($mahasiswa as $mhs)
                    <option value="{{ $mhs->id_mahasiswa }}" {{ old('mahasiswa_id', $ver_pkl->mahasiswa_id) == $mhs->id_mahasiswa ? 'selected' : '' }}>
                        {{ $mhs->nama }}
                    </option>
                @endforeach
            </select>
            @error('mahasiswa_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>


        <div class="form-group">
            <label for="nilai_industri">Nilai Industri</label>
            <input type="file" class="form-control @error('nilai_industri') is-invalid @enderror" name="nilai_industri">
            <small class="form-text text-muted">Current: {{ $ver_pkl->nilai_industri }}</small>
            @error('nilai_industri')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="laporan_pkl">Laporan PKL</label>
            <input type="file" class="form-control @error('laporan_pkl') is-invalid @enderror" name="laporan_pkl">
            <small class="form-text text-muted">Current: {{ $ver_pkl->laporan_pkl }}</small>
            @error('laporan_pkl')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" class="form-control">
                <option value="0" {{ $ver_pkl->status == '0' ? 'selected' : '' }}>Belum Diverifikasi</option>
                <option value="1" {{ $ver_pkl->status == '1' ? 'selected' : '' }}>Diverifikasi</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
