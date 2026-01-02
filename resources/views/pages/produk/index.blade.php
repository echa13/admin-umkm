@extends('layouts.admin.app')

@section('content')
<div class="container-fluid py-4 px-4">
    <div class="header-box d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-slate-400 small">Dashboard</a></li>
                    <li class="breadcrumb-item active small text-slate-500" aria-current="page">Daftar Produk</li>
                </ol>
            </nav>
            <h2 class="fw-black text-slate-800 m-0 tracking-tight">Katalog <span class="text-sky">Produk</span></h2>
            <p class="text-slate-500 small mb-0">Kelola daftar produk dan inventaris UMKM Anda.</p>
        </div>
        <div class="action-area">
            <a href="{{ route('produk.create') }}" class="btn btn-elite-primary shadow-sm">
                <i class="fas fa-plus me-2"></i> Tambah Produk
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

    <div class="card elite-card border-0 shadow-sm">
        <div class="card-header-elite">
            <div class="d-flex align-items-center">
                <i class="fas fa-box-open me-2 text-sky"></i>
                <span class="fw-bold text-white small text-uppercase letter-spacing-1">Inventory Management</span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-elite align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4" width="80">Media</th>
                            <th>Informasi Produk</th>
                            <th>UMKM Pemilik</th>
                            <th>Harga Jual</th>
                            <th class="text-center">Stok</th>
                            <th class="text-center">Status</th>
                            <th class="text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($produks as $p)
                        <tr>
                            <td class="ps-4">
                                @if($p->media->first())
                                    <div class="product-img-wrapper">
                                        <img src="{{ asset('storage/produk/'.$p->media->first()->file_name) }}" alt="foto">
                                    </div>
                                @else
                                    <div class="product-img-placeholder">
                                        <i class="fas fa-image"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold text-slate-800 mb-0">{{ $p->nama_produk }}</div>
                                <code class="small text-sky">SKU-{{ str_pad($p->produk_id, 5, '0', STR_PAD_LEFT) }}</code>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="umkm-tag">
                                        <i class="fas fa-store me-1"></i> {{ $p->umkm->nama_usaha }}
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="fw-black text-slate-900">Rp {{ number_format($p->harga,0,',','.') }}</span>
                            </td>
                            <td class="text-center">
                                @if($p->stok <= 5)
                                    <span class="stok-pill stok-low">
                                        <i class="fas fa-exclamation-triangle me-1"></i> {{ $p->stok }}
                                    </span>
                                @else
                                    <span class="stok-pill">
                                        {{ $p->stok }} <small class="ms-1 text-slate-400">Unit</small>
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($p->status == 'aktif' || $p->status == 'tersedia')
                                    <span class="status-pill status-active">
                                        <span class="dot"></span> Aktif
                                    </span>
                                @else
                                    <span class="status-pill status-inactive">
                                        {{ ucfirst($p->status) }}
                                    </span>
                                @endif
                            </td>
                            <td class="pe-4">
                                <div class="action-bundle justify-content-center">
                                    <a href="{{ route('produk.show', $p->produk_id) }}" class="btn-action btn-view" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('produk.edit', $p->produk_id) }}" class="btn-action btn-edit" title="Edit">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form action="{{ route('produk.destroy', $p->produk_id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete"
                                                onclick="return confirm('Yakin ingin hapus?')" title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="fas fa-box-open fa-4x text-slate-200 mb-3"></i>
                                    <h5 class="fw-bold text-slate-700">Katalog Kosong</h5>
                                    <p class="text-slate-400">Belum ada produk yang didaftarkan dalam sistem.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    /* VARIABLES & FUNDAMENTALS */
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

    /* CARD & HEADER */
    .elite-card { background: #fff; border-radius: 16px; overflow: hidden; }
    .card-header-elite { background: var(--slate-900); padding: 15px 25px; }
    .letter-spacing-1 { letter-spacing: 1px; }

    /* BUTTON ELITE */
    .btn-elite-primary {
        background: var(--sky); color: white; font-weight: 700;
        padding: 10px 24px; border-radius: 10px; border: none; transition: 0.3s;
    }
    .btn-elite-primary:hover { background: #0ea5e9; transform: translateY(-2px); color: white; }

    /* TABLE STYLE */
    .table-elite thead th {
        background: #f8fafc; color: var(--slate-600);
        font-size: 0.65rem; text-transform: uppercase;
        font-weight: 800; padding: 15px 10px;
        border-bottom: 2px solid #e2e8f0;
    }
    .table-elite td { padding: 16px 10px; border-bottom: 1px solid #f1f5f9; }

    /* MEDIA / IMAGE STYLING */
    .product-img-wrapper {
        width: 54px; height: 54px; border-radius: 12px;
        overflow: hidden; border: 2px solid #fff;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .product-img-wrapper img { width: 100%; height: 100%; object-fit: cover; }

    .product-img-placeholder {
        width: 54px; height: 54px; border-radius: 12px;
        background: #f1f5f9; display: flex; align-items: center;
        justify-content: center; color: var(--slate-400);
    }

    /* UMKM TAG */
    .umkm-tag {
        background: #f8fafc; border: 1px solid #e2e8f0;
        padding: 4px 10px; border-radius: 8px; font-size: 0.8rem;
        color: var(--slate-600); font-weight: 600;
    }

    /* STOK PILL */
    .stok-pill {
        background: #f1f5f9; color: var(--slate-800);
        padding: 4px 12px; border-radius: 8px; font-weight: 700; font-size: 0.85rem;
    }
    .stok-low {
        background: #fef2f2; color: #ef4444; border: 1px solid #fee2e2;
    }

    /* STATUS PILL MODERN */
    .status-pill {
        padding: 4px 12px; border-radius: 20px;
        font-size: 0.75rem; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;
    }
    .status-active { background: #f0fdf4; color: #166534; border: 1px solid #dcfce7; }
    .status-active .dot { width: 6px; height: 6px; background: #22c55e; border-radius: 50%; }
    .status-inactive { background: #f8fafc; color: #64748b; border: 1px solid #e2e8f0; }

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

    /* ALERT SUCCESS */
    .alert-elite-success {
        background: #f0fdf4; border: 1px solid #bbf7d0;
        color: #166534; border-radius: 12px; font-weight: 600;
    }
</style>
@endsection
