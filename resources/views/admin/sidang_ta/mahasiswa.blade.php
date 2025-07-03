@extends('admin.layout.main')

@section('content')
    <div class="container mt-4">
        <h3 class="card-title">Daftar Tugas Akhir</h3>

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

        <div class="card mt-3">
            <div class="card-header d-flex justify-content-between">
                @if ($data_mahasiswa_ta->isEmpty())
                    <button class="btn btn-primary" data-toggle="modal" data-target="#modalInsertTa">Tambah
                        Data</button>
                @endif
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead class="thead-light text-center">
                        <tr>
                            <th>Proposal Final</th>
                            <th>Laporan Ta</th>
                            <th>Tugas Akhir</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse ($data_mahasiswa_ta as $ta)
                            <tr>
                                <td>
                                    @if ($ta->proposal_final)
                                        <a href="{{ asset('storage/' . $ta->proposal_final) }}" target="_blank">Lihat
                                            File</a>
                                    @else
                                        <span class="text-danger">Tidak ada file</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($ta->laporan_ta)
                                        <a href="{{ asset('storage/' . $ta->laporan_ta) }}" target="_blank">Lihat File</a>
                                    @else
                                        <span class="text-danger">Tidak ada file</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($ta->tugas_akhir)
                                        <a href="{{ asset('storage/' . $ta->tugas_akhir) }}" target="_blank">Lihat File</a>
                                    @else
                                        <span class="text-danger">Tidak ada file</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $ta->status_berkas ? 'bg-success' : 'bg-warning' }}">
                                        {{ $ta->status_berkas ? 'Diterima' : 'Belum Diverifikasi' }}
                                    </span>
                                </td>
                                <td><button data-bs-toggle="modal" data-bs-target="#detailModal{{ $ta->id_sempro }}"
                                        class="btn btn-info btn-sm">
                                        Detail
                                    </button> <br>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data Ta.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
@foreach ($data_mahasiswa_ta as $ta )


        <div class="modal fade" id="detailModal{{ $ta->id_sempro }}" tabindex="-1"
            aria-labelledby="detailModalLabel{{ $ta->id_sempro }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabel{{ $ta->id_sempro }}">
                            Detail Tugas Akhir untuk {{ $ta->r_mhs_sempro->r_mahasiswa->nama ?? 'Tidak dtaukan' }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Pembimbing Satu:</strong> {{ $ta->r_pembimbing_satu->nama_dosen ?? '-' }}</p>
                        <p><strong>Pembimbing Dua:</strong> {{ $ta->r_pembimbing_dua->nama_dosen ?? '-' }}</p>
                        <p><strong>Ketua Sidang:</strong> {{ $ta->r_ketua->nama_dosen ?? '-' }}</p>
                        <p><strong>Sekretaris:</strong> {{ $ta->r_sekretaris->nama_dosen ?? '-' }}</p>
                        <p><strong>Penguji 1:</strong> {{ $ta->r_penguji_1->nama_dosen ?? '-' }}</p>
                        <p><strong>Penguji 2:</strong> {{ $ta->r_penguji_2->nama_dosen ?? '-' }}</p>
                        <p><strong>Ruangan:</strong> {{ $ta->r_ruangan->ruangan ?? '-' }}</p>
                        <p><strong>Sesi:</strong> {{ $ta->r_sesi->sesi ?? '-' }}</p>
                        <p><strong>Tanggal Sidang:</strong>
                            {{ $ta->tanggal_ta ? \Carbon\Carbon::parse($ta->tanggal_ta)->format('d-m-Y') : '-' }}</p>

                        <p><strong>Nilai:</strong> {{ $ta->nilai_mahasiswa ?? 'Belum Dinilai' }}</p>

                        <p>@if ($ta->keterangan == '0')
                            <span class="badge bg-warning">Belum Sidang</span>
                        @elseif ($ta->keterangan == '1')
                            <span class="badge bg-danger">Tidak Lulus</span>
                        @elseif ($ta->keterangan == '2')
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

        <!-- Modal Tambah Data ta -->
        <div class="modal fade" id="modalInsertTa" tabindex="-1" role="dialog" aria-labelledby="modalInsertTaLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalInsertTaLabel">Tambah Data TA</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('ta.store.mhs') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="proposal_final">Proposal Final</label>
                                <input type="file" class="form-control" id="proposal_final" name="proposal_final"
                                    accept=".pdf" required>
                                @error('proposal_final')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="laporan_ta">Laporan TA</label>
                                <input type="file" class="form-control" id="laporan_ta" name="laporan_ta" accept=".pdf">
                                @error('laporan_ta')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="tugas_akhir">Tugas Akhir</label>
                                <input type="file" class="form-control" id="tugas_akhir" name="tugas_akhir"
                                    accept=".pdf">
                                @error('tugas_akhir')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            @if (Auth::user()->mahasiswa && Auth::user()->mahasiswa->mhsSempro->first())
                                <input type="hidden" name="sempro_id"
                                    value="{{ Auth::user()->mahasiswa->mhsSempro->first()->id_sempro }}">
                            @endif


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
