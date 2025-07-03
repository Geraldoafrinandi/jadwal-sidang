@extends('admin.layout.main')

@section('title', 'Daftar Nilai PKL')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <h4 class="mb-4">Daftar Nilai PKL</h4>

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
                                    <th>Nama Mahasiswa</th>
                                    <th>Tempat Magang</th>
                                    <th>Dosen Pembimbing</th>
                                    <th>Dosen Penguji</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $counter = 1;
                                @endphp
                                @foreach ($mhsPkl as $mhs)
                                    <tr>
                                        <td>{{ $counter++ }}</td>
                                        <td>{{ $mhs->usulanPkl->mahasiswa->nama ?? 'Tidak ada data' }}</td>
                                        <td>{{ $mhs->usulanPkl->tempatPKL->nama_perusahaan ?? 'Tidak ada data' }}</td>
                                        <td>
                                            {{ $mhs->dosenPembimbing->nama_dosen ?? 'Tidak ada data' }} -
                                            @if ($mhs->nilaiPkl && $mhs->nilaiPkl->where('status', "0")->first())
                                                <span class="badge bg-success">
                                                    {{ $mhs->nilaiPkl->where('status', "0")->first()->total_nilai }}
                                                </span>
                                            @else
                                                <span class="badge bg-danger">Belum ada nilai</span>
                                            @endif
                                        </td>

                                        <td>
                                            {{ $mhs->dosenPenguji->nama_dosen ?? 'Tidak ada data' }} -
                                            @if ($mhs->nilaiPkl && $mhs->nilaiPkl->where('status', "1")->first())
                                                <span class="badge bg-success">
                                                    {{ $mhs->nilaiPkl->where('status', "1")->first()->total_nilai }}
                                                </span>
                                            @else
                                                <span class="badge bg-danger">Belum ada nilai</span>
                                            @endif
                                        </td>



                                        <td>
                                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#nilaiModal{{ $mhs->id_mhs_pkl }}">
                                                Input Nilai
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Modal untuk input nilai -->
                                    <div class="modal fade" id="nilaiModal{{ $mhs->id_mhs_pkl }}" tabindex="-1"
                                        aria-labelledby="nilaiModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form action="{{ route('admin.mhs_pkl.nilai_pkl.update', $mhs->id_mhs_pkl) }}"
                                                method="POST">
                                                @csrf
                                                @method('POST')
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="nilaiModalLabel">Input Nilai -
                                                            {{ $mhs->usulanPkl->mahasiswa->nama }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="bahasa" class="form-label">Bahasa</label>
                                                            <input type="number" class="form-control" id="bahasa"
                                                                   name="bahasa"  value="{{ $mhs->nilaiPkl->isNotEmpty() ? $mhs->nilaiPkl->first()->bahasa : '' }}"
                                                                   min="0" max="100">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="analisis" class="form-label">Analisis</label>
                                                            <input type="number" class="form-control" id="analisis"
                                                                name="analisis" value="{{ $mhs->nilaiPkl->isNotEmpty() ? $mhs->nilaiPkl->first()->analisis : '' }}" min="0"
                                                                max="100">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="sikap" class="form-label">Sikap</label>
                                                            <input type="number" class="form-control" id="sikap"
                                                                name="sikap" value="{{ $mhs->nilaiPkl->isNotEmpty() ? $mhs->nilaiPkl->first()->sikap : '' }}" min="0" max="100">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="komunikasi" class="form-label">Komunikasi</label>
                                                            <input type="number" class="form-control" id="komunikasi"
                                                                name="komunikasi" value="{{ $mhs->nilaiPkl->isNotEmpty() ? $mhs->nilaiPkl->first()->komunikasi : '' }}" min="0"
                                                                max="100">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="penyajian" class="form-label">Penyajian</label>
                                                            <input type="number" class="form-control" id="penyajian"
                                                                name="penyajian" value="{{ $mhs->nilaiPkl->isNotEmpty() ? $mhs->nilaiPkl->first()->penyajian : '' }}" min="0"
                                                                max="100">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="penguasaan" class="form-label">Penguasaan</label>
                                                            <input type="number" class="form-control" id="penguasaan"
                                                                name="penguasaan" value="{{ $mhs->nilaiPkl->isNotEmpty() ? $mhs->nilaiPkl->first()->penguasaan : '' }}" min="0"
                                                                max="100">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
