@extends('admin.layout.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

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
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Detail Mahasiswa PKL</h3>
            </div>
            <div class="card-body">
                <form class="form-sample" method="POST" enctype="multipart/form-data"
                action="{{ route('mhs_pkl.update', $data_pkl ? $data_pkl->id_mhs_pkl : '') }}"
                    >
                    @csrf
                    @method('PUT')

                    <!-- Nama Mahasiswa -->
                    <div class="mb-3 row d-flex align-items-center">
                        <label class="col-sm-4 col-form-label fw-bold mb-0">Nama Mahasiswa</label>
                        <div class="col-sm-4 mb-0">
                            <input type="text" class="form-control" value="{{ auth()->user()->mahasiswa->nama }}"
                                readonly>
                        </div>
                    </div>


                    <!-- Tahun PKL -->
                    <div class="mb-3 row d-flex align-items-center">
                        <label class="col-sm-4 col-form-label fw-bold mb-0">Tahun PKL</label>
                        <div class="col-sm-4 mb-0">
                            <input type="text" class="form-control" value="{{ $data_pkl->tahun_pkl }}" readonly>
                        </div>
                    </div>



                    <!-- Dosen Pembimbing -->
                    <div class="mb-3 row d-flex align-items-center">
                        <label class="col-sm-4 col-form-label fw-bold mb-0">Dosen Pembimbing</label>
                        <div class="col-sm-4 mb-0">
                            <input type="text" class="form-control" name="dosen_pembimbing"
                                value="{{ old('dosen_pembimbing', $data_pkl->dosenPembimbing ? $data_pkl->dosenPembimbing->nama_dosen : '') }}"
                                placeholder="Nama Dosen Pembimbing" readonly>
                        </div>
                    </div>




                    <!-- Pembimbing Industri -->
                    <div class="mb-3 row d-flex align-items-center">
                        <label class="col-sm-4 col-form-label fw-bold mb-0">Pembimbing PKL</label>
                        <div class="col-sm-4 mb-0">
                            <input type="text" class="form-control" name="pembimbing_pkl"
                                value="{{ old('pembimbing_pkl', $data_pkl->pembimbing_pkl) }}"
                                placeholder="Masukkan Dosen Pembimbing Industri">

                        </div>
                    </div>

                    <!-- Judul PKL -->
                    <div class="mb-3 row d-flex align-items-center">
                        <label class="col-sm-4 col-form-label fw-bold mb-0">Judul PKL</label>
                        <div class="col-sm-4 mb-0">
                            <input type="text" class="form-control" name="judul"
                                value="{{ old('judul', $data_pkl->judul) }}" placeholder="Masukkan Judul PKL">
                        </div>
                    </div>




                    <!-- Tanggal Sidang -->
                    {{-- <div class="mb-3 row d-flex align-items-center">
                        <label class="col-sm-4 col-form-label fw-bold">Tanggal Sidang</label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" name="tgl_sidang"
                                value="{{ old('tgl_sidang', $data_pkl->tgl_sidang) }}">
                        </div>
                    </div> --}}

                    <!-- Dokumen Nilai Industri -->
                    <div class="mb-3 row d-flex align-items-center">
                        <label class="col-sm-4 col-form-label fw-bold">Dokumen Nilai Industri</label>
                        <div class="col-sm-4">
                            <input type="file" name="dokumen_nilai_industri" class="form-control"
                                id="dokumen_nilai_industri">
                            @if ($data_pkl->dokumen_nilai_industri)
                                <small class="d-block mt-2">
                                    Current file:
                                    <a href="{{ asset('storage/uploads/mahasiswa/dokumen_nilai_industri/' . $data_pkl->dokumen_nilai_industri) }}"
                                        target="_blank">
                                        {{ $data_pkl->dokumen_nilai_industri }}
                                    </a>
                                </small>
                            @endif
                        </div>
                    </div>

                    <!-- Laporan PKL -->
                    <div class="mb-3 row d-flex align-items-center">
                        <label class="col-sm-4 col-form-label fw-bold">Laporan PKL</label>
                        <div class="col-sm-4">
                            <input type="file" name="laporan_pkl" class="form-control" id="laporan_pkl">
                            @if ($data_pkl->laporan_pkl)
                                <small class="d-block mt-2">
                                    Current file:
                                    <a href="{{ asset('storage/uploads/mahasiswa/laporan_pkl/' . $data_pkl->laporan_pkl) }}" target="_blank">
                                        {{ $data_pkl->laporan_pkl }}
                                    </a>
                                </small>
                            @endif
                        </div>
                    </div>


                    <!-- Tombol Update -->
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
