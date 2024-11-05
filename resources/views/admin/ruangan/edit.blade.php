@extends('admin.layout.main')

@section('content')
<div class="container">
    <h1>Edit Ruangan</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('ruangan.update', $ruangan->id_ruangan) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="ruangan">Ruangan</label>
            <input type="text" name="ruangan" class="form-control" value="{{ $ruangan->ruangan }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
