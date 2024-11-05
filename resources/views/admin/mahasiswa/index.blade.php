@extends('admin.layout.main')

@section('content')
<div class="container mt-4">
    <h2 class="card-title mb-2">Daftar Mahasiswa</h2>
    <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary mb-3">Tambah Mahasiswa</a>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show text-white" role="alert">
            <strong>Berhasil!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show text-white" role="alert">
            <strong>Kesalahan!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Daftar Mahasiswa</h5>
            <div>
                <a href="{{ route('mahasiswa.export.excel') }}" class="btn btn-success">Export</a>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#importModal">Import</button>
            </div>
        </div>
        <div class="card-body">
            <table id="dataTable" class="table table-striped text-center" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Mahasiswa</th>
                        <th>NIM</th>
                        <th class="text-center">Prodi</th>
                        <th>Gender</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($mahasiswa as $index => $mhs)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $mhs->nama }}</td>
                            <td>{{ $mhs->nim }}</td>
                            <td>{{ optional($mhs->prodi)->prodi ?? 'N/A' }}</td>
                            <td>{{ $mhs->gender == '1' ? 'Laki-laki' : 'Perempuan' }}</td>
                            <td>{{ $mhs->status_mahasiswa == '1' ? 'Aktif' : 'Tidak Aktif' }}</td>
                            <td>
                                <a href="{{ route('mahasiswa.edit', $mhs->id_mahasiswa) }}" class="btn btn-primary">Edit</a>
                                <form action="{{ route('mahasiswa.destroy', $mhs->id_mahasiswa) }}" method="POST" class="delete-form" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-delete">Hapus</button>
                                </form>
                                <a href="{{ route('mahasiswa.show', $mhs->id_mahasiswa) }}" class="btn btn-info">Detail</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Import Mahasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('mahasiswa.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="file" class="form-label">Upload Excel File</label>
                        <input type="file" name="file" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </form>
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
                Apakah Anda yakin ingin menghapus data ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Hapus</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#dataTable').DataTable();
});

let deleteForm;

document.querySelectorAll('.btn-delete').forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault();
        deleteForm = this.closest('form'); // Menyimpan form penghapusan yang sedang aktif
        const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
        modal.show();
    });
});

document.getElementById('confirmDeleteButton').addEventListener('click', function() {
    if (deleteForm) {
        deleteForm.submit(); // Submit form setelah konfirmasi
    }
});
</script>
@endsection
