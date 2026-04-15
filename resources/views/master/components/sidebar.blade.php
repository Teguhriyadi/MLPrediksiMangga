<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-text mx-3">
            Dashboard Machine
        </div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Request::is('pages/dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/pages/dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <li class="nav-item {{ Request::is('pages/produksi-mangga') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/pages/produksi-mangga') }}">
            <i class="fas fa-fw fa-book"></i>
            <span>Produksi Mangga</span>
        </a>
    </li>

    <li class="nav-item {{ Request::is('pages/users') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/pages/users') }}">
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
