@extends('layouts.admin.app')

@section('title', 'Edit Detail Pesanan')

@section('content')
<div class="container-fluid py-4 px-4" style="background: #f8fafc; min-height: 100vh;">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-black text-slate-800 m-0 tracking-tight">Edit Detail <span class="text-sky">Pesanan</span></h2>
            <p class="text-slate-500 small mb-0">Perbarui rincian produk dan kuantitas pesanan pelanggan.</p>
        </div>
        <a href="{{ route('detail_pesanan.index') }}" class="btn btn-elite-dark px-4 shadow-sm">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            @if ($errors->any())
                <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-circle me-3 fa-lg"></i>
                        <ul class="mb-0 small fw-bold">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <div class="card elite-card border-0 shadow-lg" style="border-radius: 25px; overflow: hidden;">
                <div class="card-header bg-slate-900 py-3 px-4 border-0">
                    <div class="d-flex align-items-center">
                        <div class="icon-box-sm bg-sky text-dark me-3">
                            <i class="fas fa-edit"></i>
                        </div>
                        <h5 class="text-white fw-bold mb-0">Formulir Perubahan Data</h5>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5 bg-white">
                    <form action="{{ route('detail_pesanan.update', $detail_pesanan->detail_id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="pesanan_id" class="form-label-elite">ID Pesanan (Nomor)</label>
                                <div class="input-group-elite">
                                    <span class="input-icon"><i class="fas fa-hashtag"></i></span>
                                    <select name="pesanan_id" id="pesanan_id" class="form-select-elite" required>
                                        @foreach($pesanans as $p)
                                            <option value="{{ $p->pesanan_id }}" {{ $p->pesanan_id == $detail_pesanan->pesanan_id ? 'selected' : '' }}>
                                                #{{ $p->nomor_pesanan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="produk_id" class="form-label-elite">Pilih Produk</label>
                                <div class="input-group-elite">
                                    <span class="input-icon"><i class="fas fa-box"></i></span>
                                    <select name="produk_id" id="produk_id" class="form-select-elite" required>
                                        @foreach($produks as $prod)
                                            <option value="{{ $prod->produk_id }}" {{ $prod->produk_id == $detail_pesanan->produk_id ? 'selected' : '' }}>
                                                {{ $prod->nama_produk }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="qty" class="form-label-elite">Kuantitas (Qty)</label>
                                <div class="input-group-elite">
                                    <span class="input-icon"><i class="fas fa-sort-numeric-up-alt"></i></span>
                                    <input type="number" name="qty" id="qty" class="form-control-elite"
                                           value="{{ $detail_pesanan->qty }}" placeholder="0" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="harga_satuan" class="form-label-elite">Harga Satuan (Rp)</label>
                                <div class="input-group-elite">
                                    <span class="input-icon fw-bold">Rp</span>
                                    <input type="number" name="harga_satuan" id="harga_satuan" class="form-control-elite"
                                           value="{{ $detail_pesanan->harga_satuan }}" placeholder="0" required>
                                </div>
                            </div>

                            <div class="col-12 mt-5">
                                <button type="submit" class="btn btn-elite-sky w-100 py-3 fw-black shadow-sm">
                                    SIMPAN PERUBAHAN <i class="fas fa-save ms-2"></i>
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
        --sky: #38bdf8;
    }

    .fw-black { font-weight: 900; }
    .text-sky { color: var(--sky) !important; }
    .bg-slate-900 { background-color: var(--slate-900) !important; }
    .tracking-tight { letter-spacing: -0.5px; }

    /* FORM STYLING */
    .form-label-elite {
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        color: var(--slate-500);
        margin-bottom: 8px;
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
        font-size: 0.9rem;
    }

    .form-control-elite, .form-select-elite {
        width: 100%;
        padding: 12px 12px 12px 45px;
        border-radius: 12px;
        border: 2px solid #f1f5f9;
        background-color: #f8fafc;
        font-weight: 600;
        color: var(--slate-800);
        transition: all 0.3s;
    }

    .form-control-elite:focus, .form-select-elite:focus {
        outline: none;
        border-color: var(--sky);
        background-color: #fff;
        box-shadow: 0 0 0 4px rgba(56, 189, 248, 0.1);
    }

    /* BUTTONS */
    .btn-elite-dark {
        background: var(--slate-900);
        color: #fff;
        border-radius: 12px;
        font-weight: 700;
        border: none;
        transition: 0.3s;
    }
    .btn-elite-dark:hover { background: var(--slate-800); color: var(--sky); }

    .btn-elite-sky {
        background: var(--sky);
        color: var(--slate-900);
        border-radius: 15px;
        border: none;
        letter-spacing: 1px;
        transition: 0.3s;
    }
    .btn-elite-sky:hover {
        background: var(--slate-900);
        color: var(--sky);
        transform: translateY(-2px);
    }

    .icon-box-sm {
        width: 35px;
        height: 35px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endsection
