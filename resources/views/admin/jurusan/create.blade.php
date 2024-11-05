@extends('admin.layout.main')

@section('content')
<div class="container">
    <h1>Create New Jurusan</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('jurusan.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="kode_jurusan">Kode Jurusan</label>
            <input type="text" name="kode_jurusan" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="nama_jurusan">Nama Jurusan</label>
            <input type="text" name="nama_jurusan" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
