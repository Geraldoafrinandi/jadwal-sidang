@extends('admin.layout.main')

@section('content')
<div class="container mt-3">

    <h2 class="mb-2">Ruangan</h2>
    <a href="{{ route('ruangan.create') }}" class="btn btn-primary">Tambah Ruangan</a>

    <div class="card">
        <div class="card-header">
            <h4 class="">Daftar Ruangan</h4>
        </div>

        <div class="card-body">
            @if ($message = Session::get('success'))
                <div class="alert alert-success mt-3 text-white">
                    {{ $message }}
                </div>
            @endif

            <table class="table table-bordered text-center">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Ruangan</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($ruangan as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->ruangan }}</td>
                            <td>
                                <a href="{{ route('ruangan.edit', $item->id_ruangan) }}" class="btn btn-primary btn-sm">Edit</a>
                                <button class="btn btn-danger btn-sm btn-delete" data-id="{{ $item->id_ruangan }}" data-nama="{{ $item->ruangan }}">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus ruangan <span id="ruanganName"></span>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" action="" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const nama = this.getAttribute('data-nama');
            document.getElementById('ruanganName').innerText = nama; // Set nama ruangan di modal
            const deleteForm = document.getElementById('deleteForm');
            deleteForm.action = '/ruangan/' + id; // Set action untuk form delete

            const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
            modal.show(); // Show modal ketika tombol delete ditekan
        });
    });
</script>

@endsection
