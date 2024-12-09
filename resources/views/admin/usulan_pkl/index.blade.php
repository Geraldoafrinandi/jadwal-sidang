@extends('admin.layout.main')

@section('content')
    <div class="container mt-4 mb-3">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3 text-white" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Notifikasi Pendaftaran Mahasiswa -->
        @if (Auth::check() && Auth::user()->role == 'mahasiswa')
            @if ($hasRegistered && $registeredCompanyName)
                @if ($konfirmasiStatus == 1)
                    <div class="alert alert-success mt-3 text-white">
                        <h5>Selamat!</h5>
                        Pendaftaran Anda di tempat PKL: <strong>{{ $registeredCompanyName }}</strong> sudah terdaftar.
                        Anda bisa melanjutkan proses PKL.
                    </div>
                @else
                    <div class="alert alert-warning mt-3 text-white">
                        <h5>Notifikasi</h5>
                        Anda sudah mendaftar untuk PKL di tempat: <strong>{{ $registeredCompanyName }}</strong>, namun
                        <strong>menunggu konfirmasi dari admin</strong> .
                    </div>
                @endif
            @else
                <div class="alert alert-info mt-3 text-white">
                    <h5>Informasi</h5>
                    Anda belum mendaftar untuk PKL. Silakan pilih tempat PKL untuk melanjutkan.
                </div>
            @endif
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
                                                <button type="submit" class="btn btn-success btn-sm">Konfirmasi</button>
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

        <!-- Daftar Tempat PKL untuk Mahasiswa dan Dosen -->
        @if (Auth::check() && (Auth::user()->role == 'dosen' || Auth::user()->role == 'mahasiswa'))
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title">Daftar Tempat PKL dan Pendaftar</h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered text-center">
                        <thead>
                            <tr>
                                <th>Nama Tempat PKL</th>
                                <th>Deskripsi</th>
                                <th>Kuota</th>
                                <th>Kuota Tersedia</th>
                                <th>Nama Mahasiswa yang Mendaftar</th>
                                @if (Auth::user()->role == 'mahasiswa')
                                    <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tempatPKL as $tempatItem)
                                <tr>
                                    <td>{{ $tempatItem->nama_perusahaan }}</td>
                                    <td>{{ $tempatItem->deskripsi }}</td>
                                    <td>{{ $tempatItem->kuota }}</td>
                                    <td>{{ $tempatItem->kuota - $tempatItem->usulanPKL->count() }}</td>
                                    <td>
                                        @foreach ($tempatItem->usulanPKL->where('konfirmasi', 1) as $usulan)
                                            {{ $usulan->mahasiswa->nama }}@if (!$loop->last)
                                                <br>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @if (Auth::user()->role == 'mahasiswa')
                                            @php
                                                // Cek apakah mahasiswa sudah terdaftar di tempat PKL ini
                                                $hasRegistered = $tempatItem->usulanPKL
                                                    ? $tempatItem->usulanPKL
                                                            ->where(
                                                                'mahasiswa_id',
                                                                auth()->user()->mahasiswa->id_mahasiswa,
                                                            )
                                                            ->count() > 0
                                                    : false;

                                                // Cek apakah kuota tempat PKL masih tersedia
                                                $isAvailable = $tempatItem->kuota > $tempatItem->usulanPKL->count();
                                            @endphp

                                            @if ($hasRegisteredAnywhere)
                                                <!-- Jika mahasiswa sudah terdaftar di tempat PKL lain, tombol di tempat lain akan disabled -->
                                                <button type="button" class="btn btn-secondary btn-sm text-white"
                                                    disabled>Daftar</button>
                                            @elseif ($isAvailable)
                                                @if (!$hasRegistered)
                                                    <!-- Form pendaftaran jika kuota tersedia dan mahasiswa belum mendaftar di tempat PKL ini -->
                                                    <form action="{{ route('usulan_pkl.store') }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="mahasiswa_id"
                                                            value="{{ auth()->user()->mahasiswa->id_mahasiswa }}">
                                                        <input type="hidden" name="perusahaan_id"
                                                            value="{{ $tempatItem->id_perusahaan }}">
                                                        <button type="submit"
                                                            class="btn btn-success btn-sm text-white">Daftar</button>
                                                    </form>
                                                @else
                                                    <!-- Jika mahasiswa sudah mendaftar di tempat PKL ini, tombol disabled -->
                                                    <button type="button" class="btn btn-secondary btn-sm text-white"
                                                        disabled>Daftar</button>
                                                @endif
                                            @else
                                                <!-- Pesan kuota penuh -->
                                                <span class="text-muted">Kuota Penuh</span>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <!-- Daftar Mahasiswa, Perusahaan, dan Dosen Pembimbing -->
        <div class="mt-4">
            <div class="card">
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
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($usulanPKL as $usulan)
                                <tr>
                                    <td>{{ $usulan->mahasiswa->nama ?? 'No Data' }}</td>
                                    <td>{{ $usulan->tempatPKL->nama_perusahaan ?? 'No Data' }}</td>
                                    <td>{{ $usulan->mhsPkl->dosenPembimbing->nama_dosen ?? 'No Data' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus mahasiswa <span id="mahasiswaName"></span>?
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

@endsection

@section('scripts')
    <script>
        const deleteModal = document.getElementById('deleteModal');
        const mahasiswaNameElement = deleteModal.querySelector('#mahasiswaName');
        const deleteForm = deleteModal.querySelector('#deleteForm');

        deleteModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const mahasiswaName = button.getAttribute('data-name');
            const mahasiswaId = button.getAttribute('data-id');
            mahasiswaNameElement.textContent = mahasiswaName;

            // Set form action to delete the correct mahasiswa
            deleteForm.action = '/usulan_pkl/' + mahasiswaId;
        });
    </script>
@endsection
