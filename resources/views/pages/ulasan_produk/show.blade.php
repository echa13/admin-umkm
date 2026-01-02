@extends('layouts.admin.app')

@section('title', 'Detail Ulasan Produk')

@section('content')
<div class="container-fluid py-4 px-4" style="background: #f8fafc; min-height: 100vh;">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-black text-slate-800 m-0 tracking-tight">Review <span class="text-sky">Detail</span></h2>
            <p class="text-slate-500 small mb-0">Informasi mendalam mengenai feedback yang diberikan oleh warga.</p>
        </div>
        <a href="{{ route('ulasan_produk.index') }}" class="btn btn-elite-dark px-4 shadow-sm">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card elite-card border-0 shadow-lg" style="border-radius: 25px; overflow: hidden;">
                <div class="card-header bg-slate-900 py-3 px-4 border-0 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="icon-box-sm bg-sky text-dark me-3">
                            <i class="fas fa-quote-right"></i>
                        </div>
                        <h5 class="text-white fw-bold mb-0">Ulasan Pelanggan</h5>
                    </div>
                    <span class="badge bg-white bg-opacity-10 text-sky px-3 py-2 fw-bold">ID #{{ $ulasan_produk->ulasan_id }}</span>
                </div>

                <div class="card-body p-4 p-md-5">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="detail-tile">
                                <label class="detail-label">Produk Terkait</label>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-light text-sky me-3">
                                        <i class="fas fa-box"></i>
                                    </div>
                                    <div class="fw-black text-slate-800">{{ $ulasan_produk->produk->nama_produk ?? '-' }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="detail-tile">
                                <label class="detail-label">Penulis Ulasan</label>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-light text-slate-600 me-3">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="fw-black text-slate-800">{{ $ulasan_produk->warga->nama ?? '-' }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 text-center my-3">
                            <div class="py-3 px-4 bg-light rounded-4 d-inline-block">
                                <label class="detail-label justify-content-center mb-2">Skor Rating</label>
                                <div class="rating-display">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $ulasan_produk->rating ? 'text-warning' : 'text-slate-200' }} fa-2x mx-1"></i>
                                    @endfor
                                    <span class="h2 fw-black text-slate-800 ms-3 mb-0">{{ $ulasan_produk->rating }}.0</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="comment-box p-4 rounded-4 border-start border-sky border-5 bg-light position-relative">
                                <i class="fas fa-quote-left position-absolute text-slate-200" style="top: 15px; left: 15px; font-size: 2rem; opacity: 0.5;"></i>
                                <label class="detail-label mb-3">Komentar / Feedback:</label>
                                <p class="text-slate-700 fw-bold italic mb-0 ps-3" style="font-size: 1.1rem; line-height: 1.6;">
                                    "{{ $ulasan_produk->komentar ?? 'Tidak ada komentar tertulis.' }}"
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-white border-0 py-4 px-4 border-top">
                    <div class="d-flex justify-content-center gap-2">
                        <a href="{{ route('ulasan_produk.edit', $ulasan_produk->ulasan_id) }}" class="btn btn-warning rounded-pill px-4 fw-bold text-white shadow-sm">
                            <i class="fas fa-edit me-2"></i> Edit Ulasan
                        </a>
                        <button class="btn btn-outline-danger rounded-pill px-4 fw-bold shadow-sm" onclick="confirmDelete()">
                            <i class="fas fa-trash me-2"></i> Hapus
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
        --slate-700: #334155;
        --slate-500: #64748b;
        --slate-400: #94a3b8;
        --slate-200: #e2e8f0;
        --sky: #38bdf8;
    }

    .fw-black { font-weight: 900; }
    .text-sky { color: var(--sky) !important; }
    .bg-slate-900 { background-color: var(--slate-900) !important; }

    /* DETAIL STYLING */
    .detail-tile {
        padding: 15px;
        background: #fff;
        border-radius: 15px;
        border: 1px solid #f1f5f9;
        height: 100%;
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

    .avatar-sm {
        width: 35px;
        height: 35px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .comment-box {
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);
    }

    .rating-display {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* BUTTONS */
    .btn-elite-dark {
        background: var(--slate-900);
        color: #fff; border-radius: 12px; font-weight: 700; border: none; transition: 0.3s;
    }
    .btn-elite-dark:hover { background: var(--slate-800); color: var(--sky); }

    .icon-box-sm {
        width: 35px; height: 35px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
    }

    .shadow-lg {
        box-shadow: 0 20px 40px rgba(15, 23, 42, 0.1) !important;
    }
</style>
@endsection
