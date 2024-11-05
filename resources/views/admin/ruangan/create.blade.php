@extends('admin.layout.main')

@section('content')
<div class="container">
    <h1>Create New Ruangan</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('ruangan.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="ruangan">Ruangan</label>
            <input type="text" name="ruangan" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
