@extends('admin.layout.main')

@section('content')
<div class="container mt-4">
    <h2 class="mb-2">Jurusan</h2>
    <a href="{{ route('jurusan.create') }}" class="btn btn-primary">Tambah Jurusan Baru</a>

    <div class="card">
        <div class="card-header"></div>

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
                        <th>Kode Jurusan</th>
                        <th>Nama Jurusan</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jurusan as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td> <!-- Mengubah angka untuk No -->
                            <td>{{ $item->kode_jurusan }}</td>
                            <td class="jurusan-name">{{ $item->nama_jurusan }}</td> <!-- Menambahkan class untuk memudahkan seleksi -->
                            <td>
                                <a href="{{ route('jurusan.edit', $item->id_jurusan) }}" class="btn btn-primary btn-sm">Edit</a>
                                <form action="{{ route('jurusan.destroy', $item->id_jurusan) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm btn-delete">Hapus</button>
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
                Apakah Anda yakin ingin menghapus data jurusan <b> <span id="jurusanName"></b></span>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Hapus</button>
            </div>
        </div>
    </div>
</div>

<script>
    let deleteForm;
    let jurusanName;

    // Tangkap semua tombol delete dan tambahkan event listener
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            deleteForm = this.closest('form'); // Menyimpan form yang akan di-submit
            jurusanName = this.closest('tr').querySelector('.jurusan-name').innerText; // Mendapatkan nama jurusan dari kolom tabel
            document.getElementById('jurusanName').innerText = jurusanName; // Set nama jurusan di modal
            const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal')); // Tampilkan modal
            modal.show(); // Show modal ketika tombol delete ditekan
        });
    });

    // Konfirmasi delete ketika tombol hapus di modal ditekan
    document.getElementById('confirmDeleteButton').addEventListener('click', function() {
        if (deleteForm) {
            deleteForm.submit(); // Submit form setelah konfirmasi
        }
    });
</script>

@endsection
