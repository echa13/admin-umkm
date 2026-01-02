@extends('layouts.admin.app')

@section('content')
<div class="container-fluid py-4 px-4">
    <div class="header-box d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-slate-400 small">Dashboard</a></li>
                    <li class="breadcrumb-item active small text-slate-500" aria-current="page">Merchant Registry</li>
                </ol>
            </nav>
            <h2 class="fw-black text-slate-800 m-0 tracking-tight">Daftar <span class="text-sky">UMKM</span></h2>
            <p class="text-slate-500 small mb-0">Manajemen database pelaku usaha dan mitra UMKM.</p>
        </div>
        <div class="action-area">
            <a href="{{ route('umkm.create') }}" class="btn btn-elite-primary shadow-sm">
                <i class="fas fa-plus-circle me-2"></i> Registrasi UMKM
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
            <form action="{{ route('umkm.index') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-md-4">
                    <div class="input-group input-group-elite">
                        <span class="input-group-text bg-transparent border-end-0"><i class="fas fa-search text-slate-400"></i></span>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control border-start-0 ps-0" placeholder="Cari nama usaha atau pemilik...">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="kategori" class="form-select form-select-elite">
                        <option value="">Semua Kategori</option>
                        @foreach ($kategoriList as $row)
                            <option value="{{ $row->kategori }}" {{ request('kategori') == $row->kategori ? 'selected' : '' }}>
                                {{ $row->kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-slate-900 w-100 fw-bold">
                        <i class="fas fa-filter me-2"></i> Filter
                    </button>
                </div>
                @if(request('search') || request('kategori'))
                <div class="col-md-1">
                    <a href="{{ route('umkm.index') }}" class="btn btn-outline-secondary w-100" title="Reset">
                        <i class="fas fa-undo"></i>
                    </a>
                </div>
                @endif
            </form>
        </div>
    </div>

    <div class="card elite-card border-0 shadow-sm">
        <div class="card-header-elite">
            <div class="d-flex align-items-center">
                <i class="fas fa-store me-2 text-sky"></i>
                <span class="fw-bold text-white small text-uppercase letter-spacing-1">Merchant Database</span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-elite align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4 text-center" width="60">No</th>
                            <th>Nama Usaha & Pemilik</th>
                            <th>Kategori</th>
                            <th>Kontak</th>
                            <th>Alamat Operasional</th>
                            <th class="text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($umkm as $index => $item)
                        <tr>
                            <td class="ps-4 text-center">
                                <span class="text-slate-400 small fw-bold">{{ $umkm->firstItem() + $index }}</span>
                            </td>
                            <td>
                                <div class="fw-black text-slate-800 mb-0">{{ $item->nama_usaha }}</div>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-user-circle text-slate-400 me-1 small"></i>
                                    <span class="text-slate-500 small">{{ $item->pemilik?->nama ?? 'Tidak Terhubung' }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge-category">
                                    <i class="fas fa-tag me-1 opacity-50"></i> {{ $item->kategori }}
                                </span>
                            </td>
                            <td>
                                <div class="contact-box">
                                    <i class="fab fa-whatsapp text-success me-1"></i>
                                    <span class="fw-medium text-slate-700">{{ $item->kontak }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="small text-slate-600">
                                    <i class="fas fa-map-marker-alt text-sky me-1"></i>
                                    <span class="fw-bold">RT {{ $item->rt }}/RW {{ $item->rw }}</span>
                                </div>
                                <div class="text-slate-400 x-small text-truncate" style="max-width: 200px;">
                                    {{ $item->alamat }}
                                </div>
                            </td>
                            <td class="pe-4">
                                <div class="action-bundle justify-content-center">
                                    <a href="{{ route('umkm.show', $item->umkm_id) }}" class="btn-action btn-view" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('umkm.edit', $item->umkm_id) }}" class="btn-action btn-edit" title="Edit">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form action="{{ route('umkm.destroy', $item->umkm_id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete"
                                                onclick="return confirm('Hapus data UMKM ini?')" title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="fas fa-store-slash fa-4x text-slate-200 mb-3"></i>
                                    <h5 class="fw-bold text-slate-700">Database Kosong</h5>
                                    <p class="text-slate-400">Belum ada mitra UMKM yang terdaftar di sistem.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 py-3">
            <div class="d-flex justify-content-center">
                {{ $umkm->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
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
    .text-sky { color: var(--sky) !important; }
    .x-small { font-size: 0.75rem; }

    /* CARD & HEADER */
    .elite-card { background: #fff; border-radius: 16px; overflow: hidden; }
    .card-header-elite { background: var(--slate-900); padding: 15px 25px; }

    /* BUTTONS */
    .btn-elite-primary {
        background: var(--sky); color: white; font-weight: 700;
        padding: 10px 24px; border-radius: 10px; border: none; transition: 0.3s;
    }
    .btn-slate-900 { background: var(--slate-900); color: white; border-radius: 8px; padding: 10px; }
    .btn-slate-900:hover { background: #000; color: white; }

    /* FORMS */
    .input-group-elite .form-control, .form-select-elite {
        border: 1px solid var(--slate-200);
        padding: 10px 15px;
        border-radius: 8px;
        font-size: 0.9rem;
    }
    .input-group-elite .input-group-text { border: 1px solid var(--slate-200); border-radius: 8px; }

    /* TABLE */
    .table-elite thead th {
        background: #f8fafc; color: var(--slate-600);
        font-size: 0.65rem; text-transform: uppercase;
        font-weight: 800; padding: 15px 10px;
        border-bottom: 2px solid #e2e8f0;
    }
    .table-elite td { padding: 16px 10px; border-bottom: 1px solid #f1f5f9; }

    /* BADGE CATEGORY */
    .badge-category {
        background: #f1f5f9; color: var(--slate-700);
        padding: 4px 12px; border-radius: 6px;
        font-size: 0.75rem; font-weight: 700;
        border: 1px solid #e2e8f0;
    }

    /* CONTACT BOX */
    .contact-box {
        font-size: 0.85rem; background: #f0fdf4;
        padding: 4px 10px; border-radius: 6px;
        display: inline-block; border: 1px solid #dcfce7;
    }

    /* ACTIONS (UNIFIED) */
    .action-bundle { display: flex; gap: 6px; }
    .btn-action {
        width: 32px; height: 32px; display: flex;
        align-items: center; justify-content: center;
        border-radius: 8px; transition: 0.2s; text-decoration: none; border: none;
    }
    .btn-view { background: #f1f5f9; color: var(--slate-600); }
    .btn-edit { background: rgba(255, 193, 7, 0.1); color: #ffc107; }
    .btn-delete { background: rgba(239, 68, 68, 0.1); color: #ef4444; }
    .btn-view:hover { background: var(--slate-900); color: white; }
    .btn-edit:hover { background: #ffc107; color: white; }
    .btn-delete:hover { background: #ef4444; color: white; }

    /* PAGINATION OVERRIDE */
    .pagination { margin-bottom: 0; gap: 5px; }
    .page-link {
        border: none; color: var(--slate-600);
        border-radius: 8px !important; margin: 0 2px;
        font-weight: 600;
    }
    .page-item.active .page-link { background: var(--slate-900); color: white; }
</style>
@endsection
