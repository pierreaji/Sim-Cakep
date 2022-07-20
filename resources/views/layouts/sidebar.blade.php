<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
        <div class="sidebar-brand-icon rotate-n-15">

            <img src="{{ asset('assets') }}/img/Logo nav.png" width="30px" alt="">
        </div>
        <div class="sidebar-brand-text mx-3">SIM Cakep
            <br>
                    <h6 style="font-size: 6px">your financial records</h6>
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Str::contains(Request::url(), 'home') ? 'active' : '' }}">
        <a class="nav-link py-2" href="{{ route('home') }}">
            <i class="fas fa-fw fa-home"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Heading -->
    @if (Auth::user()->role == 'user')
        <!-- Divider -->
        <hr class="sidebar-divider">
    <div class="sidebar-heading">
        SIM-CAKEP Menu
    </div>
        <!-- Nav Item - Tables -->
        <li class="nav-item {{ Str::contains(Request::url(), 'income') ? 'active' : '' }}">
            <a class="nav-link py-2" href="{{ route('income.index') }}">
                <i class="fas fa-fw fa-solid fa-money-check-alt"></i>
                <span>Pemasukan</span></a>
        </li>

        <!-- Nav Item - Tables -->
        <li class="nav-item {{ Str::contains(Request::url(), 'expense') ? 'active' : '' }}">
            <a class="nav-link py-2" href="{{ route('expense.index') }}">
                <i class="fas fa-fw fa-money-bill-wave-alt"></i>
                <span>Pengeluaran</span></a>
        </li>

        <!-- Nav Item - Tables -->
        <li class="nav-item {{ Str::contains(Request::url(), 'category') ? 'active' : '' }}">
            <a class="nav-link py-2" href="{{ route('category.index') }}">
                <i class="fas fa-fw fa-table"></i>
                <span>Kategori</span></a>
        </li>

        <!-- Nav Item - Tables -->
        <li class="nav-item {{ Str::contains(Request::url(), 'wishlist') ? 'active' : '' }}">
            <a class="nav-link py-2" href="{{ route('wishlist.index') }}">
                <i class="fas fa-fw fa-bullseye"></i>
                <span>WishList</span></a>
        </li>

        <li class="nav-item {{ Str::contains(Request::url(), 'report') ? 'active' : '' }}">
            <a class="nav-link py-2" href="{{ route('report.index') }}">
                <i class="fas fa-fw fa-file-export"></i>
                <span>Laporan</span></a>
        </li>
    @endif

    @if (Auth::user()->role == 'admin')
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Menu Admin
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item {{ Str::contains(Request::url(), 'users') ? 'active' : '' }}">
            <a class="nav-link py-2" href="{{ route('users.index') }}">
                <i class="fas fa-fw fa-user"></i>
                <span>Kelola Users</span></a>
        </li>
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
