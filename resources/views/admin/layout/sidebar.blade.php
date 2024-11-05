<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4" id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="/backend">
            <img src="{{ asset('admin/assets/images/logoTI.jpg') }}" class="navbar-brand-img" height="100" width="35" alt="main_logo">
            <span class="ms-2 font-weight-bold">Teknologi Informasi</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">

    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <!-- Dashboard Link -->
            <li class="nav-item">
                <a class="nav-link {{ request()->is('grafik') ? 'active' : '' }}" href="/grafik">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>

            <!-- Home Pages Dropdown -->
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#homePagesMenu" role="button" aria-expanded="{{ request()->is('mahasiswa') || request()->is('dosen') || request()->is('prodi') || request()->is('jurusan') || request()->is('mahasiswa/create') || request()->is('mahasiswa/*/edit') || request()->is('dosen/create') || request()->is('dosen/*/edit') || request()->is('prodi/create') || request()->is('prodi/*/edit') || request()->is('jurusan/create') || request()->is('jurusan/*/edit') ? 'true' : 'false' }}" aria-controls="homePagesMenu">
                    <h6 class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Data Master</h6>
                </a>
                <div class="collapse {{ request()->is('mahasiswa') || request()->is('dosen') || request()->is('prodi') || request()->is('jurusan') || request()->is('mahasiswa/create') || request()->is('mahasiswa/*/edit') || request()->is('dosen/create') || request()->is('dosen/*/edit') || request()->is('prodi/create') || request()->is('prodi/*/edit') || request()->is('jurusan/create') || request()->is('jurusan/*/edit') ? 'show' : '' }}" id="homePagesMenu">
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
                            <a class="nav-link {{ request()->is('jurusan') ? 'active' : '' }}" href="/jurusan">
                                <i class="ni ni-hat-3 text-info text-sm opacity-10 me-2"></i>
                                Jurusan
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- PKL Management Dropdown -->
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#pklMenu" role="button" aria-expanded="{{ request()->is('tempat_pkl') || request()->is('usulan_pkl') || request()->is('ver_pkl') || request()->is('tempat_pkl/create') || request()->is('tempat_pkl/*/edit') || request()->is('usulan_pkl/create') || request()->is('usulan_pkl/*/edit') || request()->is('ver_pkl/create') || request()->is('ver_pkl/*/edit') ? 'true' : 'false' }}" aria-controls="pklMenu">
                    <h6 class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6">PKL</h6>
                </a>
                <div class="collapse {{ request()->is('tempat_pkl') || request()->is('usulan_pkl') || request()->is('ver_pkl') || request()->is('tempat_pkl/create') || request()->is('tempat_pkl/*/edit') || request()->is('usulan_pkl/create') || request()->is('usulan_pkl/*/edit') || request()->is('ver_pkl/create') || request()->is('ver_pkl/*/edit') ? 'show' : '' }}" id="pklMenu">
                    <ul class="ps-1">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('tempat_pkl') ? 'active' : '' }}" href="/tempat_pkl">
                                <i class="ni ni-building text-danger text-sm opacity-10 me-2"></i>
                                Tempat PKL
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('usulan_pkl') ? 'active' : '' }}" href="/usulan_pkl">
                                <i class="ni ni-building text-danger text-sm opacity-10 me-2"></i>
                                Usulan PKL
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('ver_pkl') ? 'active' : '' }}" href="/ver_pkl">
                                <i class="ni ni-building text-danger text-sm opacity-10 me-2"></i>
                                Verifikasi PKL
                            </a>
                        </li>
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
