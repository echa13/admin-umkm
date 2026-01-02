@extends('layouts.admin.app')

@section('content')
<div class="container-fluid py-4 px-4">
    <div class="header-box d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-slate-400 small">Dashboard</a></li>
                    <li class="breadcrumb-item active small text-slate-500" aria-current="page">Population Registry</li>
                </ol>
            </nav>
            <h2 class="fw-black text-slate-800 m-0 tracking-tight">Data <span class="text-sky">Warga</span></h2>
            <p class="text-slate-500 small mb-0">Manajemen basis data penduduk dan integrasi layanan warga.</p>
        </div>
        <div class="action-area">
            <a href="{{ route('warga.create') }}" class="btn btn-elite-primary shadow-sm">
                <i class="fas fa-plus-circle me-2"></i> Tambah Warga Baru
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
            <form action="{{ route('warga.index') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-md-5">
                    <div class="input-group input-group-elite">
                        <span class="input-group-text bg-transparent border-end-0"><i class="fas fa-search text-slate-400"></i></span>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control border-start-0 ps-0" placeholder="Cari berdasarkan Nama atau NIK...">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="jenis_kelamin" class="form-select form-select-elite">
                        <option value="">Semua Gender</option>
                        <option value="Laki-laki" {{ request('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ request('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-slate-900 w-100 fw-bold">Filter</button>
                </div>
                @if(request('search') || request('jenis_kelamin'))
                <div class="col-md-2">
                    <a href="{{ route('warga.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
                </div>
                @endif
            </form>
        </div>
    </div>

    @if ($datas->isEmpty())
        <div class="card elite-card border-0 py-5 text-center">
            <div class="card-body">
                <i class="fas fa-address-card fa-4x text-slate-200 mb-3"></i>
                <h5 class="fw-bold text-slate-700">Data Tidak Ditemukan</h5>
                <p class="text-slate-400">Belum ada data warga yang tersimpan atau filter tidak cocok.</p>
            </div>
        </div>
    @else
        <div class="row g-4">
            @foreach ($datas as $w)
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                    <div class="card citizen-elite-card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="text-center mb-3">
                                <div class="avatar-ring mx-auto mb-2">
                                    <img src="{{ asset('asset/img/default.png') }}" alt="Profile Image">
                                </div>
                                <h6 class="fw-black text-slate-800 mb-0">{{ $w->nama }}</h6>
                                <span class="badge-nik">{{ $w->no_ktp }}</span>
                            </div>

                            <div class="row g-1 mb-3">
                                <div class="col-6">
                                    <div class="info-pill">
                                        <i class="fas fa-venus-mars text-sky me-1"></i> {{ $w->jenis_kelamin }}
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="info-pill">
                                        <i class="fas fa-pray text-sky me-1"></i> {{ $w->agama }}
                                    </div>
                                </div>
                                <div class="col-12 mt-1">
                                    <div class="info-pill w-100">
                                        <i class="fas fa-briefcase text-sky me-1"></i> {{ $w->pekerjaan ?? 'Tidak Bekerja' }}
                                    </div>
                                </div>
                            </div>

                            <div class="contact-section border-top pt-3 mb-4">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="contact-icon bg-success-subtle text-success"><i class="fas fa-phone-alt"></i></div>
                                    <span class="small fw-bold text-slate-600">{{ $w->telp ?? 'N/A' }}</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="contact-icon bg-danger-subtle text-danger"><i class="fas fa-envelope"></i></div>
                                    <span class="small fw-bold text-slate-600 text-truncate">{{ $w->email ?? 'N/A' }}</span>
                                </div>
                            </div>

                            <div class="action-bundle justify-content-center">
                                <a href="{{ route('warga.edit', $w->warga_id) }}" class="btn-action btn-edit" title="Edit Data">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('warga.destroy', $w->warga_id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete" onclick="return confirm('Hapus data warga ini?')" title="Hapus">
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
            {{ $datas->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

<style>
    /* VARIABLES */
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
    .text-sky { color: var(--sky) !important; }

    /* CARD DESIGN */
    .elite-card { background: #fff; border-radius: 12px; }

    .citizen-elite-card {
        background: #fff;
        border-radius: 20px;
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }

    .citizen-elite-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(15, 23, 42, 0.1) !important;
        border-color: var(--slate-200);
    }

    /* PROFILE ELEMENTS */
    .avatar-ring {
        width: 80px; height: 80px;
        padding: 4px; border: 2px solid var(--slate-200);
        border-radius: 50%; transition: 0.3s;
    }
    .citizen-elite-card:hover .avatar-ring { border-color: var(--sky); }
    .avatar-ring img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }

    .badge-nik {
        font-size: 0.65rem; font-weight: 800;
        color: var(--slate-400); letter-spacing: 1px;
    }

    /* INFO PILLS */
    .info-pill {
        background: #f8fafc;
        border: 1px solid #f1f5f9;
        padding: 5px 10px;
        border-radius: 8px;
        font-size: 0.7rem;
        font-weight: 700;
        color: var(--slate-600);
        display: inline-block;
    }

    /* CONTACT SECTION */
    .contact-icon {
        width: 24px; height: 24px;
        border-radius: 6px;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.75rem; margin-right: 10px;
    }

    /* BUTTONS & INPUTS */
    .btn-elite-primary {
        background: var(--sky); color: white; font-weight: 700;
        padding: 10px 24px; border-radius: 10px; border: none; transition: 0.3s;
    }
    .btn-slate-900 { background: var(--slate-900); color: white; border-radius: 8px; padding: 10px; }

    .form-select-elite, .input-group-elite .form-control {
        border: 1px solid var(--slate-200);
        padding: 10px 15px; border-radius: 8px; font-size: 0.9rem;
    }
    .input-group-elite .input-group-text { border: 1px solid var(--slate-200); border-radius: 8px; }

    /* ACTION BUTTONS */
    .action-bundle { display: flex; gap: 8px; }
    .btn-action {
        width: 38px; height: 38px; display: flex;
        align-items: center; justify-content: center;
        border-radius: 10px; transition: 0.2s; border: none;
    }
    .btn-edit { background: rgba(255, 193, 7, 0.1); color: #ffc107; }
    .btn-delete { background: rgba(239, 68, 68, 0.1); color: #ef4444; }
    .btn-edit:hover { background: #ffc107; color: white; }
    .btn-delete:hover { background: #ef4444; color: white; }

    /* PAGINATION */
    .page-link { border: none; color: var(--slate-600); border-radius: 8px !important; margin: 0 3px; font-weight: 600; }
    .page-item.active .page-link { background: var(--slate-900); color: white; }

    .alert-elite-success {
        background: #f0fdf4; border: 1px solid #bbf7d0;
        color: #166534; border-radius: 12px; font-weight: 600;
    }
</style>
@endsection
