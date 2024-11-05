@extends('admin.layout.main')

@section('content')
<div class="container">
    <h1>Buat Prodi</h1>

    @if ($errors->any())
        <div class="alert alert-danger text-white">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('prodi.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="kode_prodi">Kode Prodi</label>
            <input type="text" name="kode_prodi" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="prodi">Prodi</label>
            <input type="text" name="prodi" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="jenjang">Jenjang</label>
            <select name="jenjang" class="form-control" required>
                <option value="">-- Pilih Jenjang --</option>
                <option value="D4">D4</option>
                <option value="D3">D3</option>
                <option value="D2">D2</option>
            </select>
        </div>


        <div class="form-group">
            <label for="jurusan_id">Jurusan</label>
            <select name="jurusan_id" class="form-control" required>
                <option value="">Pilih Prodi</option>
                @foreach ($jurusan as $item)
                    <option value="{{ $item->id_jurusan }}">{{ $item->nama_jurusan }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
