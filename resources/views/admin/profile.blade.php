@extends('admin.layout.main')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center p-2 ms-4" role="alert"
            style="background: linear-gradient(135deg, #4CAF50, #81C784); color: white; border-radius: 0.5rem; font-size: 0.875rem; max-width: 320px;">
            <i class="fas fa-check-circle mr-2" style="font-size: 1.2rem;"></i>
            <span class="ms-2">{{ session('success') }}</span>

        </div>
    @endif

    @if (session('no_update'))
        <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center p-2 ms-4" role="alert"
            style="background: #FFC107; color: #212529; border-radius: 0.375rem; font-size: 0.875rem; max-width: 320px;">
            <i class="fas fa-exclamation-circle mr-2" style="font-size: 1.2rem;"></i>
            <span class="ms-2">{{ session('no_update') }}</span>
        </div>
    @endif




    <div class="container-fluid py-4">
        <h2>Profile Pengguna</h2>

        <div class="row">
            <!-- Profile Picture Section -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Foto Profil</h5>
                    </div>
                    <div class="card-body text-center">
                        <img src="{{ Auth::user()->image && Auth::user()->image !== 'default.jpg' ? asset('images/' . (Auth::user()->role === 'mahasiswa' ? 'mahasiswa/' : 'dosen/') . Auth::user()->image) : asset('images/default.jpg') }}"
                            alt="Profile Picture" class="img-fluid rounded-circle" width="150">



                        <form action="{{ route('profile.image.update') }}" method="POST" enctype="multipart/form-data"
                            class="mt-3" id="profileImageForm">
                            @csrf
                            @method('POST') <!-- This is for updating the profile image -->
                            <input type="file" name="image" class="form-control mb-2" accept="image/*" required>

                            <!-- Button Container -->
                            <div class="d-flex justify-content-center mt-3">
                                <button type="submit" class="btn btn-primary me-2">Ganti Foto</button>
                                <button class="btn btn-danger" data-toggle="modal" data-target="#confirmDeleteModal">Hapus
                                    Foto</button>
                            </div>
                        </form>
                    </div>


                </div>
            </div>

            <!-- User Details Section -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5>Detail Pengguna</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ Auth::user()->name }}" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ Auth::user()->email }}" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Ganti Password</label>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Masukkan password baru (minimal 8 karakter)">
                            </div>
                            <button type="submit" class="btn btn-success mt-3">Perbarui</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Photo Confirmation Modal -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Hapus Foto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus foto profil? Setelah dihapus, foto profil akan diatur menjadi gambar
                    default.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <form action="{{ route('profile.image.delete') }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE') <!-- Change to DELETE -->
                        <button type="submit" class="btn btn-danger">Hapus Foto</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
