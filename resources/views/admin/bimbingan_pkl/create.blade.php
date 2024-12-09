@extends('admin.layout.main')

@section('content')
    <h3>Tambah Bimbingan PKL</h3>

    <form action="{{ route('bimbingan_pkl.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="pkl_id" value="{{ old('pkl_id', $pkl_id) }}">



        <div class="form-group me-3">
            <label for="kegiatan">Kegiatan</label>
            <textarea name="kegiatan" id="kegiatan" class="form-control"></textarea>
        </div>
        <div class="form-group me-3">
            <label for="tgl_kegiatan_awal">Tanggal Awal</label>
            <input type="date" name="tgl_kegiatan_awal" id="tgl_kegiatan_awal" class="form-control">
        </div>
        <div class="form-group me-3">
            <label for="tgl_kegiatan_akhir">Tanggal Akhir</label>
            <input type="date" name="tgl_kegiatan_akhir" id="tgl_kegiatan_akhir" class="form-control">
        </div>
        <div class="form-group me-3">
            <label for="file_dokumentasi">File Dokumentasi</label>
            <input type="file" name="file_dokumentasi" id="file_dokumentasi" class="form-control">
        </div>
        {{-- <div class="form-group me-3">
            <label for="komentar">Komentar</label>
            <textarea name="komentar" id="komentar" class="form-control"></textarea>
        </div> --}}
        <div class="form-group me-3">
            <input type="hidden" name="status" value="0">
        </div>
        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
    </form>
@endsection
