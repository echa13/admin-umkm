@extends('layouts.admin.app')

@section('content')
<div class="container-fluid py-4 px-4">
    <div class="header-box d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-slate-400 small">Dashboard</a></li>
                    <li class="breadcrumb-item active small text-slate-500" aria-current="page">User Management</li>
                </ol>
            </nav>
            <h2 class="fw-black text-slate-800 m-0 tracking-tight">Daftar <span class="text-sky">User</span></h2>
            <p class="text-slate-500 small mb-0">Kelola hak akses dan informasi autentikasi pengguna sistem.</p>
        </div>
        <div class="action-area">
            <a href="{{ route('users.create') }}" class="btn btn-elite-primary shadow-sm">
                <i class="fas fa-user-plus me-2"></i> Tambah User
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-elite-success d-flex align-items-center mb-4" role="alert">
            <i class="fas fa-check-circle me-3"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card elite-card border-0 shadow-sm mb-4">
        <div class="card-body p-3">
            <form action="{{ route('users.index') }}" method="GET" class="row g-2">
                <div class="col-md-10">
                    <div class="input-group input-group-elite">
                        <span class="input-group-text bg-transparent border-end-0"><i class="fas fa-search text-slate-400"></i></span>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control border-start-0 ps-0" placeholder="Cari berdasarkan nama lengkap atau alamat email...">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-slate-900 w-100 fw-bold">Cari User</button>
                </div>
            </form>
        </div>
    </div>

    @if ($users->isEmpty())
        <div class="card elite-card border-0 py-5 text-center">
            <div class="card-body">
                <i class="fas fa-users-slash fa-4x text-slate-200 mb-3"></i>
                <h5 class="fw-bold text-slate-700">Data Tidak Ditemukan</h5>
                <p class="text-slate-400">Tidak ada user yang sesuai dengan kriteria pencarian Anda.</p>
                <a href="{{ route('users.index') }}" class="btn btn-link text-sky fw-bold text-decoration-none">Lihat Semua User</a>
            </div>
        </div>
    @else
        <div class="row g-4">
            @foreach ($users as $user)
                <div class="col-12 col-sm-6 col-md-4 col-xl-3">
                    <div class="card user-elite-card border-0 shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <div class="avatar-ring mx-auto mb-3">
                                @php $foto = $user->media->first(); @endphp
                                <img src="{{ $foto ? asset('storage/user_media/' . $foto->file_name) : asset('asset/img/default.png') }}"
                                     alt="User Profile">
                            </div>

                            <h6 class="fw-black text-slate-800 mb-1">{{ $user->name }}</h6>
                            <div class="text-slate-500 x-small mb-3 text-truncate">{{ $user->email }}</div>

                            <div class="user-meta mb-4">
                                <div class="meta-item">
                                    <span class="label">Bergabung</span>
                                    <span class="value">{{ $user->created_at->format('d M Y') }}</span>
                                </div>
                            </div>

                            <div class="action-bundle justify-content-center border-top pt-3">
                                <a href="{{ route('users.show', $user->id) }}" class="btn-action btn-view" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('users.edit', $user->id) }}" class="btn-action btn-edit" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete"
                                            onclick="return confirm('Hapus user ini?')" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-5 d-flex justify-content-center">
            {{ $users->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

<style>
    /* UNIFIED VARIABLES */
    :root {
        --slate-900: #0f172a;
        --slate-800: #1e293b;
        --slate-600: #475569;
        --slate-500: #64748b;
        --slate-400: #94a3b8;
        --slate-200: #e2e8f0;
        --sky: #38bdf8;
    }

    .fw-black { font-weight: 900; }
    .tracking-tight { letter-spacing: -1px; }
    .text-sky { color: var(--sky) !important; }
    .x-small { font-size: 0.75rem; }

    /* CARD STYLE */
    .elite-card { background: #fff; border-radius: 12px; overflow: hidden; }

    .user-elite-card {
        background: #fff;
        border-radius: 20px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .user-elite-card::before {
        content: "";
        position: absolute;
        top: 0; left: 0; right: 0; height: 4px;
        background: var(--slate-900);
        opacity: 0; transition: 0.3s;
    }

    .user-elite-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(15, 23, 42, 0.08) !important;
    }

    .user-elite-card:hover::before { opacity: 1; }

    /* AVATAR RING */
    .avatar-ring {
        width: 85px; height: 85px;
        padding: 5px;
        background: #fff;
        border: 2px solid var(--slate-200);
        border-radius: 50%;
        transition: 0.3s;
    }

    .user-elite-card:hover .avatar-ring {
        border-color: var(--sky);
        transform: scale(1.05);
    }

    .avatar-ring img {
        width: 100%; height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }

    /* USER META */
    .user-meta {
        display: flex;
        justify-content: center;
        gap: 15px;
        background: #f8fafc;
        padding: 8px;
        border-radius: 12px;
    }

    .meta-item { display: flex; flex-direction: column; }
    .meta-item .label { font-size: 0.6rem; text-transform: uppercase; color: var(--slate-400); font-weight: 800; }
    .meta-item .value { font-size: 0.75rem; font-weight: 700; color: var(--slate-800); }

    /* BUTTONS & INPUTS */
    .btn-elite-primary {
        background: var(--sky); color: white; font-weight: 700;
        padding: 10px 24px; border-radius: 10px; border: none; transition: 0.3s;
    }
    .btn-slate-900 { background: var(--slate-900); color: white; border-radius: 8px; padding: 10px; transition: 0.3s; }
    .btn-slate-900:hover { background: #000; color: white; }

    .input-group-elite .form-control {
        border: 1px solid var(--slate-200);
        padding: 10px 15px;
        font-size: 0.9rem;
        border-radius: 8px;
    }
    .input-group-elite .input-group-text { border: 1px solid var(--slate-200); border-radius: 8px; }

    /* ACTIONS (UNIFIED) */
    .action-bundle { display: flex; gap: 8px; }
    .btn-action {
        width: 35px; height: 35px; display: flex;
        align-items: center; justify-content: center;
        border-radius: 10px; transition: 0.2s; text-decoration: none; border: none;
    }
    .btn-view { background: #f1f5f9; color: var(--slate-600); }
    .btn-edit { background: rgba(255, 193, 7, 0.1); color: #ffc107; }
    .btn-delete { background: rgba(239, 68, 68, 0.1); color: #ef4444; }

    .btn-view:hover { background: var(--slate-900); color: white; }
    .btn-edit:hover { background: #ffc107; color: white; }
    .btn-delete:hover { background: #ef4444; color: white; }

    /* PAGINATION */
    .page-link { border: none; color: var(--slate-600); border-radius: 8px !important; margin: 0 3px; font-weight: 600; }
    .page-item.active .page-link { background: var(--slate-900); color: white; }

    /* ALERT SUCCESS */
    .alert-elite-success {
        background: #f0fdf4; border: 1px solid #bbf7d0;
        color: #166534; border-radius: 12px; font-weight: 600;
    }
</style>
@endsection
