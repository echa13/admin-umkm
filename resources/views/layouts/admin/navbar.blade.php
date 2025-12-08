<!-- Navbar Start -->
<nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-3 shadow-sm">
    <!-- Logo kecil untuk tampilan mobile -->
    <a href="{{ route('home') }}" class="navbar-brand d-flex d-lg-none me-4 align-items-center">
        <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
    </a>

    <!-- Sidebar toggle -->
    <a href="#" class="sidebar-toggler flex-shrink-0">
        <i class="fa fa-bars fs-4"></i>
    </a>

    <!-- Search bar -->
    <form class="d-none d-md-flex ms-4">
        <input class="form-control border-0 rounded-pill px-4 py-2" type="search" placeholder="🔍  Search something...">
    </form>

    <div class="navbar-nav align-items-center ms-auto">
        @if(Auth::check())
            <!-- Jika user sudah login -->
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
                    <img class="rounded-circle me-2 border border-2 border-primary shadow-sm"
                         src="{{ asset('asset/img/user.jpg') }}"
                         alt="User"
                         style="width: 48px; height: 48px; object-fit: cover;">
                    <span class="d-none d-lg-inline-flex fw-semibold text-dark">
                        {{ Auth::user()->name }}
                    </span>
                </a>

                <!-- Dropdown -->
                <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-3 shadow-sm mt-2">
                    <a href="#" class="dropdown-item">
                        <i class="fa fa-user me-2 text-primary"></i> My Profile
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="fa fa-cog me-2 text-secondary"></i> Settings
                    </a>
                    <div class="dropdown-divider"></div>

                    <form action="{{ route('auth.logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="fa fa-sign-out-alt me-2"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        @else
            <!-- Jika belum login -->
            <a href="{{ route('login') }}" class="btn btn-primary rounded-pill px-4 py-2 ms-3 shadow-sm">
                <i class="fa fa-sign-in-alt me-2"></i>Login
            </a>
        @endif
    </div>
</nav>
<!-- Navbar End -->
