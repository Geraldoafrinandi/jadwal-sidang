@extends('admin.layout.main')

@section('content')
<div class="container">
    <h1>Edit Jabatan Pimpinan</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('jabatan_pimpinan.update', $jabatanPimpinan->id_jabatan_pimpinan) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="jabatan_pimpinan">Jabatan Pimpinan</label>
            <input type="text" name="jabatan_pimpinan" class="form-control" value="{{ $jabatanPimpinan->jabatan_pimpinan }}" required>
        </div>

        <div class="form-group">
            <label for="kode_jabatan_pimpinan">Kode Jabatan Pimpinan</label>
            <input type="text" name="kode_jabatan_pimpinan" class="form-control" value="{{ $jabatanPimpinan->kode_jabatan_pimpinan }}" required>
        </div>

        <div class="form-group">
            <label for="status_jabatan_pimpinan">Status</label>
            <div>
                <div class="form-check">
                    <input type="radio" id="aktif" name="status_jabatan_pimpinan" value="1" class="form-check-input"
                        {{ $jabatanPimpinan->status_jabatan_pimpinan == 1 ? 'checked' : '' }} required>
                    <label for="aktif" class="form-check-label">Aktif</label>
                </div>
                <div class="form-check">
                    <input type="radio" id="tidak_aktif" name="status_jabatan_pimpinan" value="0" class="form-check-input"
                        {{ $jabatanPimpinan->status_jabatan_pimpinan == 0 ? 'checked' : '' }} required>
                    <label for="tidak_aktif" class="form-check-label">Tidak Aktif</label>
                </div>
            </div>
        </div>


        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
