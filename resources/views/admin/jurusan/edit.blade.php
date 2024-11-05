@extends('admin.layout.main')

@section('content')
<div class="container">
    <h1>Edit Jurusan</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('jurusan.update', $jurusan->id_jurusan) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="kode_jurusan">Kode Jurusan</label>
            <input type="text" name="kode_jurusan" class="form-control" value="{{ $jurusan->kode_jurusan }}" required>
        </div>

        <div class="form-group">
            <label for="nama_jurusan">Nama Jurusan</label>
            <input type="text" name="nama_jurusan" class="form-control" value="{{ $jurusan->nama_jurusan }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
