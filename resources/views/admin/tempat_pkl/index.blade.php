@extends('admin.layout.main')

@section('content')
<div class="container mt-4">
    <h2>Daftar Tempat PKL</h2>
    <a href="{{ route('tempat_pkl.create') }}" class="btn btn-primary mb-3">Tambah Tempat PKL</a>

    @if(session('success'))
        <div class="alert alert-success mt-3 text-white">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Daftar Tempat PKL</h5>
        </div>
        <div class="card-body">
            <table id="dataTable" class="table table-striped table-bordered text-center">
                <thead>
                    <tr>
                        <th>Nama Perusahaan</th>
                        <th>Alamat</th>
                        <th>Kuota</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tempatPKL as $tempat)
                    <tr>
                        <td>{{ $tempat->nama_perusahaan }}</td>
                        <td>{{ $tempat->deskripsi }}</td>
                        <td>{{ $tempat->kuota }}</td>
                        <td>{{ $tempat->status == '1' ? 'Aktif' : 'Tidak Aktif' }}</td>
                        <td>
                            <a href="{{ route('tempat_pkl.edit', $tempat->id_perusahaan) }}" class="btn btn-primary btn-sm">Edit</a>
                            <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="{{ $tempat->id_perusahaan }}">Hapus</button>
                            <form action="{{ route('tempat_pkl.destroy', $tempat->id_perusahaan) }}" method="POST" class="delete-form d-none">
                                @csrf
                                @method('DELETE')
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
            deleteForm = this.nextElementSibling; // Mendapatkan form hapus
            const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
            modal.show(); // Tampilkan modal ketika tombol delete ditekan
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
