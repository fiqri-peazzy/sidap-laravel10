{{-- resources/views/layouts/partials/_sidebar.blade.php --}}

@if (auth()->user()->isAdmin())
    {{-- ADMIN SIDEBAR --}}
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-medal"></i>
            </div>
            <div class="sidebar-brand-text mx-3">SIDAP PPLP <sup>Admin</sup></div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">Data Master</div>

        <!-- Nav Item - Cabang Olahraga -->
        <li
            class="nav-item {{ request()->routeIs('admin.cabang-olahraga.*') || request()->routeIs('cabang-olahraga.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.cabang-olahraga.index') }}">
                <i class="fas fa-fw fa-running"></i>
                <span>Cabang Olahraga</span>
            </a>
        </li>

        <!-- Nav Item - Klub -->
        <li class="nav-item {{ request()->routeIs('admin.klub.*') || request()->routeIs('klub.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.klub.index') }}">
                <i class="fas fa-fw fa-users"></i>
                <span>Klub</span>
            </a>
        </li>

        <!-- Nav Item - Pelatih -->
        <li
            class="nav-item {{ request()->routeIs('admin.pelatih.*') || request()->routeIs('pelatih.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.pelatih.index') }}">
                <i class="fas fa-fw fa-user-tie"></i>
                <span>Pelatih</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">Data Atlit</div>

        <!-- Nav Item - Atlit Menu -->
        <li class="nav-item {{ request()->routeIs('admin.atlit.*') || request()->routeIs('atlit.*') ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAtlit"
                aria-expanded="{{ request()->routeIs('admin.atlit.*') || request()->routeIs('atlit.*') ? 'true' : 'false' }}"
                aria-controls="collapseAtlit">
                <i class="fas fa-fw fa-user-friends"></i>
                <span>Manajemen Atlit</span>
            </a>
            <div id="collapseAtlit"
                class="collapse {{ request()->routeIs('admin.atlit.*') || request()->routeIs('atlit.*') ? 'show' : '' }}"
                aria-labelledby="headingAtlit" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Data Atlit:</h6>
                    <a class="collapse-item {{ request()->routeIs('atlit.index') ? 'active' : '' }}"
                        href="{{ route('admin.atlit.index') }}">Daftar Atlit</a>
                    <a class="collapse-item {{ request()->routeIs('atlit.create') ? 'active' : '' }}"
                        href="{{ route('admin.atlit.create') }}">Tambah Atlit</a>
                    <a class="collapse-item {{ request()->routeIs('atlit.kategori') ? 'active' : '' }}"
                        href="{{ route('admin.atlit.kategori') }}">Kategor i Atlit</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Prestasi -->
        <li class="nav-item {{ request()->routeIs('prestasi.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('prestasi.index') }}">
                <i class="fas fa-fw fa-trophy"></i>
                <span>Prestasi</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">Jadwal & Kegiatan</div>

        <!-- Nav Item - Jadwal Latihan -->
        <li
            class="nav-item {{ request()->routeIs('admin.jadwal-latihan.*') || request()->routeIs('jadwal-latihan.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.jadwal-latihan.index') }}">
                <i class="fas fa-fw fa-clock"></i>
                <span>Jadwal Latihan</span>
            </a>
        </li>

        <!-- Nav Item - Jadwal Event -->
        <li
            class="nav-item {{ request()->routeIs('admin.jadwal-event.*') || request()->routeIs('jadwal-event.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.jadwal-event.index') }}">
                <i class="fas fa-fw fa-calendar-alt"></i>
                <span>Jadwal Event</span>
            </a>
        </li>

        <!-- Nav Item - Kalender Kegiatan -->
        <li class="nav-item {{ request()->routeIs('kalender-kegiatan') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('kalender-kegiatan') }}">
                <i class="fas fa-fw fa-calendar"></i>
                <span>Kalender Kegiatan</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">Laporan</div>

        <!-- Nav Item - Laporan -->
        <li
            class="nav-item {{ request()->routeIs('admin.laporan.*') || request()->routeIs('laporan.*') ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLaporan"
                aria-expanded="{{ request()->routeIs('admin.laporan.*') || request()->routeIs('laporan.*') ? 'true' : 'false' }}"
                aria-controls="collapseLaporan">
                <i class="fas fa-fw fa-chart-bar"></i>
                <span>Laporan</span>
            </a>
            <div id="collapseLaporan"
                class="collapse {{ request()->routeIs('admin.laporan.*') || request()->routeIs('laporan.*') ? 'show' : '' }}"
                aria-labelledby="headingLaporan" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Jenis Laporan:</h6>
                    <a class="collapse-item {{ request()->routeIs('laporan.atlit') ? 'active' : '' }}"
                        href="{{ route('admin.laporan.atlit') }}">Laporan Atlit</a>
                    <a class="collapse-item {{ request()->routeIs('laporan.prestasi') ? 'active' : '' }}"
                        href="{{ route('admin.laporan.prestasi') }}">Laporan Prestasi</a>
                    <a class="collapse-item {{ request()->routeIs('laporan.statistik') ? 'active' : '' }}"
                        href="{{ route('admin.laporan.statistik') }}">Statistik</a>
                </div>
            </div>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

        <!-- Sidebar Message -->
        <div class="sidebar-card d-none d-lg-flex">
            <img class="sidebar-card-illustration mb-2" src="{{ asset('template/img/undraw_rocket.svg') }}"
                alt="...">
            <p class="text-center mb-2"><strong>Admin Panel</strong> - Kelola seluruh data sistem PPLP dengan mudah!</p>
            <a class="btn btn-success btn-sm" href="#" onclick="alert('Fitur akan segera tersedia!')">Info
                Lengkap</a>
        </div>
    </ul>
