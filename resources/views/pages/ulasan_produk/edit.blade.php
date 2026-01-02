@extends('layouts.admin.app')

@section('title', 'Edit Ulasan #' . $ulasan_produk->ulasan_id)

@section('content')
<div class="container-fluid py-4 px-4" style="background: #f8fafc; min-height: 100vh;">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-black text-slate-800 m-0 tracking-tight">Modify <span class="text-sky">Feedback</span></h2>
            <p class="text-slate-500 small mb-0">Perbarui rating atau komentar ulasan dari pelanggan.</p>
        </div>
        <a href="{{ route('ulasan_produk.index') }}" class="btn btn-elite-dark px-4 shadow-sm">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            @if ($errors->any())
                <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="d-flex align-items-center text-danger">
                        <i class="fas fa-exclamation-circle me-3 fa-lg"></i>
                        <ul class="mb-0 small fw-bold">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <div class="card elite-card border-0 shadow-lg" style="border-radius: 25px;">
                <div class="card-header bg-slate-900 py-3 px-4 border-0">
                    <div class="d-flex align-items-center">
                        <div class="icon-box-sm bg-sky text-dark me-3">
                            <i class="fas fa-edit"></i>
                        </div>
                        <h5 class="text-white fw-bold mb-0">Update Data Ulasan</h5>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5 bg-white">
                    <form action="{{ route('ulasan_produk.update', $ulasan_produk->ulasan_id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label-elite">Produk Terkait</label>
                                <div class="input-group-elite">
                                    <span class="input-icon"><i class="fas fa-box"></i></span>
                                    <select name="produk_id" class="form-select-elite" required>
                                        @foreach($produks as $prod)
                                            <option value="{{ $prod->produk_id }}" {{ $prod->produk_id == $ulasan_produk->produk_id ? 'selected' : '' }}>
                                                {{ $prod->nama_produk }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label-elite">Nama Reviewer (Warga)</label>
                                <div class="input-group-elite">
                                    <span class="input-icon"><i class="fas fa-user-circle"></i></span>
                                    <select name="warga_id" class="form-select-elite" required>
                                        @foreach($wargas as $w)
                                            <option value="{{ $w->warga_id }}" {{ $w->warga_id == $ulasan_produk->warga_id ? 'selected' : '' }}>
                                                {{ $w->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label-elite">Rating (1-5)</label>
                                <div class="input-group-elite">
                                    <span class="input-icon text-warning"><i class="fas fa-star"></i></span>
                                    <input type="number" name="rating" class="form-control-elite"
                                           min="1" max="5" value="{{ $ulasan_produk->rating }}" required>
                                </div>
                                <div class="mt-2 ms-1">
                                    <span class="x-small text-slate-400">Rating saat ini:</span>
                                    <div class="d-inline-block ms-1">
                                        @for($i=1; $i<=5; $i++)
                                            <i class="fas fa-star {{ $i <= $ulasan_produk->rating ? 'text-warning' : 'text-slate-200' }} x-small"></i>
                                        @endfor
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label-elite">Komentar / Feedback</label>
                                <div class="input-group-elite">
                                    <span class="input-icon top-15"><i class="fas fa-quote-left"></i></span>
                                    <textarea name="komentar" class="form-control-elite px-3" rows="5"
                                              style="padding-left: 40px !important;">{{ $ulasan_produk->komentar }}</textarea>
                                </div>
                            </div>

                            <div class="col-12 mt-4 text-end">
                                <button type="submit" class="btn btn-elite-sky px-5 py-3 fw-black shadow-lg">
                                    PERBARUI ULASAN <i class="fas fa-sync-alt ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </form>
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
        --slate-200: #e2e8f0;
        --sky: #38bdf8;
    }

    .fw-black { font-weight: 900; }
    .text-sky { color: var(--sky) !important; }
    .bg-slate-900 { background-color: var(--slate-900) !important; }
    .x-small { font-size: 0.65rem; font-weight: 700; text-transform: uppercase; }

    /* FORM STYLING */
    .form-label-elite {
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        color: var(--slate-500);
        margin-bottom: 6px;
        display: block;
        letter-spacing: 0.5px;
    }

    .input-group-elite {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-icon {
        position: absolute;
        left: 15px;
        color: var(--sky);
        z-index: 10;
        font-size: 0.85rem;
    }

    .input-icon.top-15 { top: 15px; }

    .form-control-elite, .form-select-elite {
        width: 100%;
        padding: 12px 12px 12px 40px;
        border-radius: 12px;
        border: 2px solid #f1f5f9;
        background-color: #f8fafc;
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--slate-800);
        transition: 0.3s;
    }

    .form-control-elite:focus, .form-select-elite:focus {
        outline: none; border-color: var(--sky); background-color: #fff;
        box-shadow: 0 0 0 4px rgba(56, 189, 248, 0.1);
    }

    /* BUTTONS */
    .btn-elite-dark {
        background: var(--slate-900);
        color: #fff; border-radius: 12px; font-weight: 700; border: none; font-size: 0.85rem;
    }
    .btn-elite-sky {
        background: var(--sky);
        color: var(--slate-900); border-radius: 15px; border: none;
        transition: 0.3s; letter-spacing: 1px;
    }
    .btn-elite-sky:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(56, 189, 248, 0.3); }

    .icon-box-sm {
        width: 35px; height: 35px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
    }
</style>
@endsection
