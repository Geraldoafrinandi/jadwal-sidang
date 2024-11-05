@extends('admin.layout.main')

@section('content')
    <div class="container mt-4">

        <h2 class="mb-2">Sesi</h2>
        <a href="{{ route('sesi.create') }}" class="btn btn-primary">Tambah Sesi</a>

        <div class="card">
            <div class="card-header">
                <!-- Header bisa ditambahkan jika diperlukan -->
            </div>

            <div class="card-body">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success mt-3 text-white">
                        {{ $message }}
                    </div>
                @endif

                <table class="table table-bordered mt-3 text-center">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Sesi</th>
                            <th>Jam</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($sesi as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->sesi }}</td>
                                <td>{{ $item->jam }}</td>
                                <td>
                                    <a href="{{ route('sesi.edit', $item->id_sesi) }}" class="btn btn-primary btn-sm">Edit</a>
                                    <form action="{{ route('sesi.destroy', $item->id_sesi) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
