@extends('admin.layout.main')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Detail Mahasiswa</h2>

    <div class="row">
        <!-- Card Foto Mahasiswa -->
        <div class="col-md-4 mb-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h5 class="card-title">Gambar Mahasiswa</h5>
                </div>
                <div class="card-body text-center">
                    @if($mahasiswa->image && file_exists(public_path('images/mahasiswa/' . $mahasiswa->image)))
                        <img src="{{ asset('images/mahasiswa/' . $mahasiswa->image) }}" alt="Foto Profil" class="img-fluid rounded" style="max-height: 300px; width: auto;">
                    @else
                        <p class="text-muted">Tidak ada gambar tersedia.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Card Data Diri Mahasiswa -->
        <div class="col-md-8 mb-4">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title"><b>{{ $mahasiswa->nama }}</b> </h5>
                </div>
                <div class="card-body">
                    <p><strong>NIM : </strong>{{ $mahasiswa->nim}}</p>
                    <p><strong>Program Studi:</strong> {{ $mahasiswa->prodi->prodi }}</p>
                    <p><strong>Email:</strong> {{ $mahasiswa->user->email }}</p>
                    <p><strong>Password:</strong> ***** </p>
                    <p><strong>Gender:</strong> {{ $mahasiswa->gender == '1' ? 'Laki-laki' : 'Perempuan' }}</p>
                    <p><strong>Status:</strong> {{ $mahasiswa->status_mahasiswa == '1' ? 'Aktif' : 'Tidak Aktif' }}</p>
                </div>
                <div class="card-footer">
                    <a href="{{ route('mahasiswa.index') }}" class="btn btn-outline-primary mt-3">Kembali</a>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center">
        <!-- Jika ingin menambahkan tombol atau informasi tambahan, bisa ditempatkan di sini -->
    </div>
</div>
@endsection
