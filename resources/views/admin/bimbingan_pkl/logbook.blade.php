@extends('admin.layout.main')

@section('title', 'Daftar Bimbingan PKL')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <h4 class="mb-4">Daftar Bimbingan PKL</h4>

                @if (session('success'))
                    <div class="alert alert-success text-white">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kegiatan</th>
                                    <th>Tanggal Awal</th>
                                    <th>Tanggal Akhir</th>
                                    <th>Status Validasi</th>
                                    <th>Komentar</th>
                                    <th>File Dokumentasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $counter = 1; // Inisialisasi penghitung
                            @endphp
                                @foreach ($bimbingan as $key => $item)
                                    @foreach ($item->bimbinganPkl as $bimbingan)
                                        <tr>
                                            <td>{{ $counter++ }}</td>
                                            <td>{{ $bimbingan->kegiatan ?? 'Belum ada kegiatan' }}</td>
                                            <td>
                                                {{ $bimbingan->tgl_kegiatan_awal ? \Carbon\Carbon::parse($bimbingan->tgl_kegiatan_awal)->format('d-m-Y') : '-' }}
                                            </td>
                                            <td>
                                                {{ $bimbingan->tgl_kegiatan_akhir ? \Carbon\Carbon::parse($bimbingan->tgl_kegiatan_akhir)->format('d-m-Y') : '-' }}
                                            </td>
                                            <td>
                                                @if ($bimbingan->status == 0)
                                                    <form action="{{ route('bimbingan_pkl.konfirmasi', $bimbingan->id_bimbingan_pkl) }}" method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#validasiModal{{ $bimbingan->id_bimbingan_pkl }}">
                                                            Validasi
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="badge bg-success">Valid</span>
                                                @endif
                                            </td>
                                            <td>{{ $bimbingan->komentar ?? 'Tidak ada komentar' }}</td>
                                            <td>
                                                @if ($bimbingan->file_dokumentasi)
                                                    <a href="{{ asset('storage/' . $bimbingan->file_dokumentasi) }}" target="_blank">
                                                        <button class="btn btn-info text-white btn-sm">Lihat File</button>
                                                    </a>
                                                @else
                                                    <p>Tidak ada file</p>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Validasi -->
    <div class="modal fade" id="validasiModal{{ $bimbingan->id_bimbingan_pkl }}" tabindex="-1" aria-labelledby="validasiModalLabel{{ $bimbingan->id_bimbingan_pkl }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('bimbingan_pkl.konfirmasi', $bimbingan->id_bimbingan_pkl) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="validasiModalLabel{{ $bimbingan->id_bimbingan_pkl }}">Validasi Bimbingan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="komentar{{ $bimbingan->id_bimbingan_pkl }}" class="form-label">Komentar</label>
                            <textarea name="komentar" id="komentar{{ $bimbingan->id_bimbingan_pkl }}" class="form-control" rows="3" required></textarea>
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
@endsection
