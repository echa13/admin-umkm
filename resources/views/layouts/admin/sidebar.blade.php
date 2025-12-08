<!-- Sidebar Start -->
<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-light navbar-light">
        <a href="{{ route('home') }}" class="navbar-brand mx-4 mb-3">
            <h3 class="text-primary">UMKM</h3>
        </a>

        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                {{-- Icon user: bisa diganti dengan SVG atau PNG dari Flaticon --}}
                <img class="rounded-circle"
                    src="{{ asset('asset/img/user.jpg') }}"
                    alt="User"
                    style="width: 48px; height: 48px;">
                @if(Auth::check())
                    <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"
                        style="width: 14px; height: 14px;"></div>
                @endif
            </div>
            <div class="ms-3">
                @if(Auth::check())
                    <h6 class="mb-0 fw-semibold text-dark">
                        {{ Auth::user()->name }}
                    </h6>
                    <small class="text-success">
                        <i class="fa fa-circle me-1" style="font-size:8px;"></i> Online ({{Auth::user()->role ?? 'Admin' }})
                    </small>
                @else
                    <h6 class="mb-0 fw-semibold text-secondary">
                        <i class="fa fa-user-slash me-1"></i> Guest
                    </h6>
                    <small class="text-muted">
                        <i class="fa fa-circle me-1" style="font-size:8px;"></i> Belum Login
                    </small>
                @endif
            </div>
        </div>


        <div class="navbar-nav w-100">
            <a href="{{ route('home') }}"
               class="nav-item nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                <i class="fa fa-tachometer-alt me-2"></i>Dashboard
            </a>

            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle {{ request()->routeIs('warga.*') || request()->routeIs('user.*') || request()->routeIs('umkm.*') ? 'active' : '' }}"
                   data-bs-toggle="dropdown">
                    <i class="fa fa-database me-2"></i>Master Data
                </a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="{{ route('warga.index') }}"
                       class="dropdown-item {{ request()->routeIs('warga.*') ? 'active' : '' }}">
                        <i class="fa fa-users me-2"></i>Warga
                    </a>
                    <a href="{{ route('users.index') }}"
                       class="dropdown-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <i class="fa fa-user me-2"></i>User
                    </a>
                    <a href="{{ route('umkm.index') }}"
                       class="dropdown-item {{ request()->routeIs('umkm.*') ? 'active' : '' }}">
                        <i class="fa fa-store me-2"></i>UMKM
                    </a>
                </div>
            </div>
        </div>
    </nav>
</div>
<!-- Sidebar End -->
