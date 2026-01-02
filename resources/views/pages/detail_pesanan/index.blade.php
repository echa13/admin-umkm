@extends('layouts.admin.app')

@section('content')
<div class="container-fluid py-4 px-4">
    <div class="header-box d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-slate-400 small">Dashboard</a></li>
                    <li class="breadcrumb-item active small text-slate-500" aria-current="page">Transaction Details</li>
                </ol>
            </nav>
            <h2 class="fw-black text-slate-800 m-0 tracking-tight">Rincian Item <span class="text-sky">Pesanan</span></h2>
        </div>
        <div class="action-area">
            <a href="{{ route('detail_pesanan.create') }}" class="btn btn-elite-primary">
                <i class="fas fa-plus me-2"></i> Tambah Item Baru
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
                <i class="fas fa-list-ul me-2 text-sky"></i>
                <span class="fw-bold text-white small text-uppercase letter-spacing-1">Product Breakdown List</span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-elite align-middle mb-0">
                    <thead>
                        <tr>
                            <th width="15%" class="ps-4">No. Pesanan</th>
                            <th width="30%">Informasi Produk</th>
                            <th width="10%" class="text-center">Qty</th>
                            <th width="15%" class="text-end">Harga Satuan</th>
                            <th width="15%" class="text-end">Subtotal</th>
                            <th width="15%" class="text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($details as $d)
                        <tr>
                            <td class="ps-4">
                                <div class="order-tag">
                                    <span class="hash">#</span>{{ $d->pesanan->nomor_pesanan ?? 'N/A' }}
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="product-icon-box me-3">
                                        <i class="fas fa-box text-slate-400"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-slate-800 mb-0">{{ $d->produk->nama_produk ?? 'Produk Terhapus' }}</div>
                                        <code class="small text-sky">ID-{{ $d->produk_id }}</code>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="qty-pill">{{ $d->qty }} <small class="text-slate-400">pcs</small></span>
                            </td>
                            <td class="text-end fw-semibold text-slate-600">
                                Rp {{ number_format($d->harga_satuan,0,',','.') }}
                            </td>
                            <td class="text-end">
                                <span class="fw-black text-slate-900">Rp {{ number_format($d->subtotal,0,',','.') }}</span>
                            </td>
                            <td class="pe-4">
                                <div class="action-bundle justify-content-center">
                                    <a href="{{ route('detail_pesanan.show', $d->detail_id) }}" class="btn-action btn-view" title="View Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('detail_pesanan.edit', $d->detail_id) }}" class="btn-action btn-edit" title="Edit Item">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form action="{{ route('detail_pesanan.destroy', $d->detail_id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete"
                                                onclick="return confirm('Hapus detail ini?')" title="Delete">
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
                                    <div class="empty-icon">
                                        <i class="fas fa-folder-open"></i>
                                    </div>
                                    <h5 class="fw-bold text-slate-700">Tidak ada rincian data</h5>
                                    <p class="text-slate-500">Silahkan tambah detail pesanan baru untuk melihat list.</p>
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
    /* VARIABLES & COLORS */
    :root {
        --slate-900: #0f172a;
        --slate-800: #1e293b;
        --slate-600: #475569;
        --slate-500: #64748b;
        --slate-400: #94a3b8;
        --sky: #38bdf8;
        --sky-dark: #0ea5e9;
    }

    /* TYPOGRAPHY */
    .fw-black { font-weight: 900; }
    .tracking-tight { letter-spacing: -1px; }
    .letter-spacing-1 { letter-spacing: 1px; }
    .text-sky { color: var(--sky) !important; }
    .text-slate-800 { color: var(--slate-800); }
    .text-slate-500 { color: var(--slate-500); }
    .text-slate-400 { color: var(--slate-400); }

    /* CARD ELITE STYLE */
    .elite-card {
        background: #ffffff;
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.05) !important;
    }
    .card-header-elite {
        background: var(--slate-900);
        padding: 15px 25px;
    }

    /* BUTTONS */
    .btn-elite-primary {
        background: var(--sky);
        color: white;
        font-weight: 700;
        padding: 10px 24px;
        border-radius: 10px;
        border: none;
        transition: 0.3s;
        box-shadow: 0 4px 12px rgba(56, 189, 248, 0.3);
    }
    .btn-elite-primary:hover {
        background: var(--sky-dark);
        transform: translateY(-2px);
        color: white;
        box-shadow: 0 6px 15px rgba(56, 189, 248, 0.4);
    }

    /* TABLE ELITE STYLE */
    .table-elite thead th {
        background: #f8fafc;
        color: var(--slate-600);
        font-size: 0.65rem;
        text-transform: uppercase;
        font-weight: 800;
        letter-spacing: 0.5px;
        padding: 15px 10px;
        border-bottom: 2px solid #e2e8f0;
    }
    .table-elite tbody tr {
        transition: 0.2s;
    }
    .table-elite tbody tr:hover {
        background-color: rgba(56, 189, 248, 0.02);
    }
    .table-elite td {
        padding: 18px 10px;
        color: var(--slate-800);
        border-bottom: 1px solid #f1f5f9;
    }

    /* DECORATIVE ELEMENTS */
    .order-tag {
        display: inline-block;
        background: var(--slate-900);
        color: white;
        padding: 4px 12px;
        border-radius: 6px;
        font-family: 'Monaco', 'Consolas', monospace;
        font-weight: 700;
        font-size: 0.85rem;
    }
    .order-tag .hash { color: var(--sky); margin-right: 2px; }

    .product-icon-box {
        width: 40px; height: 40px;
        background: #f1f5f9;
        display: flex; align-items: center; justify-content: center;
        border-radius: 10px;
    }

    .qty-pill {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        padding: 4px 12px;
        border-radius: 20px;
        font-weight: 700;
        color: var(--slate-800);
    }

    /* ACTION BUTTONS BUNDLE */
    .action-bundle { display: flex; gap: 8px; }
    .btn-action {
        width: 34px; height: 34px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 8px;
        text-decoration: none;
        transition: 0.2s;
        border: none;
    }
    .btn-view { background: #f1f5f9; color: var(--slate-600); }
    .btn-edit { background: rgba(255, 193, 7, 0.1); color: #ffc107; }
    .btn-delete { background: rgba(239, 68, 68, 0.1); color: #ef4444; }

    .btn-view:hover { background: var(--slate-900); color: white; }
    .btn-edit:hover { background: #ffc107; color: white; }
    .btn-delete:hover { background: #ef4444; color: white; }

    /* ALERT STYLE */
    .alert-elite-success {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #166534;
        border-radius: 12px;
        font-weight: 600;
    }

    /* EMPTY STATE */
    .empty-state { padding: 40px 0; }
    .empty-icon {
        font-size: 4rem;
        color: #e2e8f0;
        margin-bottom: 15px;
    }
</style>
@endsection
