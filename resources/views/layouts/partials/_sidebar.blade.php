<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-medal"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SIDAP PPLP <sup>v1.0</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Data Master
    </div>

    <!-- Nav Item - Cabang Olahraga -->
    <li class="nav-item {{ request()->routeIs('cabang-olahraga.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('cabang-olahraga.index') }}">
            <i class="fas fa-fw fa-running"></i>
            <span>Cabang Olahraga</span></a>
    </li>

    <!-- Nav Item - Klub -->
    <li class="nav-item {{ request()->routeIs('klub.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('klub.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Klub</span></a>
    </li>

    <!-- Nav Item - Pelatih -->
    <li class="nav-item {{ request()->routeIs('pelatih.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('pelatih.index') }}">
            <i class="fas fa-fw fa-user-tie"></i>
            <span>Pelatih</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Data Atlit
    </div>

    <!-- Nav Item - Atlit Menu -->
    <li class="nav-item {{ request()->routeIs('atlit.*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAtlit"
            aria-expanded="{{ request()->routeIs('atlit.*') ? 'true' : 'false' }}" aria-controls="collapseAtlit">
            <i class="fas fa-fw fa-user-friends"></i>
            <span>Manajemen Atlit</span>
        </a>
        <div id="collapseAtlit" class="collapse {{ request()->routeIs('atlit.*') ? 'show' : '' }}"
            aria-labelledby="headingAtlit" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Data Atlit:</h6>
                <a class="collapse-item {{ request()->routeIs('atlit.index') ? 'active' : '' }}"
                    href="{{ route('atlit.index') }}">Daftar Atlit</a>
                <a class="collapse-item {{ request()->routeIs('atlit.create') ? 'active' : '' }}"
                    href="{{ route('atlit.create') }}">Tambah Atlit</a>
                <a class="collapse-item {{ request()->routeIs('atlit.kategori') ? 'active' : '' }}"
                    href="{{ route('atlit.kategori') }}">Kategori Atlit</a>
            </div>
        </div>
    </li>
    <!-- Nav Item - Prestasi -->
    <li class="nav-item {{ request()->routeIs('prestasi.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('prestasi.index') }}">
            <i class="fas fa-fw fa-trophy"></i>
            <span>Prestasi</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Jadwal & Kegiatan
    </div>

    <!-- Nav Item - Jadwal Latihan -->
    <li class="nav-item {{ request()->routeIs('jadwal-latihan.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('jadwal-latihan.index') }}">
            <i class="fas fa-fw fa-clock"></i>
            <span>Jadwal Latihan</span></a>
    </li>

    <!-- Nav Item - Jadwal Event -->
    <li class="nav-item {{ request()->routeIs('jadwal-event.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('jadwal-event.index') }}">
            <i class="fas fa-fw fa-calendar-alt"></i>
            <span>Jadwal Event</span></a>
    </li>

    <!-- Nav Item - Kalender Kegiatan -->
    <li class="nav-item {{ request()->routeIs('kalender-kegiatan') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('kalender-kegiatan') }}">
            <i class="fas fa-fw fa-calendar"></i>
            <span>Kalender Kegiatan</span></a>
    </li>

    <!-- Heading -->

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Laporan
    </div>

    <!-- Nav Item - Laporan -->
    <li class="nav-item {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLaporan"
            aria-expanded="{{ request()->routeIs('laporan.*') ? 'true' : 'false' }}" aria-controls="collapseLaporan">
            <i class="fas fa-fw fa-chart-bar"></i>
            <span>Laporan</span>
        </a>
        <div id="collapseLaporan" class="collapse {{ request()->routeIs('laporan.*') ? 'show' : '' }}"
            aria-labelledby="headingLaporan" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Jenis Laporan:</h6>
                <a class="collapse-item {{ request()->routeIs('laporan.atlit') ? 'active' : '' }}"
                    href="{{ route('laporan.atlit') }}">Laporan Atlit</a>
                <a class="collapse-item {{ request()->routeIs('laporan.prestasi') ? 'active' : '' }}"
                    href="{{ route('laporan.prestasi') }}">Laporan Prestasi</a>
                <a class="collapse-item {{ request()->routeIs('laporan.statistik') ? 'active' : '' }}"
                    href="{{ route('laporan.statistik') }}">Statistik</a>
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
        <img class="sidebar-card-illustration mb-2" src="{{ asset('template/img/undraw_rocket.svg') }}" alt="...">
        <p class="text-center mb-2"><strong>Sistem Data Atlit</strong> membantu mengelola data atlit dengan mudah dan
            efisien!</p>
        <a class="btn btn-success btn-sm" href="#" onclick="alert('Fitur akan segera tersedia!')">Info
            Lengkap</a>
    </div>

</ul>
<!-- End of Sidebar -->
