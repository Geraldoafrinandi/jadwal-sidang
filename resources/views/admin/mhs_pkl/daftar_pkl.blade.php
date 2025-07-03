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
                <h3 class="card-title">Daftar Mahasiswa yang Mendaftar PKL</h3>
            </div>
            <div class="card-body">
                @if ($mahasiswaPkl->isEmpty())
                    <p class="text-center">Belum ada mahasiswa yang mendaftar PKL.</p>
                @else
                    <table class="table table-bordered table-striped">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Mahasiswa</th>
                                <th>Tahun PKL</th>
                                <th> Pembimbing Industri</th>
                                <th> Pembimbing PKL</th>
                                {{-- <th>Judul PKL</th> --}}
                                <th>Aksi</th>
                                @if (Auth::check() && Auth::user()->role == 'admin')
                                    <th>Sidang</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($mahasiswaPkl as $index => $pkl)
                                <tr>
                                    <td>{{ $index + 1 }}</td>

                                    <td>
                                        {{ $pkl->usulanPkl->mahasiswa->nama }}
                                    </td>

                                    <td>{{ $pkl->tahun_pkl }}</td>
                                    <td>{{ $pkl->pembimbing_pkl ?? 'Tidak ada' }}</td>
                                    <td>{{ $pkl->dosen_pembimbing->nama_dosen }}</td>
                                    {{-- <td>{{ $pkl->judul }}</td> --}}
                                    <td>
                                        <!-- Tombol untuk membuka detail dalam modal -->
                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                            data-target="#detailModal{{ $pkl->id_mhs_pkl }}">
                                            Detail
                                        </button> <br>
                                        <a href="{{ route('mhs_pkl.pdf', $pkl->id_mhs_pkl) }}" class="btn btn-danger btn-sm" style="width: 100px" target="_blank">
                                          Surat <br> Tugas
                                        </a>
                                    </td>
                                    @if (Auth::check() && Auth::user()->role == 'admin')
                                        <td>

                                            @if ($pkl->status_admin == '0')
                                                <!-- Tombol Konfirmasi -->
                                                <form action="{{ route('jadwal_sidang.konfirmasi', $pkl->id_mhs_pkl) }}"
                                                    method="POST" style="display:inline-block;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-success btn-sm">
                                                        Konfirmasi
                                                    </button>
                                                </form>
                                            @else
                                                <!-- Tombol Jadwalkan Sidang -->
                                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                                    data-target="#jadwalSidangModal{{ $pkl->id_mhs_pkl }}">
                                                    Jadwalkan <br> Sidang
                                                </button>
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

        <!-- Modal Detail untuk masing-masing mahasiswa PKL -->
        @foreach ($mahasiswaPkl as $pkl)
            <div class="modal fade" id="detailModal{{ $pkl->id_mhs_pkl }}" tabindex="-1" role="dialog"
                aria-labelledby="detailModalLabel{{ $pkl->id_mhs_pkl }}" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            {{-- <h5 class="modal-title" id="detailModalLabel{{ $pkl->id_mhs_pkl }}">Detail PKL: {{ $pkl->mahasiswa->nama }}</h5> --}}
                            {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button> --}}
                        </div>
                        <div class="modal-body">
                            <form class="form-sample">
                                <div class="mb-3 row d-flex align-items-center">
                                    <label class="col-sm-4 col-form-label fw-bold mb-0">Nama Mahasiswa</label>
                                    <div class="col-sm-4 mb-0">
                                        <input type="text" class="form-control"
                                            value="{{ $pkl->usulanPkl->mahasiswa->nama }}" readonly>
                                    </div>
                                </div>
                                <div class="mb-3 row d-flex align-items-center">
                                    <label class="col-sm-4 col-form-label fw-bold mb-0">Tahun PKL</label>
                                    <div class="col-sm-4 mb-0">
                                        <input type="text" class="form-control" value="{{ $pkl->tahun_pkl }}" readonly>
                                    </div>
                                </div>
                                <div class="mb-3 row d-flex align-items-center">
                                    <label class="col-sm-4 col-form-label fw-bold mb-0"> Pembimbing Industri</label>
                                    <div class="col-sm-4 mb-0">
                                        <input type="text" class="form-control" value="{{ $pkl->pembimbing_pkl }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="mb-3 row d-flex align-items-center">
                                    <label class="col-sm-4 col-form-label fw-bold mb-0"> Pembimbing PKL</label>
                                    <div class="col-sm-4 mb-0">
                                        <input type="text" class="form-control"
                                            value="{{ $pkl->dosen_pembimbing ? $pkl->dosen_pembimbing->nama_dosen : 'Tidak ada' }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="mb-3 row d-flex align-items-center">
                                    <label class="col-sm-4 col-form-label fw-bold mb-0">Judul PKL</label>
                                    <div class="col-sm-4 mb-0">
                                        <input type="text" class="form-control" value="{{ $pkl->judul }}" readonly>
                                    </div>
                                </div>

                                <div class="mb-3 row d-flex align-items-center">
                                    <label class="col-sm-4 col-form-label fw-bold mb-0">Tanggal Sidang</label>
                                    <div class="col-sm-4 mb-0">
                                        <input type="text" class="form-control" value="{{ $pkl->tgl_sidang }}" readonly>
                                    </div>
                                </div>
                                <div class="mb-3 row d-flex align-items-center">
                                    <label class="col-sm-4 col-form-label fw-bold mb-0">Jam Sidang</label>
                                    <div class="col-sm-4 mb-0">
                                        <input type="text" class="form-control" value="{{ $pkl->jam ? $pkl->sesi->jam : "tidak ada data" }}" readonly>
                                    </div>
                                </div>
                                <div class="mb-3 row d-flex align-items-center">
                                    <label class="col-sm-4 col-form-label fw-bold mb-0">Dosen Penguji</label>
                                    <div class="col-sm-4 mb-0">
                                        <input type="text" class="form-control"
                                            value="{{ $pkl->dosenPenguji->nama_dosen ?? 'tidak ada dosen' }}" readonly>
                                    </div>
                                </div>
                                <div class="mb-3 row d-flex align-items-center">
                                    <label class="col-sm-4 col-form-label fw-bold mb-0">Ruang Sidang</label>
                                    <div class="col-sm-4 mb-0">
                                        <input type="text" class="form-control"
                                            value="{{ $pkl->ruang->ruangan ?? 'tidak ada' }}" readonly>
                                    </div>
                                </div>
                                <div class="mb-3 row d-flex align-items-center">
                                    <label class="col-sm-4 col-form-label fw-bold mb-0">Dokumen Nilai Industri</label>
                                    <div class="col-sm-4 mb-0">
                                        @if ($pkl->dokumen_nilai_industri)
                                            <button class="btn btn-primary mt-3"
                                                onclick="window.open('{{ asset('storage/uploads/mahasiswa/dokumen_nilai_industri/' . $pkl->dokumen_nilai_industri) }}', '_blank')">Lihat
                                                Dokumen</button>
                                        @else
                                            <span class="text-muted">Tidak ada dokumen</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="mb-3 row d-flex align-items-center">
                                    <label class="col-sm-4 col-form-label fw-bold mb-0">Dokumen Laporan PKL</label>
                                    <div class="col-sm-4 mb-0">
                                        @if ($pkl->laporan_pkl)
                                            <button class="btn btn-primary mt-3"
                                                onclick="window.open('{{ asset('storage/uploads/mahasiswa/laporan_pkl/' . $pkl->laporan_pkl) }}', '_blank')">
                                                Lihat Laporan
                                            </button>
                                        @else
                                            <span class="text-muted">Tidak ada dokumen</span>
                                        @endif
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <!-- Modal Jadwalkan Sidang -->
        @foreach ($mahasiswaPkl as $pkl)
            <div class="modal fade" id="jadwalSidangModal{{ $pkl->id_mhs_pkl }}" tabindex="-1" role="dialog"
                aria-labelledby="jadwalSidangModalLabel{{ $pkl->id_mhs_pkl }}" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="jadwalSidangModalLabel{{ $pkl->id_mhs_pkl }}">Jadwalkan Sidang
                                PKL
                                untuk {{ $pkl->usulanPkl->mahasiswa->nama }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('jadwal_sidang.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="usulan_id" value="{{ $pkl->usulan_id }}">

                                <div class="mb-3">
                                    <label for="ruang_sidang" class="form-label">Ruang Sidang</label>
                                    <select name="ruang_sidang" id="ruang_sidang" class="form-control" required>
                                        <option value="">Pilih Ruang Sidang</option>
                                        @foreach ($ruangan as $ruang)
                                            <option value="{{ $ruang->id_ruangan }}">{{ $ruang->ruangan }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="dosen_penguji" class="form-label">Dosen Penguji</label>
                                    <select name="dosen_penguji" id="dosen_penguji" class="form-control" required>
                                        <option value="">Pilih Dosen Penguji</option>
                                        @foreach ($dosenPenguji as $dosen)
                                            <option value="{{ $dosen->id_dosen }}">{{ $dosen->nama_dosen }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="tgl_sidang" class="form-label">Tanggal Sidang</label>
                                    <input type="date" name="tgl_sidang" id="tgl_sidang" class="form-control"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="jam" class="form-label">Jam Sidang</label>
                                    <select name="jam" id="jam" class="form-control" required>
                                        @foreach ($jam as $sesi)
                                            <option value="{{ $sesi->id_sesi }}"> {{ $sesi->jam}}</option>
                                        @endforeach


                                    </select>

                                </div>

                                <button type="submit" class="btn btn-primary">Simpan Jadwal Sidang</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush
