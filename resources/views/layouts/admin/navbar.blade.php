<nav class="navbar navbar-expand bg-white navbar-light sticky-top px-4 py-2 border-bottom shadow-sm-thin">
    <a href="#" class="sidebar-toggler flex-shrink-0 text-decoration-none">
        <div class="bg-slate-100 rounded-circle d-flex align-items-center justify-content-center hover-scale" style="width: 40px; height: 40px;">
            <i class="fa fa-bars text-slate-600"></i>
        </div>
    </a>

    <a href="{{ route('home') }}" class="navbar-brand d-flex d-lg-none ms-3 align-items-center">
        <h4 class="text-slate-800 fw-bold mb-0"><i class="fa fa-hashtag me-1"></i></h4>
    </a>

    <form class="d-none d-md-flex ms-4" style="width: 300px;">
        <div class="input-group bg-slate-50 rounded-pill px-3 py-1 border border-slate-200 focus-within-slate">
            <span class="input-group-text bg-transparent border-0 text-slate-400">
                <i class="fa fa-search small"></i>
            </span>
            <input class="form-control border-0 bg-transparent x-small text-slate-600" type="search" placeholder="Cari data atau laporan...">
        </div>
    </form>

    <div class="navbar-nav align-items-center ms-auto">
        @if(Auth::check())
            <div class="nav-item dropdown me-3">
                <a href="#" class="nav-link text-slate-400 hover-slate-800" data-bs-toggle="dropdown">
                    <i class="fa fa-bell"></i>
                    <span class="badge rounded-circle bg-danger position-absolute top-25 start-75 translate-middle p-1 border border-white" style="font-size: .5rem;"> </span>
                </a>
            </div>

            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle d-flex align-items-center p-0" data-bs-toggle="dropdown">
                    <div class="text-end me-3 d-none d-lg-block">
                        <div class="fw-bold text-slate-800 x-small mb-0">{{ Auth::user()->name }}</div>
                        <small class="text-slate-400" style="font-size: 0.7rem;">Administrator</small>
                    </div>
                    <div class="position-relative">
                        <img class="rounded-circle border border-2 border-slate-100 shadow-sm"
                             src="{{ asset('asset/img/user.jpg') }}"
                             alt="User"
                             style="width: 42px; height: 42px; object-fit: cover;">
                        <div class="status-indicator bg-success"></div>
                    </div>
                </a>

                <div class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-4 mt-3 py-2 animate-fade-in" style="min-width: 200px;">
                    <div class="px-4 py-2 border-bottom mb-2 d-lg-none">
                        <p class="mb-0 fw-bold text-slate-800">{{ Auth::user()->name }}</p>
                        <small class="text-muted">Admin</small>
                    </div>
                    <a href="#" class="dropdown-item py-2 px-4 text-slate-600 fw-medium">
                        <i class="far fa-user-circle me-3 text-slate-400"></i>Profil Saya
                    </a>
                    <a href="#" class="dropdown-item py-2 px-4 text-slate-600 fw-medium">
                        <i class="fas fa-sliders-h me-3 text-slate-400"></i>Pengaturan
                    </a>
                    <div class="dropdown-divider border-slate-100"></div>
                    <form action="{{ route('auth.logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="dropdown-item py-2 px-4 text-danger fw-bold">
                            <i class="fas fa-power-off me-3"></i>Keluar
                        </button>
                    </form>
                </div>
            </div>
        @else
            <a href="{{ route('login') }}" class="btn btn-slate-800 rounded-pill px-4 py-2 text-white fw-bold shadow-sm transition-all" style="background: #1e293b; font-size: 0.85rem;">
                <i class="fas fa-sign-in-alt me-2"></i>Masuk Ke Sistem
            </a>
        @endif
    </div>
</nav>

<style>
    /* Slate Variables & Utility */
    .text-slate-800 { color: #1e293b !important; }
    .text-slate-600 { color: #475569 !important; }
    .text-slate-400 { color: #94a3b8 !important; }
    .bg-slate-50 { background-color: #f8fafc !important; }
    .bg-slate-100 { background-color: #f1f5f9 !important; }
    .x-small { font-size: 0.85rem; }

    .shadow-sm-thin { box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); }

    /* Custom Toggler & Hover */
    .hover-scale { transition: transform 0.2s ease; }
    .hover-scale:hover { transform: scale(1.1); background-color: #e2e8f0 !important; }
    .hover-slate-800:hover { color: #1e293b !important; }

    /* Search Bar Focus Effect */
    .focus-within-slate:focus-within {
        border-color: #94a3b8 !important;
        box-shadow: 0 0 0 3px rgba(148, 163, 184, 0.1);
        background-color: #fff !important;
    }

    /* Profile Indicator */
    .status-indicator {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 11px;
        height: 11px;
        border-radius: 50%;
        border: 2px solid #fff;
    }

    /* Dropdown Item Styling */
    .dropdown-item { transition: all 0.2s; }
    .dropdown-item:hover {
        background-color: #f8fafc;
        color: #1e293b !important;
        padding-left: 1.75rem !important; /* Animasi geser dikit */
    }

    /* Animasi Dropdown */
    .animate-fade-in {
        animation: fadeIn 0.2s ease-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
