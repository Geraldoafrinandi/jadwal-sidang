@extends('admin.layout.main')

@section('content')
<div class="container">
    <h3>Penilaian Sempro untuk Dosen: {{ $dosen->nama }}</h3>

    @foreach ($mahasiswa as $data)
    <div class="card mb-4">
        <div class="card-header">
            <strong>Penilaian Sempro untuk Mahasiswa: {{ $data->r_mahasiswa->nama ?? 'Tidak ada data' }}</strong>
        </div>
        <div class="card-body">
            <form action="{{ route('sempro.nilai.store', $data->id_sempro) }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nilai</th>
                                <th>Aspek Penilaian</th>
                                <th>Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Row 1 -->
                            <tr>
                                <td>1</td>
                                <td>Mahasiswa mampu menjelaskan latar belakang, tujuan dan kontribusi penelitian</td>
                                <td>
                                    <input type="number" step="0.1" name="pendahuluan" class="form-control form-control-sm"
                                           value="pendahuluan" required style="width: 70px">
                                </td>
                            </tr>
                            <!-- Row 2 -->
                            <tr>
                                <td>2</td>
                                <td>Mahasiswa mampu menampilkan teori yang relevan dan dituliskan secara runtun <br> dan lengkap dengan disertai argumentasi ilmiah dari pengusul teori</td>
                                <td>
                                    <input type="number" step="0.1" name="tinjauan_pustaka" class="form-control"
                                           value="tinjauan_pustaka" required style="width: 70px">
                                </td>
                            </tr>
                            <!-- Row 3 -->
                            <tr>
                                <td>3</td>
                                <td>Mahasiswa mampu menentukan metode yang selaras dengan permasalahan konsep teori. <br> Detail rancangan penelitian diuraikan dengan runtun setiap tahapan dan dapat <br> diselesaikan sesuai dengan rencana waktu penelitian</td>
                                <td>
                                    <input type="number" step="0.1" name="metodologi" class="form-control"
                                           value="metodologi" required style="width: 70px">
                                </td>
                            </tr>
                            <!-- Row 4 -->
                            <tr>
                                <td>4</td>
                                <td>Mahasiswa mampu menyusun naskah proposal menggunakan <br> ejaan bahasa Indonesia yang baik dan benar, serta mengikuti aturan dan panduan penelitian</td>
                                <td>
                                    <input type="number" step="0.1" name="penggunaan_bahasa" class="form-control"
                                           value="penggunaan_bahasa" required style="width: 70px">
                                </td>
                            </tr>
                            <!-- Row 5 -->
                            <tr>
                                <td>5</td>
                                <td>Komunikatif, ketepatan waktu, kejelasan, dan kerunutan dalam penyampaian materi</td>
                                <td>
                                    <input type="number" step="0.1" name="presentasi" class="form-control"
                                           value="presentasi" required style="width: 70px">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Buttons aligned to the bottom -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Nilai</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach
</div>
@endsection
