@extends('admin.layout.main')

@section('title', 'Nilai Bimbingan PKL')

@section('content')
<div class="container">
    <h1 class="mb-4">Nilai Bimbingan PKL</h1>

    @if ($mahasiswa->isEmpty())
        <div class="alert alert-warning">
            Tidak ada mahasiswa yang dapat dinilai.
        </div>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Mahasiswa</th>
                    <th>NIM</th>
                    <th>Program Studi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($mahasiswa as $mhs)
                    <tr>
                        <td>{{ $mhs->nama }}</td>
                        <td>{{ $mhs->nim }}</td>
                        <td>{{ $mhs->prodi->nama_prodi }}</td>
                        <td>
                            <a href="{{ route('nilai_bimbingan_pkl.create', $mhs->id_mahasiswa) }}" class="btn btn-primary">
                                Beri Nilai
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
