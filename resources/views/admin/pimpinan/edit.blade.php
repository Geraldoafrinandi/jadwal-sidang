@extends('admin.layout.main')

@section('content')
<div class="container">
    <h2>Edit Pimpinan</h2>
    <form action="{{ route('pimpinan.update', $pimpinan->id_pimpinan) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="dosen_id">Dosen</label>
            <select name="dosen_id" id="dosen_id" class="form-control" required>
                @foreach ($dosen as $item)
                    <option value="{{ $item->id_dosen }}" {{ $item->id_dosen == $pimpinan->dosen_id ? 'selected' : '' }}>{{ $item->nama_dosen }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="jabatan_pimpinan_id">Jabatan Pimpinan</label>
            <select name="jabatan_pimpinan_id" id="jabatan_pimpinan_id" class="form-control" required>
                @foreach ($jabatan as $item)
                    <option value="{{ $item->id_jabatan_pimpinan }}" {{ $item->id_jabatan_pimpinan == $pimpinan->jabatan_pimpinan_id ? 'selected' : '' }}>{{ $item->jabatan_pimpinan }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="periode">Periode</label>
            <input type="text" name="periode" id="periode" class="form-control" value="{{ $pimpinan->periode }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
