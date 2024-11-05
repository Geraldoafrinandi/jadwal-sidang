@extends('admin.layout.main')

@section('content')
<div class="container">
    <h1>Edit Sesi</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('sesi.update', $sesi->id_sesi) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="sesi">Sesi</label>
            <input type="text" name="sesi" class="form-control" value="{{ $sesi->sesi }}" required>
        </div>

        <div class="form-group">
            <label for="jam">Jam</label>
            <input type="text" name="jam" class="form-control" value="{{ $sesi->jam }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
