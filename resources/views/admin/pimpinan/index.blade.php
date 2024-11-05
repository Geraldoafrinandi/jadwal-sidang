@extends('admin.layout.main')

@section('content')
    <div class="container mt-4">
        <h2>Pimpinan </h2>
        <a href="{{ route('pimpinan.create') }}" class="btn btn-primary mb-3">Tambah Pimpinan</a>

        @if (session('success'))
            <div class="alert alert-success text-white">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Daftar Pimpinan</h5>
                <a href="{{ route('pimpinan.export') }}" class="btn btn-success">Export</a>
            </div>
            <div class="card-body">
                <table class="table table-bordered mt-3 text-center">
                    <thead>
                        <tr>

                            <th>Dosen</th>
                            <th>Jabatan</th>
                            <th>Periode</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($pimpinan as $item)
                            <tr>

                                <td>{{ $item->dosen->nama_dosen }}</td>
                                <td>{{ $item->jabatanPimpinan->jabatan_pimpinan }}</td>
                                <td>{{ $item->periode }}</td>
                                <td>
                                    <a href="{{ route('pimpinan.edit', $item->id_pimpinan) }}"
                                        class="btn btn-primary">Edit</a>
                                    <button type="button" class="btn btn-danger btn-delete"
                                        data-id="{{ $item->id_pimpinan }}"
                                        data-nama="{{ $item->nama_pimpinan }}">Hapus</button>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus pimpinan <span id="pimpinanName"></span>?
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
        let deleteForm;

        // Tangkap semua tombol delete dan tambahkan event listener
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const id = this.getAttribute('data-id');
                const nama = this.getAttribute('data-nama');
                document.getElementById('pimpinanName').innerText = nama; // Set nama pimpinan di modal
                deleteForm = document.getElementById('deleteForm');
                deleteForm.action = '/pimpinan/' + id; // Set action untuk form delete
                const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
                modal.show(); // Show modal ketika tombol delete ditekan
            });
        });
    </script>
@endsection
