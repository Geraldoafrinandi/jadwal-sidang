@extends('admin.layout.main')

@section('content')
<div class="container">
    <h1>Edit Prodi</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('prodi.update', $prodi->id_prodi) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="kode_prodi">Kode Prodi</label>
            <input type="text" name="kode_prodi" class="form-control" value="{{ $prodi->kode_prodi }}" required>
        </div>

        <div class="form-group">
            <label for="prodi">Prodi</label>
            <input type="text" name="prodi" class="form-control" value="{{ $prodi->prodi }}" required>
        </div>

        <div class="form-group">
            <label for="jenjang">Jenjang</label>
            <select name="jenjang" class="form-control" required>
                <option value="">-- Pilih Jenjang --</option>
                <option value="D4" {{ $prodi->jenjang == 'D4' ? 'selected' : '' }}>D4</option>
                <option value="D3" {{ $prodi->jenjang == 'D3' ? 'selected' : '' }}>D3</option>
                <option value="D2" {{ $prodi->jenjang == 'D2' ? 'selected' : '' }}>D2</option>
            </select>
        </div>



        <div class="form-group">
            <label for="jurusan_id">Jurusan</label>
            <select name="jurusan_id" class="form-control" required>
                @foreach ($jurusan as $item)
                    <option value="{{ $item->id_jurusan }}" {{ $prodi->jurusan_id == $item->id_jurusan ? 'selected' : '' }}>{{ $item->nama_jurusan }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
