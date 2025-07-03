@extends('admin.layout.main')

@section('content')
    <div class="container mt-4">
        <h3 class="card-title">Daftar ta</h3>

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
                {{-- <h3 class="card-title">Daftar ta</h3> --}}
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead class="thead-light text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama Mahasiswa</th>
                            <th>Ketua Sidang</th>
                            <th>Sekretaris</th>
                            <th>Penguji 1</th>
                            <th>Penguji 2</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @php
                            // dd($dosen->id_dosen);
                            // dd($nilaiMahasiswa->toArray());
                        @endphp
                        @forelse ($mahasiswa as $index => $ta)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $ta->r_mhs_sempro->r_mahasiswa->nama ?? 'Tidak ada data' }}</td>
                                <td>
                                    {{ optional($ta->r_ketua)->nama_dosen ?? 'Tidak ada data' }} -
                                    <span class="badge bg-success">
                                        {{ optional($ta->r_nilai_ketua)->status == '0' ? $ta->r_nilai_ketua->nilai_sidang : '' }}
                                    </span>
                                </td>

                                <td>
                                    {{ optional($ta->r_sekretaris)->nama_dosen ?? 'Tidak ada data' }} -
                                    <span class="badge bg-success">
                                        {{ optional($ta->r_nilai_sekretaris)->status == '1' ? $ta->r_nilai_sekretaris->nilai_sidang : '' }}
                                    </span>
                                </td>
                                <td>
                                    {{ optional($ta->r_penguji_1)->nama_dosen ?? 'Tidak ada data' }} -
                                    <span class="badge bg-success">
                                        {{ optional($ta->r_nilai_penguji_1)->status == '2' ? $ta->r_nilai_penguji_1->nilai_sidang : '' }}
                                    </span>
                                </td>
                                <td>
                                    {{ optional($ta->r_penguji_2)->nama_dosen ?? 'Tidak ada data' }} -
                                    <span class="badge bg-success">
                                        {{ optional($ta->r_nilai_penguji_2)->status == '3' ? $ta->r_nilai_penguji_2->nilai_sidang : '' }}
                                    </span>
                                </td>
                                <td>
                                    @if ($ta->r_ketua && $ta->r_ketua->id_dosen == $dosen->id_dosen && optional($ta->r_nilai_ketua)->nilai_sidang === null)
                                        <a href="{{ route('ta.nilai.create', $ta->id_ta) }}" class="btn btn-warning btn-sm">
                                            Nilai
                                        </a>
                                    @elseif ($ta->r_sekretaris && $ta->r_sekretaris->id_dosen == $dosen->id_dosen && optional($ta->r_nilai_sekretaris)->nilai_sidang === null)
                                        <a href="{{ route('ta.nilai.create', $ta->id_ta) }}" class="btn btn-warning btn-sm">
                                            Nilai
                                        </a>
                                    @elseif ($ta->r_penguji_1 && $ta->r_penguji_1->id_dosen == $dosen->id_dosen && optional($ta->r_nilai_penguji_1)->nilai_sidang === null)
                                        <a href="{{ route('ta.nilai.create', $ta->id_ta) }}" class="btn btn-warning btn-sm">
                                            Nilai
                                        </a>
                                    @elseif ($ta->r_penguji_2 && $ta->r_penguji_2->id_dosen == $dosen->id_dosen && optional($ta->r_nilai_penguji_2)->nilai_sidang === null)
                                        <a href="{{ route('ta.nilai.create', $ta->id_ta) }}" class="btn btn-warning btn-sm">
                                            Nilai
                                        </a>
                                    @endif
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data ta.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- Modal Nilai -->
    {{-- @foreach ($mahasiswa as $ta)
        <div class="modal fade" id="modalNilai{{ $ta->id_ta }}" tabindex="-1" role="dialog"
            aria-labelledby="modalNilaiLabel{{ $ta->id_ta }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalNilaiLabel{{ $ta->id_ta }}">Nilai ta -
                            {{ $ta->judul }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('ta.nilai.store', $ta->id_ta) }}" method="POST">
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
