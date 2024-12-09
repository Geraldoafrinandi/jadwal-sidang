@extends('admin.layout.main')

@section('content')
    <!-- Daftar Mahasiswa, Perusahaan, dan Dosen Pembimbing -->
    <div class="mt-4">
        <div class="card">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mt-3 text-white" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show mt-3 text-white" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif



            <!-- Daftar Usulan PKL (admin atau dosen) -->
            @if (Auth::check() && (Auth::user()->role == 'dosen' || Auth::user()->role == 'admin'))
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Daftar Usulan PKL</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered text-center" id="dataTable">
                            <thead>
                                <tr>
                                    <th>Nama Mahasiswa</th>
                                    <th>Nama Tempat PKL</th>
                                    <th>Konfirmasi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($usulanPKL as $usulan)
                                    <tr>
                                        <td>{{ $usulan->mahasiswa->nama }}</td>
                                        <td>{{ $usulan->tempatPKL->nama_perusahaan }}</td>
                                        <td>
                                            @if ($usulan->konfirmasi == '1')
                                                <span class="badge bg-success mt-1">Sudah</span>
                                            @else
                                                <span class="badge bg-danger mt-1">Belum</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('usulan_pkl.edit', $usulan->id_usulan_pkl) }}"
                                                class="btn btn-primary btn-sm">Edit</a>

                                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal" data-id="{{ $usulan->id_usulan_pkl }}"
                                                data-name="{{ $usulan->mahasiswa->nama }}">
                                                Hapus
                                            </button>

                                            @if ($usulan->konfirmasi == '0')
                                                <form action="{{ route('usulan_pkl.konfirmasi', $usulan->id_usulan_pkl) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="konfirmasi" value="1" id="konfirmasi">
                                                    <button type="submit"
                                                        class="btn btn-success btn-sm">Konfirmasi</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
            <div class="card-header">
                <h5 class="card-title">Daftar Mahasiswa, Perusahaan, dan Dosen Pembimbing</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered text-center" id="dataTable">
                    <thead>
                        <tr>
                            <th>Nama Mahasiswa</th>
                            <th>Nama Perusahaan</th>
                            <th>Nama Dosen Pembimbing</th>
                            @if (Auth::check() && (Auth::user()->role == 'dosen' || Auth::user()->role == 'admin'))
                                <th>Keterangan</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($usulanPKL as $usulan)
                            <tr>
                                <td>{{ $usulan->mahasiswa->nama ?? 'No Data' }}</td>
                                <td>{{ $usulan->tempatPKL->nama_perusahaan ?? 'No Data' }}</td>
                                <td>{{ $usulan->mhsPkl->dosenPembimbing->nama_dosen ?? 'Tidak ada data dosen' }}</td>

                                @if (Auth::check() && (Auth::user()->role == 'dosen' || Auth::user()->role == 'admin'))
                                    <td>
                                        <!-- Cek jika status konfirmasi sudah 1 (terkonfirmasi) dan dosen pembimbing belum ditetapkan -->
                                        @if ($usulan->konfirmasi == 1 && !$usulan->dosen_pembimbing)
                                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#pilihDosenModal{{ $usulan->id_usulan_pkl }}"
                                                data-usulan-id="{{ $usulan->id_usulan_pkl }}">
                                                Pilih Dosen
                                            </button>
                                        @elseif ($usulan->dosen_pembimbing)
                                            <span class="text-success">Dosen sudah ditetapkan</span>
                                        @else
                                            <span class="text-warning">Data belum terkonfirmasi</span>
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
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus data <strong id="mahasiswaName"></strong>?</p>
                </div>
                <div class="modal-footer">
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal for selecting Dosen Pembimbing -->
    @foreach ($usulanPKL as $usulanPklItem)
        <div class="modal fade" id="pilihDosenModal{{ $usulanPklItem->id_usulan_pkl }}" tabindex="-1"
            aria-labelledby="pilihDosenModalLabel{{ $usulanPklItem->id_usulan_pkl }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="pilihDosenModalLabel{{ $usulanPklItem->id_usulan_pkl }}">
                            Pilih Dosen Pembimbing
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <!-- Form untuk memilih dosen pembimbing -->
                    <form
                        action="{{ route('konfirmasi_usulan_pkl.pilih_dosen', ['usulan_pkl' => $usulanPklItem->id_usulan_pkl]) }}"
                        method="POST">
                        @csrf

                        <!-- Input hidden untuk mahasiswa_id -->
                        <input type="hidden" name="mahasiswa_id" value="{{ $usulanPklItem->mahasiswa_id }}">

                        <div class="modal-body">
                            <div class="form-group">
                                <label for="dosen_pembimbing">Nama Dosen</label>
                                <select name="dosen_pembimbing" id="dosen_pembimbing{{ $usulanPklItem->id_usulan_pkl }}"
                                    class="form-control" required>
                                    <option value="">Pilih Dosen</option>
                                    @foreach ($dosens as $dosen)
                                        <option value="{{ $dosen->id_dosen }}"
                                            {{ old('dosen_pembimbing') == $dosen->id_dosen ? 'selected' : '' }}>
                                            {{ $dosen->nama_dosen }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <!-- Tahun PKL yang akan disembunyikan -->
                                <input type="hidden" name="tahun_pkl" value="{{ date('Y') }}">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach



    <script>
       document.addEventListener('DOMContentLoaded', function () {
    const deleteModal = document.getElementById('deleteModal');
    const mahasiswaNameElement = deleteModal.querySelector('#mahasiswaName');
    const deleteForm = deleteModal.querySelector('#deleteForm');

    deleteModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget; // Tombol yang membuka modal
        const mahasiswaName = button.getAttribute('data-name'); // Nama data dari tombol
        const mahasiswaId = button.getAttribute('data-id'); // ID data dari tombol

        // Update teks nama mahasiswa
        mahasiswaNameElement.textContent = mahasiswaName;

        // Atur action form untuk menghapus data
        deleteForm.action = `/usulan_pkl/${mahasiswaId}`;
    });
});

    </script>


@endsection
