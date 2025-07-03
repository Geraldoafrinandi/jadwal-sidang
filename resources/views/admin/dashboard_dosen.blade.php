@extends('admin.layout.main')

@section('title', 'Dashboard Dosen')

@section('content')
    <div class="container-fluid">
        {{-- <h1 class="mb-4">Dashboard Dosen</h1> --}}

        <!-- Card untuk Mahasiswa Seminar Proposal yang Dibimbing -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h2 class="m-0 font-weight-bold ">Mahasiswa Seminar Proposal yang Dibimbing</h2>
            </div>
            <div class="card-body">
                @if($mahasiswaSempro->isEmpty())
                    <div class="">
                        Tidak ada mahasiswa seminar proposal yang dibimbing.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nama Mahasiswa</th>
                                    <th>Judul</th>
                                    <th>Ruangan</th>
                                    <th>Waktu Sidang</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($mahasiswaSempro as $sempro)
                                    <tr>
                                        <td>{{ $sempro->r_mahasiswa->nama }}</td>
                                        <td>{{ $sempro->judul }}</td>
                                        <td>{{ $sempro->r_ruangan->ruangan }}</td>
                                        <td>{{ $sempro->r_sesi->sesi }} - {{ $sempro->r_sesi->jam }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        <!-- Card untuk Mahasiswa Tugas Akhir yang Diuji -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h2 class="m-0 font-weight-bold">Mahasiswa Tugas Akhir yang Diuji</h2>
            </div>
            <div class="card-body">
                @if($mahasiswaTa->isEmpty())
                    <div class="alert alert-info">
                        Tidak ada mahasiswa tugas akhir yang diuji.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                            <thead>
                                <tr class="text-center">
                                    <th>Nama Mahasiswa</th>
                                    <th>Judul</th>
                                    <th>Ruangan</th>
                                    <th>Waktu Sidang</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach($mahasiswaTa as $ta)
                                    <tr>
                                        <td>{{ $ta->r_mhs_sempro->r_mahasiswa->nama }}</td>
                                        <td>{{ $ta->r_mhs_sempro->judul }}</td>
                                        <td>{{ $ta->r_ruangan->ruangan }}</td>
                                        <td>{{ $ta->r_sesi->sesi }} - {{ $ta->r_sesi->jam }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