@elseif(auth()->user()->isAtlit())
    {{-- ATLIT SIDEBAR --}}
    <ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">
        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center"
            href="{{ route('atlit.dashboard') }}">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-user-athlete"></i>
            </div>
            <div class="sidebar-brand-text mx-3">SIDAP PPLP <sup>Atlit</sup></div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item {{ request()->routeIs('atlit.dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('atlit.dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">Profil Saya</div>

        <!-- Nav Item - Profil Atlit -->
        <li class="nav-item {{ request()->routeIs('atlit.profil') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('atlit.profil') }}">
                <i class="fas fa-fw fa-user"></i>
                <span>Profil Saya</span>
            </a>
        </li>
        <!-- Nav Item - Dokumen Saya -->
        <li class="nav-item {{ request()->routeIs('atlit.dokumen.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('atlit.dokumen.index') }}">
                <i class="fas fa-fw fa-file-pdf"></i>
                <span>Dokumen Saya</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">Prestasi Saya</div>

        <!-- Nav Item - Prestasi Menu -->
        <li class="nav-item {{ request()->routeIs('atlit.prestasi.*') ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePrestasi"
                aria-expanded="{{ request()->routeIs('atlit.prestasi.*') ? 'true' : 'false' }}"
                aria-controls="collapsePrestasi">
                <i class="fas fa-fw fa-trophy"></i>
                <span>Prestasi</span>
            </a>
            <div id="collapsePrestasi" class="collapse {{ request()->routeIs('atlit.prestasi.*') ? 'show' : '' }}"
                aria-labelledby="headingPrestasi" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Prestasi Saya:</h6>
                    <a class="collapse-item {{ request()->routeIs('atlit.prestasi.index') ? 'active' : '' }}"
                        href="{{ route('atlit.prestasi.index') }}">Daftar Prestasi</a>

                </div>
            </div>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">Jadwal & Kegiatan</div>

        <!-- Nav Item - Jadwal Latihan -->
        <li class="nav-item {{ request()->routeIs('atlit.jadwal-latihan.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('atlit.jadwal-latihan.index') }}">
                <i class="fas fa-fw fa-clock"></i>
                <span>Jadwal Latihan</span>
            </a>
        </li>

        <!-- Nav Item - Jadwal Event -->
        <li class="nav-item {{ request()->routeIs('atlit.jadwal-event.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('atlit.jadwal-event.index') }}">
                <i class="fas fa-fw fa-calendar-alt"></i>
                <span>Jadwal Event</span>
            </a>
        </li>

        <!-- Nav Item - Kalender -->
        <li class="nav-item {{ request()->routeIs('atlit.kalender') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('atlit.kalender') }}">
                <i class="fas fa-fw fa-calendar"></i>
                <span>Kalender Kegiatan</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

        <!-- Sidebar Message -->
        <div class="sidebar-card d-none d-lg-flex">
            <img class="sidebar-card-illustration mb-2" src="{{ asset('template/img/undraw_posting_photo.svg') }}"
                alt="...">
            <p class="text-center mb-2"><strong>Portal Atlit</strong> - Kelola profil dan prestasi Anda dengan mudah!
            </p>
            {{-- <a class="btn btn-warning btn-sm" href="{{ route('atlit.prestasi.create') }}">Upload Prestasi</a> --}}
        </div>
    </ul>
@elseif(auth()->user()->isVerifikator())
    {{-- VERIFIKATOR SIDEBAR --}}
    <ul class="navbar-nav bg-gradient-warning sidebar sidebar-dark accordion" id="accordionSidebar">
        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center"
            href="{{ route('verifikator.dashboard') }}">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-clipboard-check"></i>
            </div>
            <div class="sidebar-brand-text mx-3">SIDAP PPLP <sup>Verifikator</sup></div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item {{ request()->routeIs('verifikator.dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('verifikator.dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">Verifikasi</div>

        <!-- Nav Item - Verifikasi Prestasi -->
        <li class="nav-item {{ request()->routeIs('verifikator.prestasi.*') ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseVerifikasi"
                aria-expanded="{{ request()->routeIs('verifikator.prestasi.*') ? 'true' : 'false' }}"
                aria-controls="collapseVerifikasi">
                <i class="fas fa-fw fa-trophy"></i>
                <span>Verifikasi Prestasi</span>
            </a>
            <div id="collapseVerifikasi"
                class="collapse {{ request()->routeIs('verifikator.prestasi.*') ? 'show' : '' }}"
                aria-labelledby="headingVerifikasi" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Prestasi:</h6>
                    <a class="collapse-item {{ request()->routeIs('verifikator.prestasi.index') && !request()->has('status') ? 'active' : '' }}"
                        href="{{ route('verifikator.prestasi.index') }}">Semua Prestasi</a>
                    <a class="collapse-item {{ request()->get('status') == 'menunggu' ? 'active' : '' }}"
                        href="{{ route('verifikator.prestasi.index', ['status' => 'menunggu']) }}">
                        Menunggu Verifikasi
                        @php
                            $pendingCount = \App\Models\Prestasi::where('status', 'menunggu')->count();
                        @endphp
                        @if ($pendingCount > 0)
                            <span class="badge badge-danger badge-counter ml-1">{{ $pendingCount }}</span>
                        @endif
                    </a>
                    <a class="collapse-item {{ request()->get('status') == 'diverifikasi' ? 'active' : '' }}"
                        href="{{ route('verifikator.prestasi.index', ['status' => 'diverifikasi']) }}">Terverifikasi</a>
                    <a class="collapse-item {{ request()->get('status') == 'ditolak' ? 'active' : '' }}"
                        href="{{ route('verifikator.prestasi.index', ['status' => 'ditolak']) }}">Ditolak</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Data Atlit -->
        <li class="nav-item {{ request()->routeIs('verifikator.atlit.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('verifikator.atlit.index') }}">
                <i class="fas fa-fw fa-user-friends"></i>
                <span>Data Atlit</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">Laporan</div>

        <!-- Nav Item - Statistik Verifikasi -->
        <li class="nav-item">
            <a class="nav-link" href="#" onclick="alert('Fitur statistik verifikasi akan segera tersedia!')">
                <i class="fas fa-fw fa-chart-pie"></i>
                <span>Statistik Verifikasi</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

        <!-- Sidebar Message -->
        <div class="sidebar-card d-none d-lg-flex">
            <img class="sidebar-card-illustration mb-2" src="{{ asset('template/img/undraw_certificate.png') }}"
                alt="...">
            <p class="text-center mb-2"><strong>Panel Verifikator</strong> - Verifikasi prestasi atlit dengan teliti!
            </p>
            <a class="btn btn-info btn-sm"
                href="{{ route('verifikator.prestasi.index', ['status' => 'menunggu']) }}">Lihat Pending</a>
        </div>
    </ul>
@else
    {{-- DEFAULT SIDEBAR (fallback) --}}
    <ul class="navbar-nav bg-gradient-secondary sidebar sidebar-dark accordion" id="accordionSidebar">
        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-medal"></i>
            </div>
            <div class="sidebar-brand-text mx-3">SIDAP PPLP</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
    </ul>
@endif
