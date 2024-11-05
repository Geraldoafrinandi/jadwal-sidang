@extends('admin.layout.main')

@section('content')
<div class="container mt-4">

    <h2>Jabatan Pimpinan</h2>
    <a href="{{ route('jabatan_pimpinan.create') }}" class="btn btn-primary mb-3">Tambah Jabatan Pimpinan</a>

    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-3 text-white">
            {{ $message }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Daftar Jabatan Pimpinan</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th>Jabatan Pimpinan</th>
                        <th>Kode Jabatan Pimpinan</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jabatanPimpinan as $item)
                        <tr>
                            <td>{{ $item->jabatan_pimpinan }}</td>
                            <td>{{ $item->kode_jabatan_pimpinan }}</td>
                            <td>{{ $item->status_jabatan_pimpinan == 1 ? 'Aktif' : 'Tidak Aktif' }}</td>
                            <td>
                                <a href="{{ route('jabatan_pimpinan.edit', $item->id_jabatan_pimpinan) }}" class="btn btn-primary">Edit</a>
                                <button class="btn btn-danger btn-delete" data-id="{{ $item->id_jabatan_pimpinan }}" data-nama="{{ $item->jabatan_pimpinan }}">Delete</button>
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
                Apakah Anda yakin ingin menghapus jabatan <span id="jabatanName"></span>?
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
            document.getElementById('jabatanName').innerText = nama; // Set nama jabatan di modal
            const deleteForm = document.getElementById('deleteForm');
            deleteForm.action = '/jabatan_pimpinan/' + id; // Set action untuk form delete

            const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
            modal.show(); // Show modal ketika tombol delete ditekan
        });
    });
</script>

@endsection
