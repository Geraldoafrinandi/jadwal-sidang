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
                <h3 class="card-title">Daftar Mahasiswa yang Mendaftar Tugas Akhir</h3>
            </div>
            <div class="card-body">
                @if ($ta->isEmpty())
                    <p class="text-center">Belum ada mahasiswa yang mendaftar Sempro.</p>
                @else
                    <table class="table table-bordered table-striped">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Mahasiswa</th>
                                {{-- <th>Pembimbing Satu</th> --}}
                                {{-- <th>Pembimbing Dua</th> --}}
                                <th>Ketua Sidang</th>
                                <th>Sekretaris</th>
                                <th>Penguji 1</th>
                                <th>Penguji 2</th>
                                {{-- <th>Ruangan</th>
                                <th>Sesi</th> --}}
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($ta as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->r_mhs_sempro->r_mahasiswa->nama }}</td>
                                    {{-- <td>{{ $item->r_pembimbing_satu->nama_dosen ?? '-' }}</td> --}}
                                    {{-- <td>{{ $item->r_pembimbing_dua->nama_dosen ?? '-' }}</td> --}}
                                    <td>{{ $item->r_ketua->nama_dosen ?? '-' }}</td>
                                    <td>{{ $item->r_sekretaris->nama_dosen ?? '-' }}</td>
                                    <td>{{ $item->r_penguji_1->nama_dosen ?? '-' }}</td>
                                    <td>{{ $item->r_penguji_2->nama_dosen ?? '-' }}</td>
                                    {{-- <td>{{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal_sempro)->format('d-m-Y') : '-' }}</td> --}}
                                    {{-- <td>{{ $item->r_ruangan->ruangan ?? '-' }}</td>
                                    <td>{{ $item->r_sesi->sesi ?? '-' }}</td> --}}
                                    <td>
                                        @if ($item->status_berkas == '0')
                                            <span class="badge bg-danger">Belum Dikonfirmasi</span>
                                        @endif
                                        @if ($item->keterangan == '0')
                                            <span class="badge bg-warning">Belum Sidang</span>
                                        @elseif ($item->keterangan == '2s')
                                            <span class="badge bg-danger">Tidak Lulus</span>
                                        @elseif ($item->keterangan == '1')
                                            <span class="badge bg-success">Lulus</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak ada keterangan</span>
                                        @endif
                                    </td>



                                    <td>
                                        <button data-bs-toggle="modal" data-bs-target="#detailModal{{ $item->id_ta }}"
                                            class="btn btn-info btn-sm">
                                            Detail
                                        </button> <br>
                                        @if ($item->status_berkas == '0')
                                            <form action="{{ route('ta.konfirmasi', $item->id_ta) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm"
                                                    onclick="return confirm('Apakah Anda yakin ingin mengonfirmasi Tugas Akhir {{ $item->r_mhs_sempro->r_mahasiswa->nama }}?')">
                                                    Konfirmasi
                                                </button>
                                            </form>
                                        @else
                                            <!-- Tombol Jadwalkan -->
                                            <button data-bs-toggle="modal"
                                                data-bs-target="#jadwalkanModal{{ $item->id_ta }}"
                                                class="btn btn-primary btn-sm mt-2">
                                                Jadwalkan
                                            </button>
                                        @endif
                                        <br>
                                        <a href="{{ route('mhs_ta.pdf', $item->id_ta) }}" class="btn btn-danger btn-sm"
                                            style="width: 100px" target="_blank">
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


    <!-- Modal Detail -->
    @foreach ($ta as $item)
        <div class="modal fade" id="detailModal{{ $item->id_ta }}" tabindex="-1"
            aria-labelledby="detailModalLabel{{ $item->id_ta }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabel{{ $item->id_ta }}">
                            Detail Tugas Akhir untuk {{ $item->r_mhs_sempro->r_mahasiswa->nama ?? 'Tidak ditemukan' }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Nama Mahasiswa:</strong>
                            {{ $item->r_mhs_sempro->r_mahasiswa->nama ?? 'Tidak ditemukan' }}</p>
                        <p><strong>Pembimbing Satu:</strong> {{ $item->r_pembimbing_satu->nama_dosen ?? '-' }}</p>
                        <p><strong>Pembimbing Dua:</strong> {{ $item->r_pembimbing_dua->nama_dosen ?? '-' }}</p>
                        <p><strong>Ketua Sidang:</strong> {{ $item->r_ketua->nama_dosen ?? '-' }}</p>
                        <p><strong>Sekretaris:</strong> {{ $item->r_sekretaris->nama_dosen ?? '-' }}</p>
                        <p><strong>Penguji 1:</strong> {{ $item->r_penguji_1->nama_dosen ?? '-' }}</p>
                        <p><strong>Penguji 2:</strong> {{ $item->r_penguji_2->nama_dosen ?? '-' }}</p>
                        <p><strong>Ruangan:</strong> {{ $item->r_ruangan->ruangan ?? '-' }}</p>
                        <p><strong>Sesi:</strong> {{ $item->r_sesi->sesi ?? '-' }}</p>
                        <p><strong>Tanggal Sidang:</strong>
                            {{ $item->tanggal_ta ? \Carbon\Carbon::parse($item->tanggal_ta)->format('d-m-Y') : '-' }}</p>

                        <p><strong>Nilai:</strong> {{ $item->nilai_mahasiswa ?? 'Belum Dinilai' }}</p>
                        <p>
                            @if ($item->keterangan == '0')
                                <span class="badge bg-warning">Belum Sidang</span>
                            @elseif ($item->keterangan == '2')
                                <span class="badge bg-danger">Tidak Lulus</span>
                            @elseif ($item->keterangan == '1')
                                <span class="badge bg-success">Lulus</span>
                            @else
                                <span class="badge bg-secondary">Tidak ada keterangan</span>
                            @endif

                        </p>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach


    <!-- Modal Jadwalkan -->
    @foreach ($ta as $item)
        <div class="modal fade" id="jadwalkanModal{{ $item->id_ta }}" tabindex="-1"
            aria-labelledby="jadwalkanModalLabel{{ $item->id_ta }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="jadwalkanModalLabel{{ $item->id_ta }}">
                            Jadwalkan Sidang Sempro untuk {{ $item->r_mhs_sempro->r_mahasiswa->nama ?? 'Tidak ditemukan' }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('ta.update', $item->id_ta) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Pembimbing Satu -->
                            <div class="mb-3">
                                <label for="pembimbing_satu_id" class="form-label">Pembimbing Satu</label>
                                <input type="text" class="form-control"
                                    value="{{ $item->r_mhs_sempro->r_pembimbing_satu->nama_dosen ?? 'Tidak ditemukan' }}"
                                    id="pembimbing_satu_id" readonly>
                                <input type="hidden" name="pembimbing_satu_id"
                                    value="{{ $item->r_mhs_sempro->r_pembimbing_satu->id_dosen ?? '' }}">
                            </div>



                            <!-- Pembimbing Dua -->
                            <div class="mb-3">
                                <label for="pembimbing_dua_id" class="form-label">Pembimbing Dua</label>
                                <input type="text" class="form-control"
                                    value="{{ $item->r_mhs_sempro->r_pembimbing_dua->nama_dosen ?? 'Tidak ditemukan' }}"
                                    id="pembimbing_dua_id" readonly>
                                <input type="hidden" name="pembimbing_dua_id"
                                    value="{{ $item->r_mhs_sempro->r_pembimbing_dua->id_dosen ?? '' }}">
                            </div>

                            {{-- Ketua Sidang --}}
                            <div class="mb-3">
                                <label for="ketua" class="form-label">Ketua Sidang</label>
                                <input type="text" class="form-control" id="ketua" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="sekretaris" class="form-label">Sekretaris</label>
                                <select name="sekretaris" id="sekretaris" class="form-select">
                                    <option value="">Pilih Dosen</option>
                                    @foreach ($dosens as $dosen)
                                        <option value="{{ $dosen->id_dosen }}"
                                            {{ optional($item->r_sekretaris)->id_dosen == $dosen->id_dosen ? 'selected' : '' }}>
                                            {{ $dosen->nama_dosen }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>



                            <!-- Penguji -->
                            <div class="mb-3">
                                <label for="penguji_1" class="form-label">Penguji 1</label>
                                <select name="penguji_1" id="penguji_1" class="form-select">
                                    <option value="">Pilih Dosen</option>
                                    @foreach ($dosens as $dosen)
                                        <option value="{{ $dosen->id_dosen }}"
                                            {{ optional($item->r_penguji_1)->id_dosen == $dosen->id_dosen ? 'selected' : '' }}>
                                            {{ $dosen->nama_dosen }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="penguji_2" class="form-label">Penguji 2</label>
                                <select name="penguji_2" id="penguji_2" class="form-select">
                                    <option value="">Pilih Dosen</option>
                                    @foreach ($dosens as $dosen)
                                        <option value="{{ $dosen->id_dosen }}"
                                            {{ optional($item->r_penguji_2)->id_dosen == $dosen->id_dosen ? 'selected' : '' }}>
                                            {{ $dosen->nama_dosen }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Ruangan -->
                            <!-- Ruangan -->
                            <div class="mb-3">
                                <label for="ruangan_id" class="form-label">Ruangan</label>
                                <select name="ruangan_id" id="ruangan_id" class="form-select">
                                    <option value="">Pilih Ruangan</option>
                                    @foreach ($ruangans as $ruangan)
                                        @php
                                            $ruanganTerpakai = $ruangan
                                                ->mhs_ta()
                                                ->where('tanggal_ta', $item->tanggal_ta)
                                                ->where('sesi_id', $item->sesi_id)
                                                ->exists();
                                        @endphp
                                        @if (!$ruanganTerpakai || $ruangan->id_ruangan == $item->ruangan_id)
                                            <option value="{{ $ruangan->id_ruangan }}"
                                                {{ optional($item->r_ruangan)->id_ruangan == $ruangan->id_ruangan ? 'selected' : '' }}>
                                                {{ $ruangan->ruangan }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <!-- Sesi -->
                            <div class="mb-3">
                                <label for="sesi_id" class="form-label">Sesi</label>
                                <select name="sesi_id" id="sesi_id" class="form-select">
                                    <option value="">Pilih Sesi</option>
                                    @foreach ($sesies as $sesi)
                                        @php
                                            $sesiTerpakai = $sesi
                                                ->mhs_ta()
                                                ->where('tanggal_ta', $item->tanggal_ta)
                                                ->where('ruangan_id', $item->ruangan_id)
                                                ->exists();
                                        @endphp
                                        @if (!$sesiTerpakai || $sesi->id_sesi == $item->sesi_id)
                                            <option value="{{ $sesi->id_sesi }}"
                                                {{ optional($item->r_sesi)->id_sesi == $sesi->id_sesi ? 'selected' : '' }}>
                                                {{ $sesi->sesi }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>



                            <div class="mb-3">
                                <label for="tanggal_ta" class="form-label">Tanggal Ta</label>
                                <input type="date" name="tanggal_ta" id="tanggal_ta" class="form-control" required>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Jadwalkan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const pembimbingSatuInput = document.getElementById('pembimbing_satu_id');
            const ketuaInput = document.getElementById('ketua');

            function setKetua() {
                const pembimbingSatuValue = pembimbingSatuInput.value;
                ketuaInput.value = pembimbingSatuValue ? pembimbingSatuValue : 'Tidak ditemukan';
            }

            setKetua();
        });
    </script>


@endsection
