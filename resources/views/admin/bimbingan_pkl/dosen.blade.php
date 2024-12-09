@extends('admin.layout.main')

@section('title', 'Daftar Mahasiswa Bimbingan PKL')


@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <h4 class="mb-4">Daftar Mahasiswa Bimbingan PKL</h4>

                <!-- Notifikasi -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show text-white" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Mahasiswa</th>
                                    <th>NIM</th>
                                    <th>Tempat Magang</th>
                                    <th>Logbook</th>
                                    <th>Nilai</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($mahasiswa as $key => $mhs)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $mhs->usulanPkl->mahasiswa->nama ?? 'Tidak ada data' }}</td>
                                        <td>{{ $mhs->usulanPkl->mahasiswa->nim ?? 'Tidak ada data' }}</td>
                                        <td>{{ $mhs->usulanPkl->tempatPKL->nama_perusahaan ?? 'Tidak ada data' }}</td>
                                        <td>
                                            <a href="{{ $mhs->bimbinganPkl->isNotEmpty() && $mhs->bimbinganPkl->first()->kegiatan ? route('bimbingan_pkl.logbook', $mhs->id_mhs_pkl) : '#' }}"
                                                class="btn btn-sm btn-info logbook-btn"
                                                @if ($mhs->bimbinganPkl->isEmpty() || !$mhs->bimbinganPkl->first()->kegiatan) disabled @endif>
                                                <i class="fas fa-book"></i> Logbook
                                            </a>
                                        </td>




                                        <td>

                                            @if (!$mhs->r_nilai_bimbingan || !$mhs->r_nilai_bimbingan->nilai_bimbingan)
                                                <!-- Jika belum ada nilai bimbingan atau relasi belum ada -->
                                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#nilaiModal{{ $mhs->id_mhs_pkl }}">
                                                    Nilai
                                                </button>
                                            @else
                                                <!-- Jika sudah ada nilai bimbingan -->
                                                <span class="badge bg-success">
                                                    {{ number_format($mhs->r_nilai_bimbingan->nilai_bimbingan, 2) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($mhs->r_nilai_pembimbing && $mhs->r_nilai_pembimbing->nilai_bimbingan)
                                                <!-- Tampilkan nilai -->
                                                <span class="badge bg-success">
                                                    {{ number_format($mhs->r_nilai_pembimbing->nilai_bimbingan, 2) }}
                                                </span>
                                                <!-- Tombol Edit -->
                                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#editNilaiModal{{ $mhs->id_mhs_pkl }}">
                                                    Edit Nilai
                                                </button>
                                            @else
                                                <!-- Jika belum ada nilai -->
                                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#editNilaiModal{{ $mhs->id_mhs_pkl }}">
                                                    Edit nilai
                                                </button>
                                            @endif
                                        </td>

                                        <!-- Modal Edit Nilai -->
                                        <div class="modal fade" id="editNilaiModal{{ $mhs->id_mhs_pkl }}" tabindex="-1"
                                            aria-labelledby="editNilaiModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('nilai_pembimbing.update', $mhs->id_mhs_pkl) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editNilaiModalLabel">Edit Nilai
                                                                Bimbingan</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="keaktifan-{{ $mhs->id_mhs_pkl }}"
                                                                    class="form-label">Keaktifan</label>
                                                                <input type="number" step="0.01" class="form-control"
                                                                    id="keaktifan-{{ $mhs->id_mhs_pkl }}" name="keaktifan"
                                                                    value="{{ $mhs->r_nilai_pembimbing->keaktifan ?? '' }}"
                                                                    required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="komunikatif-{{ $mhs->id_mhs_pkl }}"
                                                                    class="form-label">Komunikatif</label>
                                                                <input type="number" step="0.01" class="form-control"
                                                                    id="komunikatif-{{ $mhs->id_mhs_pkl }}"
                                                                    name="komunikatif"
                                                                    value="{{ $mhs->r_nilai_pembimbing->komunikatif ?? '' }}"
                                                                    required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="problem_solving-{{ $mhs->id_mhs_pkl }}"
                                                                    class="form-label">Problem Solving</label>
                                                                <input type="number" step="0.01" class="form-control"
                                                                    id="problem_solving-{{ $mhs->id_mhs_pkl }}"
                                                                    name="problem_solving"
                                                                    value="{{ $mhs->r_nilai_pembimbing->problem_solving ?? '' }}"
                                                                    required>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>







                                        <!-- Modal untuk Menambahkan Nilai -->
                                        <div class="modal fade" id="nilaiModal{{ $mhs->id_mhs_pkl }}" tabindex="-1"
                                            aria-labelledby="nilaiModalLabel{{ $mhs->id_mhs_pkl }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form
                                                    action="{{ route('bimbingan_pkl.update_nilai', ['id' => $mhs->id_mhs_pkl]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('POST')
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="nilaiModalLabel{{ $mhs->id_mhs_pkl }}">
                                                                Nilai Bimbingan PKL</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- Input Nilai Keaktifan -->

                                                            <div class="mb-3">
                                                                <label for="keaktifan" class="form-label">Nilai
                                                                    Keaktifan</label>
                                                                <input type="number" name="keaktifan" id="keaktifan"
                                                                    class="form-control" min="0" max="100"
                                                                    required
                                                                    value="{{ old('keaktifan', $mhs->keaktifan) }}">
                                                            </div>
                                                            <!-- Input Nilai Komunikatif -->
                                                            <div class="mb-3">
                                                                <label for="komunikatif" class="form-label">Nilai
                                                                    Komunikatif</label>
                                                                <input type="number" name="komunikatif" id="komunikatif"
                                                                    class="form-control" min="0" max="100"
                                                                    required
                                                                    value="{{ old('komunikatif', $mhs->komunikatif) }}">
                                                            </div>
                                                            <!-- Input Nilai Problem Solving -->
                                                            <div class="mb-3">
                                                                <label for="problem_solving" class="form-label">Nilai
                                                                    Problem
                                                                    Solving</label>
                                                                <input type="number" name="problem_solving"
                                                                    id="problem_solving" class="form-control"
                                                                    min="0" max="100" required
                                                                    value="{{ old('problem_solving', $mhs->problem_solving) }}">
                                                            </div>


                                                            <input type="hidden" name="mhs_pkl_id"
                                                                value="{{ $mhs->mhs_pkl_id }}">



                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit"
                                                                    class="btn btn-success">Simpan</button>
                                                            </div>
                                                        </div>
                                                </form>
                                            </div>
                                        </div>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada mahasiswa bimbingan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Cari semua tombol dengan class 'logbook-btn'
            const logbookButtons = document.querySelectorAll('.logbook-btn');

            // Menambahkan event listener untuk mouseover pada tombol logbook
            logbookButtons.forEach(button => {
                button.addEventListener('mouseover', function() {
                    // Jika logbook tidak tersedia (data-available = 'false')
                    if (button.getAttribute('data-available') === 'false') {
                        // Menambahkan class disabled dan menonaktifkan klik
                        button.classList.add('disabled');
                        button.style.pointerEvents = 'none'; // Nonaktifkan klik

                        // Ganti ikon dengan ikon larangan
                        const icon = button.querySelector('i');
                        icon.classList.remove('fa-book'); // Hapus ikon buku
                        icon.classList.add('fa-ban'); // Tambahkan ikon larangan

                        // Ganti kursor menjadi larangan menggunakan CSS
                        button.classList.add('disabled'); // Pastikan class 'disabled' ditambahkan
                    }
                });

                // Menambahkan event listener untuk mouseout
                button.addEventListener('mouseout', function() {
                    // Aktifkan kembali tombol jika data-available = true
                    if (button.getAttribute('data-available') === 'false') {
                        button.classList.remove('disabled');
                        button.style.pointerEvents = 'auto'; // Aktifkan klik

                        // Kembalikan ikon ke ikon buku
                        const icon = button.querySelector('i');
                        icon.classList.remove('fa-ban');
                        icon.classList.add('fa-book');

                        // Kembalikan kursor ke normal
                        button.style.cursor = 'pointer';
                    }
                });
            });
        });
    </script>





@endsection
