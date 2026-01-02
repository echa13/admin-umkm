@extends('layouts.admin.app')

@section('title', 'Detail Item Pesanan')

@section('content')
<div class="container-fluid py-4 px-4" style="background: #f8fafc; min-height: 100vh;">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-black text-slate-800 m-0 tracking-tight">Item <span class="text-sky">Information</span></h2>
            <p class="text-slate-500 small mb-0">Rincian lengkap mengenai produk dalam pesanan ini.</p>
        </div>
        <a href="{{ route('detail_pesanan.index') }}" class="btn btn-elite-dark px-4 shadow-sm">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card elite-card border-0 shadow-lg" style="border-radius: 25px; overflow: hidden;">
                <div class="card-header bg-slate-900 py-3 px-4 border-0">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="icon-box-sm bg-sky text-dark me-3">
                                <i class="fas fa-search-plus"></i>
                            </div>
                            <h5 class="text-white fw-bold mb-0">Rincian Data Item</h5>
                        </div>
                        <span class="badge bg-white bg-opacity-10 text-sky px-3 py-2 fw-bold" style="font-size: 0.65rem; letter-spacing: 1px;">ID #{{ $detail_pesanan->detail_id }}</span>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="p-4 p-md-5">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="detail-group">
                                    <label class="detail-label">Nomor Pesanan</label>
                                    <div class="detail-value text-sky">
                                        <i class="fas fa-hashtag me-2"></i> {{ $detail_pesanan->pesanan->nomor_pesanan ?? '-' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-group">
                                    <label class="detail-label">Nama Produk</label>
                                    <div class="detail-value text-slate-800">
                                        <i class="fas fa-box me-2"></i> {{ $detail_pesanan->produk->nama_produk ?? '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-light p-4 p-md-5 border-top border-bottom">
                        <div class="row align-items-center text-center text-md-start">
                            <div class="col-md-4 mb-3 mb-md-0">
                                <label class="detail-label justify-content-center justify-content-md-start">Kuantitas</label>
                                <div class="h4 fw-black text-slate-800 m-0">{{ $detail_pesanan->qty }} <small class="text-slate-400 fw-bold" style="font-size: 0.8rem;">Unit</small></div>
                            </div>
                            <div class="col-md-4 mb-3 mb-md-0 text-center">
                                <label class="detail-label justify-content-center">Harga Satuan</label>
                                <div class="h4 fw-bold text-slate-600 m-0">Rp {{ number_format($detail_pesanan->harga_satuan,0,',','.') }}</div>
                            </div>
                            <div class="col-md-4 text-md-end">
                                <label class="detail-label justify-content-center justify-content-md-end">Subtotal Pembayaran</label>
                                <div class="h3 fw-black text-sky m-0">Rp {{ number_format($detail_pesanan->subtotal,0,',','.') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-white border-0 py-4 px-4">
                    <div class="d-flex flex-column flex-md-row gap-2 justify-content-center">
                        <a href="{{ route('detail_pesanan.edit', $detail_pesanan->detail_id) }}" class="btn btn-warning rounded-pill px-4 fw-bold text-white shadow-sm">
                            <i class="fas fa-edit me-2"></i> Ubah Data
                        </a>
                        <button class="btn btn-outline-danger rounded-pill px-4 fw-bold shadow-sm" onclick="window.print()">
                            <i class="fas fa-print me-2"></i> Cetak Invoice
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --slate-900: #0f172a;
        --slate-800: #1e293b;
        --slate-500: #64748b;
        --slate-400: #94a3b8;
        --sky: #38bdf8;
    }

    .fw-black { font-weight: 900; }
    .text-sky { color: var(--sky) !important; }
    .bg-slate-900 { background-color: var(--slate-900) !important; }
    .tracking-tight { letter-spacing: -1px; }

    /* DETAIL STYLING */
    .detail-group {
        padding: 15px;
        background: #fff;
        border-radius: 15px;
        border: 1px solid #f1f5f9;
        transition: 0.3s;
    }
    .detail-group:hover {
        border-color: var(--sky);
        transform: translateY(-2px);
    }

    .detail-label {
        font-size: 0.65rem;
        font-weight: 800;
        text-transform: uppercase;
        color: var(--slate-400);
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        letter-spacing: 1px;
    }

    .detail-value {
        font-size: 1.1rem;
        font-weight: 800;
    }

    /* UTILITIES */
    .icon-box-sm {
        width: 35px;
        height: 35px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-elite-dark {
        background: var(--slate-900);
        color: #fff;
        border-radius: 12px;
        font-weight: 700;
        border: none;
        transition: 0.3s;
    }
    .btn-elite-dark:hover { background: var(--slate-800); color: var(--sky); }

    .shadow-lg {
        box-shadow: 0 20px 40px rgba(15, 23, 42, 0.1) !important;
    }

    @media print {
        .btn, .sidebar, .sidebar-container { display: none !important; }
        .card { box-shadow: none !important; border: 1px solid #000 !important; }
    }
</style>
@endsection
