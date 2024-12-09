@extends('admin.layout.main')

@section('title', 'Daftar Bimbingan PKL')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <h4 class="mb-4">Daftar Bimbingan PKL</h4>

                @if (session('success'))
                    <div class="alert alert-success text-white">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        @if (isset($jumlahBimbingan)  < 16)
                        <a href="{{ route('bimbingan_pkl.create') }}" class="btn btn-primary">
                            Tambah Bimbingan
                        </a>
                    @else
                        <button type="button" class="btn btn-primary" disabled>
                            Batas Maksimal Tercapai
                        </button>
                    @endif

                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    {{-- <th>Nama Mahasiswa</th> --}}
                                    <th>Kegiatan</th>
                                    <th>Tanggal Awal</th>
                                    <th>Tanggal Akhir</th>
                                    <th>Komentar</th>
                                    <th>File Dokumentasi</th>
                                    {{-- <th>Nilai</th> <!-- Kolom nilai baru -->
                                    @if (Auth::check() && Auth::user()->role == 'admin')
                                        <th>Aksi</th>
                                    @endif --}}
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @forelse ($bimbinganPKL as $key => $bimbingan)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        {{-- <td>{{ $bimbingan->mhsPkl->usulanPkl->mahasiswa->nama ?? 'Tidak ada data' }}</td> --}}
                                        <td>{{ $bimbingan->kegiatan }}</td>
                                        <td>{{ $bimbingan->tgl_kegiatan_awal }}</td>
                                        <td>{{ $bimbingan->tgl_kegiatan_akhir }}</td>
                                        <td>
                                            {{-- @if ($bimbingan->status == '1') <!-- Periksa jika status sudah diverifikasi --> --}}
                                                <!-- Menampilkan komentar jika sudah diverifikasi -->
                                                <span class="">{{ $bimbingan->komentar ?: 'Tidak ada komentar' }}</span>
                                            {{-- @else
                                                <span class="badge bg-warning">Belum <br> Dikonfirmasi</span>
                                            @endif --}}
                                        </td>

                                        <td>
                                            @if ($bimbingan->file_dokumentasi)
                                                <a href="{{ asset('storage/' . $bimbingan->file_dokumentasi) }}"
                                                    target="_blank" class="btn btn-sm btn-info">
                                                    Lihat File
                                                </a>
                                            @else
                                                Tidak Ada
                                            @endif
                                        </td>
                                        {{-- <td>
                                            @if ($bimbingan->nilaiBimbingan)
                                                <!-- Jika nilai sudah ada, tampilkan nilai -->
                                                <span class="badge bg-info d-block text-center" style="word-wrap: break-word;">
                                                    {{ number_format($bimbingan->nilaiBimbingan->nilai_bimbingan, 2) }}
                                                </span>
                                            @else
                                                <!-- Jika nilai belum ada, tampilkan status "Belum Dinilai" dan tombol untuk input nilai -->
                                                <span class="badge bg-danger d-block text-center" style="word-wrap: break-word;">
                                                    Belum <br> dinilai
                                                </span>
                                                <button class="btn btn-sm btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#nilaiModal{{ $bimbingan->id }}">Input Nilai</button>
                                            @endif
                                        </td> --}}



                                        @if (Auth::user()->role === 'admin')
                                            <td>
                                                <a href="{{ route('bimbingan_pkl.edit', $bimbingan->id) }}"
                                                    class="btn btn-sm btn-warning">Edit</a>
                                                <form action="{{ route('bimbingan_pkl.destroy', $bimbingan->id) }}"
                                                    method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
                                                </form>
                                            </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Data bimbingan PKL belum tersedia.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
