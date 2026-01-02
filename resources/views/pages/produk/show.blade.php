@extends('layouts.admin.app')

@section('title', 'Detail Produk: ' . $produk->nama_produk)

@section('content')
<div class="container-fluid py-4 px-4" style="background: #f8fafc; min-height: 100vh;">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-black text-slate-800 m-0 tracking-tight">Product <span class="text-sky">Showcase</span></h2>
            <p class="text-slate-500 small mb-0">Informasi lengkap spesifikasi dan ketersediaan aset produk.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('produk.index') }}" class="btn btn-elite-dark px-4 shadow-sm">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
            <a href="{{ route('produk.edit', $produk->produk_id) }}" class="btn btn-elite-sky px-4 shadow-sm">
                <i class="fas fa-edit me-2"></i> Edit Produk
            </a>
        </div>
    </div>

    <div class="card elite-card border-0 shadow-lg overflow-hidden" style="border-radius: 30px;">
        <div class="row g-0">
            <div class="col-lg-5 bg-light d-flex align-items-center justify-content-center p-4" style="min-height: 400px;">
                <div class="product-image-wrapper shadow-sm">
                    @if($produk->media->first())
                        <img src="{{ asset('storage/produk/'.$produk->media->first()->file_name) }}"
                             class="img-fluid rounded-4 main-img" alt="{{ $produk->nama_produk }}">
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-box-open fa-5x text-slate-300 mb-3"></i>
                            <p class="text-slate-400 fw-bold">Tidak ada foto produk</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-lg-7 bg-white">
                <div class="card-body p-4 p-md-5">
                    <div class="mb-4">
                        <span class="badge bg-sky-soft text-sky px-3 py-2 rounded-pill small fw-black mb-2 uppercase tracking-widest">
                            <i class="fas fa-store me-1"></i> {{ $produk->umkm->nama_usaha }}
                        </span>
                        <h1 class="fw-black text-slate-900 display-6 mb-2">{{ $produk->nama_produk }}</h1>
                        <div class="d-flex align-items-center gap-3">
                            <h2 class="text-sky fw-black m-0">Rp {{ number_format($produk->harga,0,',','.') }}</h2>
                            <span class="badge {{ $produk->status == 'tersedia' ? 'bg-success' : 'bg-danger' }} rounded-pill px-3">
                                {{ ucfirst($produk->status) }}
                            </span>
                        </div>
                    </div>

                    <hr class="my-4 opacity-5">

                    <div class="mb-5">
                        <label class="info-label-elite">Deskripsi Produk</label>
                        <p class="text-slate-600 leading-relaxed">
                            {{ $produk->deskripsi ?? 'Tidak ada deskripsi untuk produk ini.' }}
                        </p>
                    </div>

                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="stat-tile p-3 rounded-4 border">
                                <label class="info-label-elite mb-1">Stok Tersedia</label>
                                <div class="d-flex align-items-center">
                                    <div class="icon-circle bg-slate-100 text-slate-800 me-3">
                                        <i class="fas fa-layer-group"></i>
                                    </div>
                                    <h4 class="fw-black m-0">{{ $produk->stok }} <small class="text-slate-400">Unit</small></h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="stat-tile p-3 rounded-4 border">
                                <label class="info-label-elite mb-1">ID Produk</label>
                                <div class="d-flex align-items-center">
                                    <div class="icon-circle bg-slate-100 text-slate-800 me-3">
                                        <i class="fas fa-fingerprint"></i>
                                    </div>
                                    <h4 class="fw-black m-0">#PRD-{{ $produk->produk_id }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 pt-3 border-top">
                        <p class="small text-slate-400 mb-0 italic">
                            Terakhir diperbarui: {{ $produk->updated_at->format('d F Y, H:i') }}
                        </p>
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
        --slate-600: #475569;
        --slate-400: #94a3b8;
        --slate-300: #cbd5e1;
        --slate-100: #f1f5f9;
        --sky: #38bdf8;
    }

    .fw-black { font-weight: 900; }
    .text-sky { color: var(--sky) !important; }
    .bg-sky-soft { background-color: rgba(56, 189, 248, 0.1); }
    .tracking-widest { letter-spacing: 0.1em; }
    .leading-relaxed { line-height: 1.6; }

    /* IMAGE STYLING */
    .product-image-wrapper {
        background: white;
        padding: 10px;
        border-radius: 25px;
        max-width: 100%;
        transition: 0.3s;
    }
    .main-img {
        max-height: 450px;
        width: 100%;
        object-fit: contain;
    }

    /* LABELS & TILES */
    .info-label-elite {
        font-size: 0.65rem;
        font-weight: 800;
        text-transform: uppercase;
        color: var(--slate-400);
        letter-spacing: 1px;
        display: block;
    }

    .stat-tile {
        transition: 0.3s;
        background: #fff;
    }
    .stat-tile:hover {
        border-color: var(--sky) !important;
        transform: translateY(-3px);
    }

    .icon-circle {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
    }

    /* BUTTONS */
    .btn-elite-dark {
        background: var(--slate-900);
        color: #fff; border-radius: 12px; font-weight: 700; border: none; transition: 0.3s;
    }
    .btn-elite-dark:hover { background: var(--slate-800); color: var(--sky); }

    .btn-elite-sky {
        background: var(--sky);
        color: var(--slate-900); border-radius: 12px; font-weight: 700; border: none; transition: 0.3s;
    }
    .btn-elite-sky:hover { opacity: 0.9; transform: translateY(-2px); }

</style>
@endsection
