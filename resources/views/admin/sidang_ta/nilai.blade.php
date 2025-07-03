@extends('admin.layout.main')

@section('content')
<div class="container">

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    @foreach ($mahasiswa as $data)
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <strong>Penilaian TA untuk Mahasiswa: {{ $data->r_mhs_sempro->r_mahasiswa->nama ?? 'Tidak ada data' }}</strong>
        </div>
        <div class="card-body">
            <div class="mb-4">
                <p><strong>Program Studi:</strong> {{ $data->r_mhs_sempro->r_mahasiswa->prodi->prodi ?? 'Tidak ada data' }}</p>
                <p><strong>Judul Tugas Akhir:</strong> {{ $data->r_mhs_sempro->judul ?? 'Tidak ada data' }}</p>
            </div>
            <form action="{{ route('ta.nilai.store', $data->id_ta) }}" method="POST">
                @csrf

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Aspek Penilaian</th>
                                <th>Bobot (%)</th>
                                <th>Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td rowspan="3" class="align-middle">1</td>
                                <td>Sikap dan Penampilan</td>
                                <td class="text-center">5</td>
                                <td><input type="number" name="presentasi_sikap_penampilan" min="0" max="100" class="form-control" required></td>
                            </tr>
                            <tr>
                                <td>Komunikasi dan Sistematika</td>
                                <td class="text-center">5</td>
                                <td><input type="number" name="presentasi_komunikasi_sistematika" min="0" max="100" class="form-control" required></td>
                            </tr>
                            <tr>
                                <td>Penguasaan Materi</td>
                                <td class="text-center">20</td>
                                <td><input type="number" name="presentasi_penguasaan_materi" min="0" max="100" class="form-control" required></td>
                            </tr>
                            <tr>
                                <td rowspan="7" class="align-middle">2</td>
                                <td>Identifikasi Masalah, Tujuan, dan Kontribusi Penelitian</td>
                                <td class="text-center">5</td>
                                <td><input type="number" name="makalah_identifikasi_masalah" min="0" max="100" class="form-control" required></td>
                            </tr>
                            <tr>
                                <td>Relevansi Teori</td>
                                <td class="text-center">5</td>
                                <td><input type="number" name="makalah_relevansi_teori" min="0" max="100" class="form-control" required></td>
                            </tr>
                            <tr>
                                <td>Metode/Algoritma</td>
                                <td class="text-center">10</td>
                                <td><input type="number" name="makalah_metode_algoritma" min="0" max="100" class="form-control" required></td>
                            </tr>
                            <tr>
                                <td>Hasil dan Pembahasan</td>
                                <td class="text-center">15</td>
                                <td><input type="number" name="makalah_hasil_pembahasan" min="0" max="100" class="form-control" required></td>
                            </tr>
                            <tr>
                                <td>Kesimpulan dan Saran</td>
                                <td class="text-center">5</td>
                                <td><input type="number" name="makalah_kesimpulan_saran" min="0" max="100" class="form-control" required></td>
                            </tr>
                            <tr>
                                <td>Bahasa dan Tata Tulis</td>
                                <td class="text-center">5</td>
                                <td><input type="number" name="makalah_bahasa_tata_tulis" min="0" max="100" class="form-control" required></td>
                            </tr>
                            <tr>
                                <td>Kesesuaian Fungsionalitas Sistem</td>
                                <td class="text-center">25</td>
                                <td><input type="number" name="produk_kesesuaian_fungsional" min="0" max="100" class="form-control" required></td>
                            </tr>

                            <input type="hidden" name="ta_id" value="{{ $data->id_ta }}">

                        </tbody>
                    </table>
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Simpan Nilai</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach
</div>
@endsection
