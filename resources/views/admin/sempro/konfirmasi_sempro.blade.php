@extends('admin.layout.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show text-white" role="alert">
                <strong>Berhasil!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger text-white">
                {{ session('error') }}
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Mahasiswa yang Mendaftar Sempro</h3>
            </div>
            <div class="card-body">
                @if ($sempro->isEmpty())
                    <p class="text-center">Belum ada mahasiswa yang mendaftar Sempro.</p>
                @else
                    <table class="table table-bordered table-striped">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Mahasiswa</th>
                                <th>Judul</th>
                                {{-- <th>File</th> --}}
                                <th>Pembimbing Satu</th>
                                <th>Pembimbing Dua</th>
                                <th>Penguji</th>
                                <th>Tgl Sempro</th>
                                {{-- <th>Ruangan</th> --}}
                                {{-- <th>Sesi</th> --}}
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($sempro as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->r_mahasiswa->nama }}</td>
                                    <td>{{ $item->judul?? '-' }}</td>

                                    {{-- <td>
                                        @if ($item->file_sempro)
                                            <a href="{{ asset('storage/' . $item->file_sempro) }}" target="_blank">Lihat
                                                File</a>
                                        @else
                                            <span class="text-danger">Tidak ada file</span>
                                        @endif
                                    </td> --}}
                                    <td>{{ $item->r_pembimbing_satu->nama_dosen ?? '-' }}</td>
                                    <td>{{ $item->r_pembimbing_dua->nama_dosen ?? '-' }}</td>
                                    <td>{{ $item->r_penguji->nama_dosen ?? '-' }}</td>
                                    <td>{{ $item->tanggal_sempro ? \Carbon\Carbon::parse($item->tanggal_sempro)->format('d-m-Y') : '-' }}
                                    </td>
                                    <td>
                                        <!-- Tombol Konfirmasi Judul -->
                                        @if ($item->status_judul == '0') <!-- Jika judul belum dikonfirmasi -->
                                            <form action="{{ route('sempro.konfirmasi', $item->id_sempro) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Apakah Anda yakin ingin mengonfirmasi judul {{$item->judul}}?')">
                                                    Konfirmasi
                                                </button>
                                            </form>
                                        @else
                                            {{-- <span class="badge bg-success">Judul Terkonfirmasi</span> --}}

                                            <!-- Tombol Jadwalkan -->
                                            <button data-toggle="modal" data-target="#jadwalkanModal{{ $item->id_sempro }}" class="btn btn-primary btn-sm mt-2">
                                                Jadwalkan
                                            </button>
                                        @endif
                                        <br>
                                        <a href="{{ route('mhs_sempro.pdf', $item->id_sempro) }}" class="btn btn-danger btn-sm" style="width: 100px" target="_blank">
                                            Surat <br> Tugas
                                          </a>
                                    </td>

                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal Jadwalkan -->
    @foreach ($sempro as $item)
    <div class="modal fade" id="jadwalkanModal{{ $item->id_sempro }}" tabindex="-1"
        aria-labelledby="jadwalkanModalLabel{{ $item->id_sempro }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="jadwalkanModalLabel{{ $item->id_sempro }}">
                        Jadwalkan Sidang Sempro untuk {{ $item->r_mahasiswa->nama ?? 'Tidak ditemukan' }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('sempro.update', $item->id_sempro) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Pembimbing Satu -->
                        <div class="mb-3">
                            <label for="pembimbing_satu" class="form-label">Pembimbing Satu</label>
                            <select name="pembimbing_satu" id="pembimbing_satu" class="form-select">
                                <option value="">Pilih Dosen</option>
                                @foreach ($dosens as $dosen)
                                    <option value="{{ $dosen->id_dosen }}"
                                        {{ isset($item->r_pembimbing_satu) && $item->r_pembimbing_satu->id_dosen == $dosen->id_dosen ? 'selected' : '' }}>
                                        {{ $dosen->nama_dosen }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Pembimbing Dua -->
                        <div class="mb-3">
                            <label for="pembimbing_dua" class="form-label">Pembimbing Dua</label>
                            <select name="pembimbing_dua" id="pembimbing_dua" class="form-select">
                                <option value="">Pilih Dosen</option>
                                @foreach ($dosens as $dosen)
                                    <option value="{{ $dosen->id_dosen }}"
                                        {{ optional($item->r_pembimbing_dua)->id_dosen == $dosen->id_dosen ? 'selected' : '' }}>
                                        {{ $dosen->nama_dosen }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Penguji -->
                        <div class="mb-3">
                            <label for="penguji" class="form-label">Penguji</label>
                            <select name="penguji" id="penguji" class="form-select">
                                <option value="">Pilih Dosen</option>
                                @foreach ($dosens as $dosen)
                                    <option value="{{ $dosen->id_dosen }}"
                                        {{ optional($item->r_penguji)->id_dosen == $dosen->id_dosen ? 'selected' : '' }}>
                                        {{ $dosen->nama_dosen }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Ruangan -->
                        <div class="mb-3">
                            <label for="ruangan_id" class="form-label">Ruangan</label>
                            <select name="ruangan_id" id="ruangan_id" class="form-select">
                                <option value="">Pilih Ruangan</option>
                                @foreach ($ruangans as $ruangan)
                                    <option value="{{ $ruangan->id_ruangan }}"
                                        {{ optional($item->r_ruangan)->id_ruangan == $ruangan->id_ruangan ? 'selected' : '' }}>
                                        {{ $ruangan->ruangan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Sesi -->
                        <div class="mb-3">
                            <label for="sesi_id" class="form-label">Sesi</label>
                            <select name="sesi_id" id="sesi_id" class="form-select">
                                <option value="">Pilih Sesi</option>
                                @foreach ($sesies as $sesi)
                                    <option value="{{ $sesi->id_sesi }}"
                                        {{ optional($item->r_sesi)->id_sesi == $sesi->id_sesi ? 'selected' : '' }}>
                                        {{ $sesi->sesi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_sempro" class="form-label">Tanggal</label>
                            <input type="date" name="tanggal_sempro" id="tanggal_sempro" class="form-control" required>
                        </div>


                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Perbarui</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach




@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush
