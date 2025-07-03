@extends('admin.layout.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
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
            <div class="card-header">
                <h3 class="card-title text-center">Detail Mahasiswa PKL</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Kolom Kiri: Form Update Mahasiswa PKL -->
                    <div class="col-md-7">
                        <form class="form-sample" method="POST" enctype="multipart/form-data"
                            action="{{ route('mhs_pkl.update', $data_pkl ? $data_pkl->id_mhs_pkl : '') }}">
                            @csrf
                            @method('PUT')

                            <!-- Nama Mahasiswa -->
                            <div class="mb-3 row d-flex align-items-center">
                                <label class="col-sm-4 col-form-label fw-bold mb-0">Nama Mahasiswa</label>
                                <div class="col-sm-4 mb-0">
                                    <input type="text" class="form-control" value="{{ auth()->user()->mahasiswa->nama }}"
                                        readonly>
                                </div>
                            </div>

                            <!-- Tahun PKL -->
                            <div class="mb-3 row d-flex align-items-center">
                                <label class="col-sm-4 col-form-label fw-bold mb-0">Tahun PKL</label>
                                <div class="col-sm-4 mb-0">
                                    <input type="text" class="form-control" value="{{ $data_pkl->tahun_pkl }}" readonly>
                                </div>
                            </div>

                            <!-- Dosen Pembimbing -->
                            <div class="mb-3 row d-flex align-items-center">
                                <label class="col-sm-4 col-form-label fw-bold mb-0">Dosen Pembimbing</label>
                                <div class="col-sm-4 mb-0">
                                    <input type="text" class="form-control" name="dosen_pembimbing"
                                        value="{{ old('dosen_pembimbing', $data_pkl->dosenPembimbing ? $data_pkl->dosenPembimbing->nama_dosen : '') }}"
                                        placeholder="Nama Dosen Pembimbing" readonly>
                                </div>
                            </div>

                            <!-- Pembimbing Industri -->
                            <div class="mb-3 row d-flex align-items-center">
                                <label class="col-sm-4 col-form-label fw-bold mb-0">Pembimbing PKL</label>
                                <div class="col-sm-4 mb-0">
                                    <input type="text" class="form-control" name="pembimbing_pkl"
                                        value="{{ old('pembimbing_pkl', $data_pkl->pembimbing_pkl) }}"
                                        placeholder="Masukkan Dosen Pembimbing Industri">
                                </div>
                            </div>

                            <!-- Nilai Pembimbing Industri -->
                            <div class="mb-3 row d-flex align-items-center">
                                <label class="col-sm-4 col-form-label fw-bold mb-0">Nilai Pembimbing Industri</label>
                                <div class="col-sm-4 mb-0">
                                    <input type="number" class="form-control" name="nilai_pembimbing_industri"
                                        value="{{ old('nilai_pembimbing_industri', $data_pkl->nilai_pembimbing_industri ?? '') }}"
                                        placeholder="Masukkan Nilai Pembimbing Industri" min="0" max="100"
                                        step="0.1">
                                </div>
                            </div>

                            <!-- Judul PKL -->
                            <div class="mb-3 row d-flex align-items-center">
                                <label class="col-sm-4 col-form-label fw-bold mb-0">Judul PKL</label>
                                <div class="col-sm-4 mb-0">
                                    <input type="text" class="form-control" name="judul"
                                        value="{{ old('judul', $data_pkl->judul) }}" placeholder="Masukkan Judul PKL">
                                </div>
                            </div>

                            <!-- Dokumen Nilai Industri -->
                            <div class="mb-3 row d-flex align-items-center">
                                <label class="col-sm-4 col-form-label fw-bold">Dokumen Nilai Industri</label>
                                <div class="col-sm-4">
                                    <input type="file" name="dokumen_nilai_industri" class="form-control"
                                        id="dokumen_nilai_industri">
                                    @if ($data_pkl->dokumen_nilai_industri)
                                        <small class="d-block mt-2">
                                            Current file:
                                            <a href="{{ asset('storage/uploads/mahasiswa/dokumen_nilai_industri/' . $data_pkl->dokumen_nilai_industri) }}"
                                                target="_blank">
                                                {{ $data_pkl->dokumen_nilai_industri }}
                                            </a>
                                        </small>
                                    @endif
                                </div>
                            </div>

                            <!-- Laporan PKL -->
                            <div class="mb-3 row d-flex align-items-center">
                                <label class="col-sm-4 col-form-label fw-bold">Laporan PKL</label>
                                <div class="col-sm-4">
                                    <input type="file" name="laporan_pkl" class="form-control" id="laporan_pkl">
                                    @if ($data_pkl->laporan_pkl)
                                        <small class="d-block mt-2">
                                            Current file:
                                            <a href="{{ asset('storage/uploads/mahasiswa/laporan_pkl/' . $data_pkl->laporan_pkl) }}"
                                                target="_blank">
                                                {{ $data_pkl->laporan_pkl }}
                                            </a>
                                        </small>
                                    @endif
                                </div>
                            </div>

                            <!-- Tombol Update -->
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>

                    <!-- Kolom Kanan: Rincian Sidang -->
                    <div class="col-md-4">
                        <div class="card shadow-lg">
                            <div class="card-header bg-primary text-white text-center">
                                <h5 class="card-title">Rincian Sidang</h5>
                            </div>
                            <div class="card-body">


                                <!-- Dosen Pembimbing -->
                                <div class="mb-3">
                                    <strong class="d-block text-secondary">Dosen Pembimbing:</strong>
                                    <p class="fw-semibold">{{ $data_pkl->dosenPembimbing->nama_dosen ?? 'Belum Ditentukan' }}</p>
                                </div>

                                <!-- Dosen Penguji -->
                                <div class="mb-3">
                                    <strong class="d-block text-secondary">Dosen Penguji:</strong>
                                    <p class="fw-semibold">{{ $data_pkl->dosenPenguji->nama_dosen ?? 'Belum Ditentukan' }}</p>
                                </div>

                                <!-- Tanggal Sidang -->
                                <div class="mb-3">
                                    <strong class="d-block text-secondary">Tanggal Sidang:</strong>
                                    <p class="fw-semibold">
                                        {{ \Carbon\Carbon::parse($data_pkl->tgl_sidang)->format('d-M-Y') ?? 'Belum Dijadwalkan' }}
                                    </p>
                                </div>

                                <!-- Lokasi Sidang -->
                                <div class="mb-3">
                                    <strong class="d-block text-secondary">Lokasi Sidang:</strong>
                                    <p class="fw-semibold">{{ $data_pkl->ruang->ruangan ?? 'Belum Ditentukan' }}</p>
                                </div>

                                <!-- Nilai Sidang -->
                                <div class="mb-3">
                                    <strong class="d-block text-secondary">Nilai Sidang:</strong>
                                    <p class="fw-semibold">{{ $data_pkl->nilai_mahasiswa ?? 'Belum Diberikan' }}</p>
                                </div>

                                <!-- Tombol Lihat Nilai -->
                                <div class="mb-3 text-center">
                                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#nilaiModal">
                                        <i class="bi bi-eye"></i> Lihat Nilai
                                    </button>
                                </div>



                                <!-- Modal -->
                                <div class="modal fade" id="nilaiModal" tabindex="-1" aria-labelledby="nilaiModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="nilaiModalLabel">Detail Nilai Mahasiswa</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Nilai Pembimbing -->
                                                <div class="mb-3">
                                                    <strong>Nilai Pembimbing:</strong>
                                                    <p>{{ $data_pkl->nilaiPembimbing->total_nilai ?? 'Belum Ada Nilai Pembimbing' }}
                                                    </p>
                                                </div>

                                                <!-- Nilai Penguji -->
                                                <div class="mb-3">
                                                    <strong>Nilai Penguji:</strong>
                                                    <p>{{ $data_pkl->nilaiPenguji->total_nilai ?? 'Belum Ada Nilai Penguji' }}
                                                    </p>
                                                </div>

                                                <!-- Nilai Industri -->
                                                <div class="mb-3">
                                                    <strong>Nilai Industri:</strong>
                                                    <p>{{ $data_pkl->nilai_pembimbing_industri ?? 'Belum Ada Nilai Industri' }}
                                                    </p>
                                                </div>

                                                <!-- Nilai Mahasiswa -->
                                                <div class="mb-3">
                                                    <strong>Nilai Mahasiswa:</strong>
                                                    <p>{{ $data_pkl->nilai_mahasiswa ?? 'Belum Ada Nilai Mahasiswa' }}</p>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
