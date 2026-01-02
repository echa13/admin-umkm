<div class="sidebar shadow-lg">
    <nav class="sidebar-container">

        <div class="brand-section text-center">
            <a href="{{ route('home') }}" class="brand-link justify-content-center">
                <div class="logo-wrapper flex-shrink-0">
                    <img src="{{ asset('asset/img/logo-umkm.png') }}" alt="Logo">
                </div>
                <div class="brand-text text-start">
                    <h5 class="brand-title">UMKM <span>HUB</span></h5>
                    <span class="brand-subtitle">PRO PANEL</span>
                </div>
            </a>
        </div>

        <div class="user-profile-section">
            <div class="user-card-slim">
                <div class="avatar-area">
                    <img src="{{ asset('asset/img/user.jpg') }}" alt="User">
                    @if(Auth::check())
                        <div class="online-dot"></div>
                    @endif
                </div>
                <div class="user-info">
                    <p class="user-name text-truncate">{{ Auth::user()->name ?? 'Admin' }}</p>
                    <span class="user-role">{{ Auth::user()->role ?? 'Super User' }}</span>
                </div>
            </div>
        </div>

        <div class="nav-links-group">
            <p class="section-label">Main</p>
            <a href="{{ route('home') }}" class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                <i class="fa fa-th-large"></i> <span>Dashboard</span>
            </a>

            <p class="section-label">Management</p>
            <a href="{{ route('warga.index') }}" class="nav-item {{ request()->routeIs('warga.*') ? 'active' : '' }}">
                <i class="fa fa-users"></i> <span>Data Warga</span>
            </a>
            <a href="{{ route('users.index') }}" class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <i class="fa fa-user-lock"></i> <span>Akses User</span>
            </a>
            <a href="{{ route('umkm.index') }}" class="nav-item {{ request()->routeIs('umkm.*') ? 'active' : '' }}">
                <i class="fa fa-store"></i> <span>Daftar UMKM</span>
            </a>
            <a href="{{ route('produk.index') }}" class="nav-item {{ request()->routeIs('produk.*') ? 'active' : '' }}">
                <i class="fa fa-box-open"></i> <span>Daftar Produk</span>
            </a>
            <a href="{{ route('detail_pesanan.index') }}" class="nav-item {{ request()->routeIs('detail_pesanan.*') ? 'active' : '' }}">
                <i class="fa fa-list-ul"></i> <span>Detail Produk</span>
            </a>

            <p class="section-label">Transactions</p>
            <a href="{{ route('pesanan.index') }}" class="nav-item {{ request()->routeIs('pesanan.*') ? 'active' : '' }}">
                <i class="fa fa-shopping-basket"></i>
                <span>Pesanan</span>
                @if(($pendingOrders ?? 0) > 0)
                    <span class="order-badge-slim">{{ $pendingOrders }}</span>
                @endif
            </a>
            <a href="{{ route('ulasan_produk.index') }}" class="nav-item {{ request()->routeIs('ulasan_produk.*') ? 'active' : '' }}">
                <i class="fa fa-star"></i> <span>Ulasan</span>
            </a>
            <a href="{{ route('kontak') }}" class="nav-item {{ request()->routeIs('kontak.*') ? 'active' : '' }}">
                <i class="fa fa-headset"></i> <span>Info Dev</span>
            </a>
        </div>

        <div class="sidebar-footer">
            <form action="{{ route('auth.logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-link">
                    <i class="fa fa-sign-out-alt"></i> <span>Logout System</span>
                </button>
            </form>
        </div>
    </nav>
</div>

<style>
    .sidebar {
        width: 250px;
        height: 100vh;
        position: fixed;
        left: 0;
        top: 0;
        background: #0f172a;
        z-index: 1050;
        overflow: hidden;
        border-right: 1px solid rgba(255,255,255,0.05);
    }

    .sidebar-container {
        display: flex;
        flex-direction: column;
        height: 100%;
        overflow-y: auto;
        overflow-x: hidden;
    }

    .sidebar-container::-webkit-scrollbar { width: 3px; }
    .sidebar-container::-webkit-scrollbar-thumb { background: #334155; }

    .brand-section { padding: 25px 15px; border-bottom: 1px solid rgba(255,255,255,0.03); }

    .brand-link {
        display: flex;
        align-items: center;
        gap: 15px; /* Jarak antara logo dan teks diperlebar sedikit */
        text-decoration: none;
    }

    /* FIX LOGO: Menjaga proporsi agar tidak pipih dan lebih tegas */
    .logo-wrapper {
        background: #fff;
        width: 45px;          /* Ukuran kotak diperbesar */
        height: 45px;         /* Tetap kotak sempurna */
        padding: 5px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        flex-shrink: 0;       /* Mencegah kotak menyusut */
    }

    .logo-wrapper img {
        max-width: 100%;
        max-height: 100%;
        width: auto;
        height: auto;
        object-fit: contain;  /* Mencegah gambar terlihat ditarik/gepeng */
    }

    .brand-title { color: #fff; font-weight: 800; margin: 0; font-size: 1.1rem; }
    .brand-title span { color: #38bdf8; }
    .brand-subtitle { color: #475569; font-size: 0.6rem; font-weight: 800; letter-spacing: 1.5px; display: block; }

    .user-profile-section { padding: 20px 15px; }
    .user-card-slim {
        display: flex;
        align-items: center;
        background: rgba(255,255,255,0.03);
        padding: 10px;
        border-radius: 12px;
    }
    .avatar-area { position: relative; flex-shrink: 0; }
    .avatar-area img { width: 38px; height: 38px; border-radius: 10px; object-fit: cover; }
    .online-dot {
        position: absolute; bottom: -2px; right: -2px;
        width: 10px; height: 10px; background: #10b981;
        border: 2px solid #0f172a; border-radius: 50%;
    }
    .user-info { margin-left: 10px; overflow: hidden; }
    .user-name { color: #fff; font-weight: 700; font-size: 0.8rem; margin: 0; }
    .user-role { color: #64748b; font-size: 0.65rem; font-weight: 600; display: block; }

    .nav-links-group { padding: 0 12px; flex-grow: 1; }
    .section-label {
        color: #334155; font-size: 0.6rem; font-weight: 800;
        text-transform: uppercase; letter-spacing: 1px;
        margin: 20px 0 8px 10px;
    }
    .nav-item {
        display: flex; align-items: center;
        padding: 10px 14px; color: #94a3b8;
        text-decoration: none; border-radius: 10px;
        margin-bottom: 2px; font-weight: 600; font-size: 0.85rem;
        transition: 0.2s;
    }
    .nav-item i { width: 24px; font-size: 1rem; color: #475569; }
    .nav-item:hover { background: rgba(255,255,255,0.05); color: #fff; }

    .nav-item.active {
        background: #38bdf8;
        color: #fff !important;
        box-shadow: 0 4px 12px rgba(56, 189, 248, 0.2);
    }
    .nav-item.active i { color: #fff; }

    .order-badge-slim {
        margin-left: auto; background: #ef4444; color: #fff;
        font-size: 0.65rem; padding: 1px 6px; border-radius: 6px;
    }

    .sidebar-footer { padding: 20px 15px; margin-top: auto; }
    .logout-link {
        width: 100%; border: none; background: rgba(239, 68, 68, 0.1);
        color: #f87171; padding: 10px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        gap: 8px; font-size: 0.8rem; font-weight: 700; transition: 0.3s;
    }
    .logout-link:hover { background: #ef4444; color: #fff; }
</style>
