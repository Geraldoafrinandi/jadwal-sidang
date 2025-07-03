@extends('admin.layout.main')

@section('content')
    <div class="container mt-4">
        <h3 class="card-title">Daftar Sempro</h3>

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

        <div class="card mt-3  ">
            <div class="card-header d-flex justify-content-between">
                {{-- <h3 class="card-title">Daftar Sempro</h3> --}}
                @if ($data_mahasiswa_sempro->isEmpty())
                    <button class="btn btn-primary" data-toggle="modal" data-target="#modalInsertSempro">Tambah
                        Data</button>
                @endif
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead class="thead-light text-center">
                        <tr>
                            {{-- <th>No</th> --}}
                            <th>Judul Sempro</th>
                            <th>File Sempro</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse ($data_mahasiswa_sempro as $index => $sempro)
                            <tr>
                                {{-- <td>{{ $index + 1 }}</td> --}}
                                <td>{{ $sempro->judul }}</td>
                                <td>
                                    @if ($sempro->file_sempro)
                                        <a href="{{ asset('storage/' . $sempro->file_sempro) }}" target="_blank">Lihat
                                            File</a>
                                    @else
                                        <span class="text-danger">Tidak ada file</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $sempro->status_judul ? 'bg-success' : 'bg-warning' }}">
                                        {{ $sempro->status_judul ? 'Diterima' : 'Belum Diverifikasi' }}
                                    </span>
                                </td>

                                {{-- <td>
                                    <form action="{{ route('sempro.destroy', $sempro->id_sempro) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                                    </form>
                                </td> --}}
                                <td>
                                    {{-- Hanya tampilkan tombol Detail jika semua data terkait tidak null --}}
                                    @if (
                                        $sempro->r_pembimbing_satu &&
                                            $sempro->r_pembimbing_dua &&
                                            $sempro->r_penguji &&
                                            $sempro->r_ruangan &&
                                            $sempro->r_sesi)
                                        <button class="btn btn-info btn-sm" data-toggle="modal"
                                            data-target="#modalDetail{{ $sempro->id_sempro }}">
                                            Detail
                                        </button>
                                    @else
                                        {{-- <span class="text-danger">Detail tidak tersedia</span> --}}
                                    @endif
                                    @if ($sempro->status_judul == '1')
                                        @if (!$sempro->file_sempro)
                                            <button class="btn btn-primary btn-sm" data-toggle="modal"
                                                data-target="#modalUpload{{ $sempro->id_sempro }}">
                                                Upload File
                                            </button>
                                        @endif
                                    @endif

                                        <button class="btn btn-warning btn-sm" data-toggle="modal"
                                            data-target="#modalNilai{{ $sempro->id_sempro }}">
                                            Lihat Nilai
                                        </button>

                                </td>



                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data Sempro.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @foreach ($data_mahasiswa_sempro as $sempro)
            <div class="modal fade" id="modalUpload{{ $sempro->id_sempro }}" tabindex="-1" role="dialog"
                aria-labelledby="modalUploadLabel{{ $sempro->id_sempro }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalUploadLabel{{ $sempro->id_sempro }}">
                                Upload File Sempro untuk Judul: {{ $sempro->judul }}
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('sempro.upload', $sempro->id_sempro) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="file_sempro">File Sempro</label>
                                    <input type="file" class="form-control" id="file_sempro" name="file_sempro"
                                        accept=".pdf" required>
                                    @error('file_sempro')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Upload</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

        @foreach ($data_mahasiswa_sempro as $sempro)
        <div class="modal fade" id="modalNilai{{ $sempro->id_sempro }}" tabindex="-1" role="dialog"
            aria-labelledby="modalNilaiLabel{{ $sempro->id_sempro }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalNilaiLabel{{ $sempro->id_sempro }}">
                            Nilai Mahasiswa untuk Judul: {{ $sempro->judul }}
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nilai_pembimbing_satu">Nilai Pembimbing 1</label>
                            <p>{{ $sempro->r_nilai_pembimbing_satu->nilai_sempro ?? 'Nilai belum diberikan' }}</p>
                        </div>
                        <div class="form-group">
                            <label for="nilai_pembimbing_dua">Nilai Pembimbing 2</label>
                            <p>{{ $sempro->r_nilai_pembimbing_dua->nilai_sempro ?? 'Nilai belum diberikan' }}</p>
                        </div>
                        <div class="form-group">
                            <label for="nilai_penguji">Nilai Penguji</label>
                            <p>{{ $sempro->r_nilai_penguji->nilai_sempro ?? 'Nilai belum diberikan' }}</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

    @endforeach

        <!-- Modal Detail Sempro -->
        @foreach ($data_mahasiswa_sempro as $sempro)
            <div class="modal fade" id="modalDetail{{ $sempro->id_sempro }}" tabindex="-1" role="dialog"
                aria-labelledby="modalDetailLabel{{ $sempro->id_sempro }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalDetailLabel{{ $sempro->id_sempro }}">
                                Detail Sempro untuk {{ $sempro->judul }}
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="pembimbing_satu">Pembimbing Satu</label>
                                <p>{{ $sempro->r_pembimbing_satu->nama_dosen ?? 'Tidak ada pembimbing satu' }}</p>
                            </div>
                            <div class="form-group">
                                <label for="pembimbing_dua">Pembimbing Dua</label>
                                <p>{{ $sempro->r_pembimbing_dua->nama_dosen ?? 'Tidak ada pembimbing dua' }}</p>
                            </div>
                            <div class="form-group">
                                <label for="penguji">Penguji</label>
                                <p>{{ $sempro->r_penguji->nama_dosen ?? 'Tidak ada penguji' }}</p>
                            </div>
                            <div class="form-group">
                                <label for="ruangan">Ruangan</label>
                                <p>{{ $sempro->r_ruangan->ruangan ?? 'Tidak ada ruangan' }}</p>
                            </div>
                            <div class="form-group">
                                <label for="sesi">Sesi</label>
                                <p>{{ $sempro->r_sesi->sesi ?? 'Tidak ada sesi' }}</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach


        <!-- Modal Tambah Data Sempro -->
        <div class="modal fade" id="modalInsertSempro" tabindex="-1" role="dialog"
            aria-labelledby="modalInsertSemproLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalInsertSemproLabel">Tambah Data Sempro</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('sempro.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="judul">Judul Sempro</label>
                                <input type="text" class="form-control" id="judul" name="judul"
                                    value="{{ old('judul') }}" required placeholder="Masukkan judul sempro">
                                @error('judul')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            {{-- <div class="form-group">
                                <label for="file_sempro">File Sempro</label>
                                <input type="file" class="form-control" id="file_sempro" name="file_sempro"
                                    accept=".pdf">
                                @error('file_sempro')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div> --}}
                            @if (Auth::user()->mahasiswa)
                                <input type="hidden" name="mahasiswa_id"
                                    value="{{ Auth::user()->mahasiswa->id_mahasiswa }}">
                            @endif

                            {{-- <div class="form-group">
                                <label for="tanggal_sempro">Tanggal Sempro</label>
                                <input type="date" class="form-control" id="tanggal_sempro" name="tanggal_sempro"
                                    value="{{ old('tanggal_sempro') }}" required>
                                @error('tanggal_sempro')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div> --}}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush
