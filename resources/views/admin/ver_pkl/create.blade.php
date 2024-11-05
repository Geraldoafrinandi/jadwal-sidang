@extends('admin.layout.main')

@section('content')
<div class="container">
    <h1>Registrasi Data PKL</h1>

    @if(session('error'))
    <div class="alert alert-danger mt-2">
        {{ session('error') }}
    </div>
@endif


    <form action="{{ route('ver_pkl.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="mahasiswa_id">Mahasiswa</label>
            <select name="mahasiswa_id" class="form-control" required disabled>
                <option value="{{ $mahasiswa->id_mahasiswa }}" selected>
                    {{ $mahasiswa->nama }}
                </option>
            </select>
            <input type="hidden" name="mahasiswa_id" value="{{ $mahasiswa->id_mahasiswa }}">
            @error('mahasiswa_id')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>


        <div class="form-group">
            <label for="nilai_industri">Nilai Industri</label>
            <input type="file" class="form-control" name="nilai_industri" required>
            @error('nilai_industri')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="laporan_pkl">Laporan PKL</label>
            <input type="file" class="form-control" name="laporan_pkl" accept=".pdf,.doc,.docx,.xls,.xlsx" required>
            <small class="form-text text-muted">Allowed formats: PDF, DOC, DOCX, XLS, XLSX</small>
            @error('laporan_pkl')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Status</label><br>
            <div class="form-check form-check-inline">
                <input type="radio" id="status_belum" name="status" value="0" class="form-check-input" {{ old('status', 0) == '0' ? 'checked' : '' }}>
                <label class="form-check-label" for="status_belum">Belum Diverifikasi</label>
            </div>
            <div class="form-check form-check-inline">
                <input type="radio" id="status_diverifikasi" name="status" value="1" class="form-check-input" {{ old('status') == '1' ? 'checked' : '' }}>
                <label class="form-check-label" for="status_diverifikasi">Diverifikasi</label>
            </div>
            @error('status')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>


        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
