@extends('admin.layout.main')

@section('content')
    <div class="container mt-4">

        <h2 class="card-title mb-4">Daftar Dosen</h2>
        <a href="{{ route('dosen.create') }}" class="btn btn-primary mb-3">Tambah Dosen</a>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show text-white" role="alert">
                <strong>Berhasil!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger text-white">
                {{ session('error') }}
            </div>
        @endif

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Daftar Dosen</h5>
                <div class="d-flex">

                    <a href="{{ route('dosen.export') }}" class="btn btn-success me-1">Export</a>
                    <a href="#" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#importModal">Import</a>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="dataTable" class="table table-striped text-center" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Dosen</th>
                                <th>NIDN</th>
                                <th>Gender</th>
                                <th>Jurusan</th>
                                <th>Golongan</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($dosen as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->nama_dosen }}</td>
                                    <td>{{ $item->nidn }}</td>
                                    <td>{{ ucfirst($item->gender == '1' ? 'Laki-laki' : 'Perempuan') }}</td>
                                    <td>{{ optional($item->jurusan)->nama_jurusan ?? 'N/A' }}</td>
                                    <td>
                                        @switch($item->golongan)
                                            @case('1')
                                                Assisten Ahli
                                                @break
                                            @case('2')
                                                Lector
                                                @break
                                            @case('3')
                                                Lector Kepala
                                                @break
                                            @case('4')
                                                Guru Besar
                                                @break
                                            @default
                                                Tidak Dikenal
                                        @endswitch
                                    </td>
                                    <td>{{ $item->status_dosen == '1' ? 'Aktif' : 'Tidak Aktif' }}</td>
                                    <td>
                                        <a href="{{ route('dosen.edit', $item->id_dosen) }}"
                                            class="btn btn-primary btn-sm">Edit</a>
                                        <form action="{{ route('dosen.destroy', $item->id_dosen) }}" method="POST"
                                            class="delete-form d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-delete btn-sm">Hapus</button>
                                        </form>
                                        <a href="{{ route('dosen.show', $item->id_dosen) }}"
                                            class="btn btn-info btn-sm">Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Import -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Import Dosen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('dosen.import') }}" method="POST" enctype="multipart/form-data" id="importForm">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="file">Pilih file CSV:</label>
                        <input type="file" name="file" class="form-control" required accept=".csv">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" form="importForm">Import</button>
            </div>
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

        document.getElementById('cancelButton').addEventListener('click', function() {
            const modal = bootstrap.Modal.getInstance(document.getElementById('confirmDeleteModal'));
            modal.hide(); // Menyembunyikan modal saat dibatalkan
        });
    </script>
@endsection
