@extends('admin.layout.main')

@section('content')
<div class="container">
    <h1>Edit Tempat PKL</h1>

    <form action="{{ route('tempat_pkl.update', $tempatPkl->id_perusahaan) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nama_perusahaan">Nama Perusahaan</label>
            <input type="text" name="nama_perusahaan" class="form-control" value="{{ $tempatPkl->nama_perusahaan }}" required>
        </div>

        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" required>{{ $tempatPkl->deskripsi }}</textarea>
        </div>

        <div class="form-group">
            <label for="kuota">Kuota</label>
            <input type="number" name="kuota" class="form-control" value="{{ $tempatPkl->kuota }}" min="1" required>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" class="form-control" required>
                <option value="1" {{ $tempatPkl->status == '1' ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ $tempatPkl->status == '0' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>
@endsection
