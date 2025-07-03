@extends('admin.layout.main')

@section('title', 'Dashboard Mahasiswa')

@section('content')
    <div class="row">
        <!-- Detail Seminar Proposal -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h2>Detail Seminar Proposal</h2>
                </div>
                <div class="card-body">
                    @if($sempro)
                        <p><strong>Judul:</strong> {{ $sempro->judul }}</p>
                        <p><strong>Pembimbing 1:</strong> {{ $sempro->r_pembimbing_satu->nama_dosen }}</p>
                        <p><strong>Pembimbing 2:</strong> {{ $sempro->r_pembimbing_dua->nama_dosen }}</p>
                        <p><strong>Penguji:</strong> {{ $sempro->r_penguji->nama_dosen }}</p>
                        <p><strong>Ruangan:</strong> {{ $sempro->r_ruangan->nama_ruangan }}</p>
                        <p><strong>Sesi:</strong> {{ $sempro->r_sesi->sesi }} - {{ $sempro->r_sesi->jam }}</p>
                    @else
                        <div class="alert alert-info">
                            Tidak ada data seminar proposal.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Detail Tugas Akhir -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h2>Detail Tugas Akhir</h2>
                </div>
                <div class="card-body">
                    @if($ta)
                        <p><strong>Judul:</strong> {{ $ta->judul }}</p>
                        <p><strong>Pembimbing 1:</strong> {{ $ta->r_pembimbing_satu->nama_dosen }}</p>
                        <p><strong>Pembimbing 2:</strong> {{ $ta->r_pembimbing_dua->nama_dosen }}</p>
                        <p><strong>ketua:</strong> {{ $ta->r_ketua->nama_dosen }}</p>
                        <p><strong>Sekretaris:</strong> {{ $ta->r_sekretaris->nama_dosen }}</p>
                        <p><strong>Penguji 1:</strong> {{ $ta->r_penguji_1->nama_dosen }}</p>
                        <p><strong>Penguji 2:</strong> {{ $ta->r_penguji_2->nama_dosen }}</p>
                        <p><strong>Ruangan:</strong> {{ $ta->r_ruangan->nama_ruangan }}</p>
                        <p><strong>Sesi:</strong> {{ $ta->r_sesi->waktu_mulai }} - {{ $ta->r_sesi->waktu_selesai }}</p>
                    @else
                        <div class="">
                            Tidak ada data tugas akhir.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
