@extends('admin.layout.main')

@section('content')
<div class="container">
    <h1>Tambah Tempat PKL</h1>

    <form action="{{ route('tempat_pkl.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nama_perusahaan">Nama Perusahaan</label>
            <input type="text" name="nama_perusahaan" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" required></textarea>
        </div>

        <div class="form-group">
            <label for="kuota">Kuota</label>
            <input type="number" name="kuota" class="form-control" value="4" min="1" required>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <div>
                <div class="form-check form-check-inline">
                    <input type="radio" name="status" id="statusAktif" value="1" class="form-check-input" required>
                    <label class="form-check-label" for="statusAktif">Aktif</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" name="status" id="statusTidakAktif" value="0" class="form-check-input" required>
                    <label class="form-check-label" for="statusTidakAktif">Tidak Aktif</label>
                </div>
            </div>
        </div>


        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
