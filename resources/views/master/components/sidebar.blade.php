<ul class="navbar-nav sidebar sidebar-dark accordion app-sidebar" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/pages/dashboard') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-seedling"></i>
        </div>
        <div class="sidebar-brand-text">
            <span class="brand-title">Mango Analytics</span>
            <span class="brand-subtitle">Prediksi Produktivitas Berbasis SARIMA</span>
        </div>
    </a>

    <hr class="sidebar-divider my-0">

    <div class="sidebar-heading">
        Navigasi Utama
    </div>

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Request::is('pages/dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/pages/dashboard') }}" title="Dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <li class="nav-item {{ Request::is('pages/produksi-mangga*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/pages/produksi-mangga') }}" title="Produksi Mangga">
            <i class="fas fa-fw fa-book"></i>
            <span>Produksi Mangga</span>
        </a>
    </li>

    <li class="nav-item {{ Request::is('pages/varietas-mangga*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/pages/varietas-mangga') }}" title="Varietas Mangga">
            <i class="fas fa-fw fa-seedling"></i>
            <span>Varietas Mangga</span>
        </a>
    </li>

    <li class="nav-item {{ Request::is('pages/laporan*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/pages/laporan') }}" title="Laporan">
            <i class="fas fa-fw fa-file-download"></i>
            <span>Laporan</span>
        </a>
    </li>

    <li class="nav-item {{ Request::is('pages/users') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/pages/users') }}" title="Users">
            <i class="fas fa-fw fa-users"></i>
            <span>Users</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
