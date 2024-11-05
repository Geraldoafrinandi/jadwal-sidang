@extends('admin.layout.main')

@section('content')
    <div class="container mt-4">
        <h1>Data Verifikasi PKL</h1>
        <a href="{{ route('ver_pkl.create') }}" class="btn btn-primary mb-3">Tambah Data</a>

        @if (session('success'))
            <div class="alert alert-success mt-3 text-white">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Data Verifikasi PKL</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered text-center" id="dataTable">
                    <thead>
                        <tr>
                            <th>Nama Mahasiswa</th>
                            <th>Nilai Industri</th>
                            <th>Laporan PKL</th>
                            <th>Status</th>
                            @if (Auth::check() && (Auth::user()->role == 'dosen' || Auth::user()->role == 'admin'))
                                <th>Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ver_pkl as $item)
                            <tr>
                                <td>{{ $item->mahasiswa->nama }}</td>

                                <td>
                                    <a href="{{ asset('storage/nilai_industri/' . $item->nilai_industri) }}"
                                        class="btn btn-link" download>
                                        Download Nilai Industri
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ asset('storage/laporan_pkl/' . $item->laporan_pkl) }}" class="btn btn-link"
                                        download>
                                        Download Laporan PKL
                                    </a>
                                </td>

                                <td style="color: {{ $item->status == '1' ? 'green' : 'red' }};">
                                    {{ $item->status == '1' ? 'Diverifikasi' : 'Belum Diverifikasi' }}

                                </td>

                                @if (Auth::check() && (Auth::user()->role == 'dosen' || Auth::user()->role == 'admin'))
                                    <td>
                                        <a href="{{ route('ver_pkl.edit', $item->id_ver_pkl) }}"
                                            class="btn btn-primary btn-sm">Edit</a>
                                        <button type="button" class="btn btn-danger btn-sm btn-delete"
                                            data-id="{{ $item->id_ver_pkl }}">Hapus</button>
                                        <form action="{{ route('ver_pkl.destroy', $item->id_ver_pkl) }}" method="POST"
                                            class="delete-form d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        @if ($item->status == '0')
                                            <form action="{{ route('ver_pkl.confirm', $item->id_ver_pkl) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">Konfirmasi</button>
                                            </form>
                                        @endif
                                    </td>
                                @endif
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
                deleteForm = this.nextElementSibling; // Mendapatkan form hapus
                const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
                modal.show();
            });
        });

        document.getElementById('confirmDeleteButton').addEventListener('click', function() {
            if (deleteForm) {
                deleteForm.submit();
            }
        });

        document.getElementById('cancelButton').addEventListener('click', function() {
            const modal = bootstrap.Modal.getInstance(document.getElementById('confirmDeleteModal'));
            modal.hide();
        });
    </script>
@endsection
