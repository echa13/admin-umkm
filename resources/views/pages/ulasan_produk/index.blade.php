@extends('layouts.admin.app')

@section('content')
<div class="container-fluid py-4 px-4">
    <div class="header-box d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-slate-400 small">Dashboard</a></li>
                    <li class="breadcrumb-item active small text-slate-500" aria-current="page">Customer Feedback</li>
                </ol>
            </nav>
            <h2 class="fw-black text-slate-800 m-0 tracking-tight">Ulasan <span class="text-sky">Pelanggan</span></h2>
            <p class="text-slate-500 small mb-0">Dengarkan suara konsumen untuk meningkatkan kualitas produk.</p>
        </div>
        <div class="action-area">
            <a href="{{ route('ulasan_produk.create') }}" class="btn btn-elite-primary shadow-sm">
                <i class="fas fa-plus-circle me-2"></i> Tambah Ulasan Manual
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
                <i class="fas fa-star me-2 text-sky"></i>
                <span class="fw-bold text-white small text-uppercase letter-spacing-1">Product Reviews Management</span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-elite align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">Produk</th>
                            <th>Reviewer</th>
                            <th>Skor Rating</th>
                            <th style="min-width: 350px;">Komentar & Testimoni</th>
                            <th class="text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ulasan as $u)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="product-icon-box me-3">
                                        <i class="fas fa-box text-sky"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-slate-800 mb-0">{{ $u->produk->nama_produk ?? 'Produk Terhapus' }}</div>
                                        <small class="text-slate-400">ID: {{ $u->produk_id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="reviewer-avatar me-2">
                                        {{ substr($u->warga->nama ?? 'A', 0, 1) }}
                                    </div>
                                    <span class="fw-bold text-slate-700">{{ $u->warga->nama ?? 'Anonim' }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="rating-box">
                                    <div class="stars-gold mb-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="{{ $i <= $u->rating ? 'fas' : 'far' }} fa-star"></i>
                                        @endfor
                                    </div>
                                    <span class="badge-rating">{{ $u->rating }}.0 / 5.0</span>
                                </div>
                            </td>
                            <td>
                                <div class="comment-bubble">
                                    <i class="fas fa-quote-left text-slate-200 me-2"></i>
                                    <span class="text-slate-600 italic-comment">{{ Str::limit($u->komentar, 150, '...') }}</span>
                                </div>
                            </td>
                            <td class="pe-4">
                                <div class="action-bundle justify-content-center">
                                    <a href="{{ route('ulasan_produk.show', $u->ulasan_id) }}" class="btn-action btn-view" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('ulasan_produk.edit', $u->ulasan_id) }}" class="btn-action btn-edit" title="Edit">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form action="{{ route('ulasan_produk.destroy', $u->ulasan_id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete"
                                                onclick="return confirm('Hapus ulasan ini?')" title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="fas fa-comment-slash fa-4x text-slate-200 mb-3"></i>
                                    <h5 class="fw-bold text-slate-700">Belum Ada Ulasan</h5>
                                    <p class="text-slate-400">Ulasan dari pelanggan akan muncul di sini secara otomatis.</p>
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
    /* UNIFIED VARIABLES */
    :root {
        --slate-900: #0f172a;
        --slate-800: #1e293b;
        --slate-700: #334155;
        --slate-600: #475569;
        --slate-500: #64748b;
        --slate-400: #94a3b8;
        --slate-200: #e2e8f0;
        --sky: #38bdf8;
        --gold: #f59e0b;
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
    .table-elite td { padding: 20px 10px; border-bottom: 1px solid #f1f5f9; }

    /* PRODUCT ICON BOX */
    .product-icon-box {
        width: 40px; height: 40px; background: #f0f9ff;
        border-radius: 10px; display: flex; align-items: center;
        justify-content: center; font-size: 1.1rem;
    }

    /* REVIEWER AVATAR */
    .reviewer-avatar {
        width: 32px; height: 32px; background: var(--slate-900);
        color: var(--sky); display: flex; align-items: center;
        justify-content: center; border-radius: 50%;
        font-weight: 800; font-size: 0.8rem;
    }

    /* RATING STYLING */
    .stars-gold { color: var(--gold); font-size: 0.85rem; }
    .stars-gold .far { color: var(--slate-200); }
    .badge-rating {
        background: #fffbeb; color: #92400e;
        font-size: 0.7rem; font-weight: 800;
        padding: 2px 8px; border-radius: 6px; border: 1px solid #fef3c7;
    }

    /* COMMENT BUBBLE */
    .comment-bubble {
        background: #f8fafc; padding: 12px 16px;
        border-radius: 12px; border-left: 4px solid var(--slate-200);
        position: relative;
    }
    .italic-comment { font-style: italic; font-size: 0.85rem; line-height: 1.5; }

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
