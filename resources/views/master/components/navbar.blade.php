<nav class="navbar navbar-expand navbar-light topbar mb-4 static-top shadow app-topbar">

    <!-- Sidebar Toggle (Topbar) -->
    <button type="button" id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3" aria-label="Toggle sidebar">
        <i class="fa fa-bars"></i>
    </button>

    <div class="d-flex align-items-center topbar-copy" style="flex: 1 1 auto;">
        <div class="min-w-0">
            <h6 class="topbar-title d-none d-sm-block">Sistem Informasi Perkebunan Mangga</h6>
            <h6 class="topbar-title d-block d-sm-none">Mango Analytics</h6>
            <p class="topbar-subtitle d-none d-md-block">
                Dashboard prediksi, laporan, dan master data.
            </p>
        </div>
    </div>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto align-items-center">

        <li class="nav-item d-none d-md-flex align-items-center">
            <span class="topbar-chip">
                <i class="fas fa-chart-line"></i>
                Pengambilan Data Berdasarkan Waktu Tertentu
            </span>
        </li>
        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle user-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    {{ Auth::user()->nama }}
                </span>
                <img class="img-profile rounded-circle" src="{{ asset('templating/img/undraw_profile.svg') }}">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>

</nav>
