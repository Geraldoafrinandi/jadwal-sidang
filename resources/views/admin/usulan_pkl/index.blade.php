@extends('admin.layout.main')

@section('content')
    <div class="container mt-4">
        <h1>Daftar Usulan PKL</h1>

        @if ($hasRegistered && $registeredCompanyName)
    @if ($isVerified)
        <div class="alert alert-success mt-3 text-white">
            <h5>Selamat !</h5>
            Pendaftaran Anda di tempat PKL: <strong>{{ $registeredCompanyName }}</strong> sudah diverifikasi. Anda bisa melanjutkan proses PKL.
        </div>
    @else
        <div class="alert alert-warning mt-3 text-white">
            <h5>Notifikasi</h5>
            Anda sudah mendaftar di tempat PKL: <strong>{{ $registeredCompanyName }}</strong>. Anda tidak dapat mendaftar di tempat lain sampai pendaftaran Anda dikonfirmasi.
        </div>
    @endif
@endif



        {{-- @if (session('success'))
            <div class="alert alert-success mt-3 text-white">
                {{ session('success') }}
            </div>
        @endif --}}

        @if (session('error'))
            <div class="alert alert-danger mt-3 text-white">
                {{ session('error') }}
            </div>
        @endif
        @if (Auth::check() && (Auth::user()->role == 'dosen' || Auth::user()->role == 'admin'))
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Daftar Usulan PKL</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered text-center" id="dataTable">
                    <thead>
                        <tr>
                            <th>Nama Mahasiswa</th>
                            <th>Nama Tempat PKL</th>
                            <th>Konfirmasi</th>
                            @if (Auth::check() && (Auth::user()->role == 'dosen' || Auth::user()->role == 'admin'))
                                <th>Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($usulanPKL as $usulan)
                            <tr>
                                <td>{{ $usulan->mahasiswa->nama }}</td>
                                <td>{{ $usulan->tempatPKL->nama_perusahaan }}</td>
                                <td>
                                    {!! $usulan->konfirmasi == '1'
                                        ? '<span class="text-success">Sudah</span>'
                                        : '<span class="text-danger">Belum</span>' !!}
                                </td>
                                <td>
                                    @if (Auth::check() && (Auth::user()->role == 'dosen' || Auth::user()->role == 'admin'))
                                        {{-- Hanya tampilkan untuk admin dan dosen --}}
                                        <a href="{{ route('usulan_pkl.edit', $usulan->id_usulan_pkl) }}"
                                            class="btn btn-primary btn-sm">Edit</a>


                                        {{-- Hanya tampilkan untuk admin dan dosen --}}
                                        <button type="button" class="btn btn-danger btn-sm btn-delete"
                                            data-id="{{ $usulan->id_usulan_pkl }}"
                                            data-name="{{ $usulan->mahasiswa->nama }}">Hapus</button>
                                        <form action="{{ route('usulan_pkl.destroy', $usulan->id_usulan_pkl) }}"
                                            method="POST" class="delete-form d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    @endif

                                    @if (Auth::check() && (Auth::user()->role == 'dosen' || Auth::user()->role == 'admin'))
                                        @if ($usulan->konfirmasi == '0')
                                            <form action="{{ route('usulan_pkl.konfirmasi', $usulan->id_usulan_pkl) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">Konfirmasi</button>
                                            </form>
                                        @endif
                                    @endif

                                    {{-- @cannot('edit-usulan-pkl') Jika bukan admin atau dosen
                                        @if ($usulan->konfirmasi == '0')
                                            <form action="{{ route('usulan_pkl.store') }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="tempat_pkl_id" value="{{ $usulan->tempatPKL->id_perusahaan }}">
                                                <button type="submit" class="btn btn-success btn-sm">Daftar</button>
                                            </form>
                                        @endif
                                    @endcannot --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title">Daftar Tempat PKL dan Pendaftar</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered text-center">
                    <thead>
                        <tr>
                            <th>Nama Tempat PKL</th>
                            <th>Deskripsi</th>
                            <th>Kuota</th>
                            <th>Kuota Tersedia</th>
                            <th>Nama Mahasiswa yang Mendaftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            // Cek apakah pengguna sudah login
                            if (auth()->check() && auth()->user()->mahasiswa) {
                                // Ambil ID mahasiswa yang sedang login
                                $mahasiswaId = auth()->user()->mahasiswa->id_mahasiswa; // Sesuaikan dengan relasi di model
                                // Cek apakah mahasiswa sudah mendaftar di mana pun
                                $hasRegistered = \App\Models\UsulanPKL::where('mahasiswa_id', $mahasiswaId)->exists();
                            } else {
                                // Jika tidak ada mahasiswa terkait atau pengguna tidak login
                                $mahasiswaId = null;
                                $hasRegistered = false; // Atau sesuaikan dengan kebutuhan Anda
                            }
                        @endphp


                        @foreach ($tempatPKL as $tempatItem)
                            <tr>
                                <td>{{ $tempatItem->nama_perusahaan }}</td>
                                <td>{{ $tempatItem->deskripsi }}</td>
                                <td>{{ $tempatItem->kuota }}</td>
                                <td>{{ $tempatItem->kuota - $tempatItem->usulanPKL->count() }}</td>
                                <td>
                                    @if ($tempatItem->usulanPKL->isEmpty())
                                        <span class="text-muted">Belum ada pendaftar</span>
                                    @else
                                        @php
                                            $pendaftar = $tempatItem->usulanPKL->filter(function ($usulan) {
                                                return $usulan->konfirmasi == '1'; // Hanya ambil yang sudah terkonfirmasi
                                            });
                                        @endphp
                                        @if ($pendaftar->isEmpty())
                                            <span class="text-muted">Belum ada pendaftar yang terkonfirmasi</span>
                                        @else
                                            @foreach ($pendaftar as $usulan)
                                                {{ $usulan->mahasiswa->nama }}@if (!$loop->last)
                                                    ,
                                                @endif
                                            @endforeach
                                        @endif
                                    @endif
                                </td>
                                <td>

                                        @if ($tempatItem->kuota > $tempatItem->usulanPKL->count())
                                            <form action="{{ route('usulan_pkl.store') }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="tempat_pkl_id" value="{{ $tempatItem->id_perusahaan }}">
                                                <button type="submit" class="btn btn-success btn-sm"
                                                    id="daftarButton-{{ $tempatItem->id_perusahaan }}"
                                                    data-registered="{{ $hasRegistered ? 'true' : 'false' }}">
                                                    Daftar
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-muted">Kuota Penuh</span>
                                        @endif



                                </td>
                            </tr>
                        @endforeach



                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal Konfirmasi Hapus -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin menghapus usulan PKL dari mahasiswa <span id="studentName"></span>?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-danger" id="confirmDelete">Hapus</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // $(document).ready(function() {
            //     $('#dataTable').DataTable(); // Inisialisasi DataTable

            // Script konfirmasi hapus
            let deleteUrl;

            $('.btn-delete').on('click', function() {
                const id = $(this).data('id');
                const name = $(this).data('name');
                deleteUrl = $(this).siblings('.delete-form').attr('action');
                $('#studentName').text(name);
                $('#deleteModal').modal('show');
            });

            $('#confirmDelete').on('click', function() {
                $.ajax({
                    url: deleteUrl,
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}',
                    },
                    success: function() {
                        location.reload(); // Reload halaman setelah hapus
                    },
                    error: function() {
                        alert('Terjadi kesalahan saat menghapus data.');
                    }
                });
            });

            document.addEventListener('DOMContentLoaded', function () {
        // Cek jika pengguna adalah admin
        const isAdmin = {{ auth()->check() && auth()->user()->role == 'admin' ? 'true' : 'false' }};

        if (isAdmin) {
            // Ambil semua tombol dengan id yang dimulai dengan "daftarButton-"
            const buttons = document.querySelectorAll('[id^="daftarButton-"]');

            buttons.forEach(button => {
                // Nonaktifkan tombol dan tambahkan kelas disabled
                button.disabled = true;
                button.classList.add('disabled'); // Menambahkan kelas disabled untuk efek visual
                button.style.cursor = 'not-allowed'; // Mengubah kursor menjadi not-allowed

                // Hapus semua event yang bisa menyebabkan pengiriman form
                button.addEventListener('click', function (event) {
                    event.preventDefault(); // Mencegah pengiriman form
                });
            });
        }
    });

            $(document).ready(function() {
                // Tangkap semua tombol dengan atribut data-registered
                $('button[data-registered="true"]').on('mouseenter', function() {
                    // Ubah kursor menjadi not-allowed
                    $(this).css('cursor', 'not-allowed');
                });

                $('button[data-registered="true"]').on('mouseleave', function() {
                    // Kembalikan kursor ke default
                    $(this).css('cursor', ''); // Reset ke nilai default
                });

                // Cek jika pengguna sudah terdaftar
                $('button[data-registered="true"]').on('click', function(e) {
                    // Mencegah aksi klik jika sudah terdaftar
                    e.preventDefault();
                    alert('Anda sudah mendaftar untuk tempat ini!');
                });

                // Cek jika pengguna belum dikonfirmasi
                $('button[data-confirmed="false"]').on('click', function(e) {
                    // Mencegah aksi klik jika belum dikonfirmasi
                    e.preventDefault();
                    alert('Pendaftaran Anda belum dikonfirmasi!');
                });

            });
        </script>
    </div>
@endsection
