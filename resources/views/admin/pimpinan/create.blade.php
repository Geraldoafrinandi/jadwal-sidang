@extends('admin.layout.main')

@section('content')
<div class="container">
    <h2>Tambah Pimpinan</h2>
    <form action="{{ route('pimpinan.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="dosen_id">Dosen</label>
            <select name="dosen_id" id="dosen_id" class="form-control" required>
                <option value="">Pilih Dosen</option>
                @foreach ($dosen as $item)
                    <option value="{{ $item->id_dosen }}">{{ $item->nama_dosen }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="jabatan_pimpinan_id">Jabatan Pimpinan</label>
            <select name="jabatan_pimpinan_id" id="jabatan_pimpinan_id" class="form-control" required>
                <option value="">Pilih Jabatan</option>
                @foreach ($jabatan as $item)
                    <option value="{{ $item->id_jabatan_pimpinan }}">{{ $item->jabatan_pimpinan }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="periode">Periode</label>
            <input type="text" name="periode" id="periode" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>
@endsection
