@extends('admin.layout.main')

@section('content')
<div class="container">
    <h1>Create New Sesi</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('sesi.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="sesi">Sesi</label>
            <input type="text" name="sesi" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="jam">Jam</label>
            <input type="text" name="jam" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
