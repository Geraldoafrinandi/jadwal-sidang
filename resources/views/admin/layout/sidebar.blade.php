<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="/backend">
            <img src="{{ asset('admin/assets/images/logoTI.jpg') }}" class="navbar-brand-img" height="100"
                width="35" alt="main_logo">
            <span class="ms-2 font-weight-bold">Teknologi Informasi</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">

    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <!-- Dashboard Link -->
            <li class="nav-item">
                <a class="nav-link {{ request()->is('grafik') ? 'active' : '' }}" href="/grafik">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>

            <!-- Home Pages Dropdown -->
            @if (Auth::check() && (Auth::user()->role == 'dosen' || Auth::user()->role == 'admin'))
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#homePagesMenu" role="button"
                        aria-expanded="{{ request()->is('mahasiswa*') ||request()->is('pimpinan')||request()->is('sesi')||request()->is('jabatan_pimpinan')|| request()->is('dosen*') || request()->is('prodi*') || request()->is('jurusan*') ? 'true' : 'false' }}"
                        aria-controls="homePagesMenu">
                        <h6 class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Data Master</h6>
                    </a>
                    <div class="collapse {{ request()->is('mahasiswa*') ||request()->is('pimpinan')||request()->is('sesi')||request()->is('jabatan_pimpinan')|| request()->is('dosen*') || request()->is('prodi*') || request()->is('jurusan*') ? 'show' : '' }}"
                        id="homePagesMenu">
                        <ul class="ps-1">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('mahasiswa') ? 'active' : '' }}" href="/mahasiswa">
                                    <i class="ni ni-single-02 text-dark text-sm opacity-10 me-2"></i>
                                    Mahasiswa
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('dosen') ? 'active' : '' }}" href="/dosen">
                                    <i class="ni ni-single-02 text-warning text-sm opacity-10 me-2"></i>
                                    Dosen
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('prodi') ? 'active' : '' }}" href="/prodi">
                                    <i class="ni ni-books text-info text-sm opacity-10 me-2"></i>
                                    Prodi
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('jabatan_pimpinan') ? 'active' : '' }}" href="/jabatan_pimpinan">
                                    <i class="ni ni-books text-info text-sm opacity-10 me-2"></i>
                                    Jabatan Pimpinan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('pimpinan') ? 'active' : '' }}" href="/pimpinan">
                                    <i class="ni ni-books text-info text-sm opacity-10 me-2"></i>
                                    Pimpinan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('sesi') ? 'active' : '' }}" href="/sesi">
                                    <i class="ni ni-books text-info text-sm opacity-10 me-2"></i>
                                    Sesi
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('jurusan') ? 'active' : '' }}" href="/jurusan">
                                    <i class="ni ni-hat-3 text-info text-sm opacity-10 me-2"></i>
                                    Jurusan
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif

            <!-- PKL Management Dropdown -->
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#pklMenu" role="button"
                    aria-expanded="{{ request()->is('tempat_pkl', 'usulan_pkl','nilai_pkl', 'ver_pkl', 'bimbingan_pkl*', 'bimbingan-pkl/dosen', 'tempat_pkl/create', 'usulan_pkl/create', 'ver_pkl/create', 'tempat_pkl/*/edit', 'usulan_pkl/*/edit', 'ver_pkl/*/edit','bimbingan_pkl.dosen') ? 'true' : 'false' }}"
                    aria-controls="pklMenu">
                    <h6 class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6">PKL</h6>
                </a>

                <div class="collapse {{ request()->is('tempat_pkl', 'nilai_pkl', '/bimbingan-pkl/dosen', 'daftar_pkl', 'usulan_pkl', 'ver_pkl', 'bimbingan_pkl*', 'tempat_pkl/create', 'usulan_pkl/create', 'ver_pkl/create', 'tempat_pkl/*/edit', 'usulan_pkl/*/edit', 'ver_pkl/*/edit') || request()->routeIs('mhs_pkl.edit', 'konfirmasi_pkl.index', 'bimbingan_pkl.dosen') ? 'show' : '' }}"
                    id="pklMenu">
                    <ul class="ps-1">
                        {{-- Mahasiswa Role --}}
                        @if (Auth::check() && Auth::user()->role == 'mahasiswa')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('usulan_pkl') ? 'active' : '' }}"
                                    href="/usulan_pkl">
                                    <i class="ni ni-building text-danger text-sm opacity-10 me-2"></i>
                                    Usulan PKL
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('mhs_pkl.edit') ? 'active' : '' }}"
                                    href="/mhs_pkl/edit">
                                    <i class="ni ni-building text-danger text-sm opacity-10 me-2"></i>
                                    Daftar PKL
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('bimbingan_pkl*') ? 'active' : '' }}"
                                    href="{{ route('bimbingan_pkl.index') }}">
                                    <i class="ni ni-folder-17 text-success text-sm opacity-10 me-2"></i>
                                    Bimbingan PKL
                                </a>
                            </li>
                        @endif
                        @if (Auth::check() && Auth::user()->role == 'dosen')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('/bimbingan-pkl/dosen') ? 'active' : '' }}"
                                    href="{{ route('bimbingan_pkl.dosen') }}">
                                    <i class="ni ni-folder-17 text-success text-sm opacity-10 me-2"></i>
                                    Bimbingan PKL
                                </a>
                            </li>
                        @endif

                        {{-- Admin and Dosen Role --}}
                        @if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role == 'dosen'))
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('daftar_pkl') ? 'active' : '' }}"
                                    href="/daftar_pkl">
                                    <i class="ni ni-building text-danger text-sm opacity-10 me-2"></i>
                                    Mahasiswa PKL
                                </a>
                                <a class="nav-link" href="{{ route('admin.mhs_pkl.index') }}">
                                    <i class="ni ni-folder-17 text-success text-sm opacity-10 me-2"></i>
                                    <span>Nilai PKL</span>
                                </a>


                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('tempat_pkl') ? 'active' : '' }}"
                                    href="/tempat_pkl">
                                    <i class="ni ni-building text-danger text-sm opacity-10 me-2"></i>
                                    Tempat PKL
                                </a>
                            </li>
                        @endif

                        {{-- Admin Role --}}
                        @if (Auth::check() && Auth::user()->role == 'admin')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('konfirmasi_pkl.index') ? 'active' : '' }}"
                                    href="{{ route('konfirmasi_pkl.index') }}">
                                    <i class="ni ni-building text-danger text-sm opacity-10 me-2"></i>
                                    Usulan PKL Kaprodi
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </li>


            <!-- Account Pages -->
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Account Pages</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/profile">
                    <i class="ni ni-circle-08 text-primary text-sm opacity-10 me-2"></i>
                    Profile
                </a>
            </li>
            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a class="nav-link" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        <i class="ni ni-user-run text-danger text-sm opacity-10 me-2"></i>
                        Log Out
                    </a>
                </form>
            </li>
        </ul>
    </div>
</aside>
