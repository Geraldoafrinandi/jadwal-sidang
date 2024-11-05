@extends('admin.layout.main')

@section('content')
    <div class="container mt-4">

        <h2 class="mb-2">Prodi</h2>
                <a href="{{ route('prodi.create') }}" class="btn btn-primary">Tambah Prodi</a>
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Daftar Prodi</h4>
                <a href="{{ route('prodi.export') }}" class="btn btn-success">Export</a>

            </div>

            <div class="card-body">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success mt-3 text-white">
                        {{ $message }}
                    </div>
                @endif

                <table id="dataTable" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Prodi</th>
                            <th>Prodi</th>
                            <th>Jenjang</th>
                            <th>Jurusan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($prodi as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->kode_prodi }}</td>
                                <td>{{ $item->prodi }}</td>
                                <td>{{ $item->jenjang }}</td>
                                <td>{{ $item->jurusan->nama_jurusan }}</td>
                                <td>
                                    <a href="{{ route('prodi.edit', $item->id_prodi) }}" class="btn btn-primary btn-sm">Edit</a>
                                    <form action="{{ route('prodi.destroy', $item->id_prodi) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm btn-delete">Delete</button>
                                    </form>
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
                Apakah Anda yakin ingin menghapus data ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="cancelButton">Batal</button>
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

    // Tangkap semua tombol delete dan tambahkan event listener
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            deleteForm = this.closest('form'); // Menyimpan form yang akan di-submit
            const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
            modal.show(); // Show modal ketika tombol delete ditekan
        });
    });

    // Konfirmasi delete ketika tombol hapus di modal ditekan
    document.getElementById('confirmDeleteButton').addEventListener('click', function() {
        if (deleteForm) {
            deleteForm.submit(); // Submit form setelah konfirmasi
        }
    });

    // Aksi ketika tombol batal ditekan
    document.getElementById('cancelButton').addEventListener('click', function() {
        const modal = bootstrap.Modal.getInstance(document.getElementById('confirmDeleteModal'));
        modal.hide(); // Tutup modal ketika tombol batal ditekan
    });
</script>
@endsection
