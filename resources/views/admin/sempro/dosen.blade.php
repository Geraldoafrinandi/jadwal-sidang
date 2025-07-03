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

        <div class="card mt-3">
            <div class="card-header d-flex justify-content-between">
                {{-- <h3 class="card-title">Daftar Sempro</h3> --}}
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead class="thead-light text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama Mahasiswa</th>
                            <th>Dosen Pembimbing satu</th>
                            <th>Dosen Pembimbing dua</th>
                            <th>Dosen Penguji</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @php
                            // dd($dosen->id_dosen);
                            // dd($nilaiMahasiswa->toArray());
                        @endphp
                        @forelse ($mahasiswa as $index => $sempro)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $sempro->r_mahasiswa->nama ?? 'Tidak ada data' }}</td>
                                <td>
                                    {{ optional($sempro->r_pembimbing_satu)->nama_dosen ?? 'Tidak ada data' }} -
                                    <span class="badge bg-success">
                                        {{ optional($sempro->r_nilai_pembimbing_satu)->status == '0' ? $sempro->r_nilai_pembimbing_satu->nilai_sempro : '' }}
                                    </span>
                                </td>

                                <td>
                                    {{ optional($sempro->r_pembimbing_dua)->nama_dosen ?? 'Tidak ada data' }} -
                                    <span class="badge bg-success">
                                        {{ optional($sempro->r_nilai_pembimbing_dua)->status == '1' ? $sempro->r_nilai_pembimbing_dua->nilai_sempro : '' }}
                                    </span>
                                </td>
                                <td>
                                    {{ optional($sempro->r_penguji)->nama_dosen ?? 'Tidak ada data' }} -
                                    <span class="badge bg-success">
                                        {{ optional($sempro->r_nilai_penguji)->status == '2' ? $sempro->r_nilai_penguji->nilai_sempro : '' }}
                                    </span>
                                </td>
                                <td>
                                    @if ($sempro->pembimbing_satu == $dosen->id_dosen && optional($sempro->r_nilai_pembimbing_satu)->nilai_sempro === null)
                                    <a href="{{ route('nilai.sempro.create', $sempro->id_sempro) }}" class="btn btn-warning btn-sm">
                                        Nilai
                                    </a>
                                    @elseif ($sempro->pembimbing_dua == $dosen->id_dosen && optional($sempro->r_nilai_pembimbing_dua)->nilai_sempro === null)
                                    <a href="{{ route('nilai.sempro.create', $sempro->id_sempro) }}" class="btn btn-warning btn-sm">
                                        Nilai
                                    </a>
                                    @elseif ($sempro->penguji == $dosen->id_dosen && optional($sempro->r_nilai_penguji)->nilai_sempro === null)
                                    <a href="{{ route('nilai.sempro.create', $sempro->id_sempro) }}" class="btn btn-warning btn-sm">
                                        Nilai
                                    </a>
                                    @endif

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
    </div>


    <!-- Modal Nilai -->
    {{-- @foreach ($mahasiswa as $sempro)
        <div class="modal fade" id="modalNilai{{ $sempro->id_sempro }}" tabindex="-1" role="dialog"
            aria-labelledby="modalNilaiLabel{{ $sempro->id_sempro }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalNilaiLabel{{ $sempro->id_sempro }}">Nilai Sempro -
                            {{ $sempro->judul }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('sempro.nilai.store', $sempro->id_sempro) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="pendahuluan">Mahasiswa mampu menjelaskan latar belakang, tujuan dan kontribusi
                                    penelitian</label>
                                <input type="number" step="0.1" name="pendahuluan" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="tinjauan_pustaka">Mahasiswa mampu menampilkan teori yang relevan dan dituliskan
                                    secara runtun dan lengkap dengan ddisertai argumentasi ilmiah dari pengusul
                                    teori</label>
                                <input type="number" step="0.1" name="tinjauan_pustaka" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="metodologi">Mahasiswa mampu menentukan metode yang selaras dengan permasalahan
                                    konsep teori. Detail rancangan penelitian diuraikan dengan runtun setiap tahapan dan
                                    dapat diselesaikan sesuai dengan rencana waktu penelitian</label>
                                <input type="number" step="0.1" name="metodologi" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="penggunaan_bahasa">Mahasiswa mampu menyusun naskah proposal menggunakan ejaan
                                    bahasa indonesia yang baik dan benar, serta mengikuti aturan dan panduan
                                    penelitian</label>
                                <input type="number" step="0.1" name="penggunaan_bahasa" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="presentasi">Komunikatif, ketepatan waktu, kejelasan, dan kerunutan dalam
                                    penyampaian materi</label>
                                <input type="number" step="0.1" name="presentasi" class="form-control" required>
                            </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan Nilai</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach --}}
@endsection
