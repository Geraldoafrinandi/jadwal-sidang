@extends('admin.layout.main')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Detail Dosen</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <!-- Card untuk Foto Profil -->
        <div class="col-md-4 mb-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title">Foto Profil</h5>
                </div>
                <div class="card-body text-center">
                    @if($dosen->user && $dosen->user->image)
                        <img src="{{ asset('images/dosen/' . $dosen->user->image) }}" alt="Foto Profil" class="img-fluid rounded" style="max-height: 300px; width: auto;">
                    @else
                        <p class="text-muted">Tidak Ada Gambar</p>
                    @endif
                </div>
            </div>
        </div>


        <!-- Card untuk Detail Dosen -->
        <div class="col-md-8 mb-4">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title">Detail Dosen</h5>
                </div>
                <div class="card-body">
                    <p><strong>Nama Dosen:</strong> {{ $dosen->nama_dosen }}</p>
                    <p><strong>NIDN:</strong> {{ $dosen->nidn }}</p>
                    <p><strong>Email:</strong> {{ $dosen->user->email }}</p>
                    <p><strong>Password:</strong> ***** </p>
                    <p><strong>Gender:</strong> {{ ucfirst($dosen->gender == '1' ? 'Laki-laki' : 'Perempuan') }}</p>
                    <p><strong>Jurusan:</strong> {{ $dosen->jurusan ? $dosen->jurusan->nama_jurusan : 'N/A' }}</p>
                    <p><strong>Prodi:</strong> {{ $dosen->prodi ? $dosen->prodi->prodi : 'N/A' }}</p>
                    <p><strong>Golongan:</strong>
                        @switch($dosen->golongan)
                            @case('1')
                                Asisten Ahli
                                @break
                            @case('2')
                                Lector
                                @break
                            @case('3')
                                Lector Kepala
                                @break
                            @case('4')
                                Guru Besar
                                @break
                            @default
                                Tidak Dikenal
                        @endswitch
                    </p>
                    <p><strong>Status:</strong> {{ $dosen->status_dosen == '1' ? 'Aktif' : 'Tidak Aktif' }}</p>
                </div>
                <div class="card-footer">
                    <a href="{{ route('dosen.index') }}" class="btn btn-outline-primary">Kembali</a>
                    {{-- <a href="{{ route('dosen.edit', $dosen->id_dosen) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('dosen.destroy', $dosen->id_dosen) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form> --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
