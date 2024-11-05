@extends('admin.layout.main')

@section('content')
<div class="container">
    <h2>Tambah Jabatan</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('jabatan_pimpinan.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="jabatan_pimpinan">Jabatan Pimpinan</label>
            <input type="text" name="jabatan_pimpinan" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="kode_jabatan_pimpinan">Kode Jabatan Pimpinan</label>
            <input type="text" name="kode_jabatan_pimpinan" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="status_jabatan_pimpinan">Status</label>
            <div>
                <div class="form-check">
                    <input type="radio" id="aktif" name="status_jabatan_pimpinan" value="1" class="form-check-input" required>
                    <label for="aktif" class="form-check-label">Aktif</label>
                </div>
                <div class="form-check">
                    <input type="radio" id="tidak_aktif" name="status_jabatan_pimpinan" value="0" class="form-check-input" required>
                    <label for="tidak_aktif" class="form-check-label">Tidak Aktif</label>
                </div>
            </div>
        </div>


        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
