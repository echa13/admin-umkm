@extends('layouts.admin.app')

@section('title', 'Tambah Detail Pesanan')

@section('content')
<div class="container-fluid py-4 px-4" style="background: #f8fafc; min-height: 100vh;">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-black text-slate-800 m-0 tracking-tight">Create <span class="text-sky">Detail</span></h2>
            <p class="text-slate-500 small mb-0">Tambahkan rincian item baru ke dalam transaksi pesanan.</p>
        </div>
        <a href="{{ route('detail_pesanan.index') }}" class="btn btn-elite-dark px-4 shadow-sm">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            @if ($errors->any())
                <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="d-flex align-items-center text-danger">
                        <i class="fas fa-shield-alt me-3 fa-lg"></i>
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
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="icon-box-sm bg-sky text-dark me-3">
                                <i class="fas fa-plus-circle"></i>
                            </div>
                            <h5 class="text-white fw-bold mb-0">Formulir Entry Data</h5>
                        </div>
                        <span class="badge bg-white bg-opacity-10 text-sky px-3 py-2 fw-bold" style="font-size: 0.65rem; letter-spacing: 1px;">NEW RECORD</span>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5 bg-white">
                    <form action="{{ route('detail_pesanan.store') }}" method="POST">
                        @csrf

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="pesanan_id" class="form-label-elite">Nomor Pesanan</label>
                                <div class="input-group-elite">
                                    <span class="input-icon"><i class="fas fa-receipt"></i></span>
                                    <select name="pesanan_id" id="pesanan_id" class="form-select-elite" required>
                                        <option value="" disabled selected>-- Pilih Pesanan --</option>
                                        @foreach($pesanans as $p)
                                            <option value="{{ $p->pesanan_id }}">#{{ $p->nomor_pesanan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="produk_id" class="form-label-elite">Produk / Barang</label>
                                <div class="input-group-elite">
                                    <span class="input-icon"><i class="fas fa-box-open"></i></span>
                                    <select name="produk_id" id="produk_id" class="form-select-elite" required>
                                        <option value="" disabled selected>-- Pilih Produk --</option>
                                        @foreach($produks as $prod)
                                            <option value="{{ $prod->produk_id }}">{{ $prod->nama_produk }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="qty" class="form-label-elite">Jumlah (Qty)</label>
                                <div class="input-group-elite">
                                    <span class="input-icon"><i class="fas fa-layer-group"></i></span>
                                    <input type="number" name="qty" id="qty" class="form-control-elite"
                                           placeholder="Contoh: 5" required min="1">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="harga_satuan" class="form-label-elite">Harga Satuan</label>
                                <div class="input-group-elite">
                                    <span class="input-icon fw-bold">Rp</span>
                                    <input type="number" name="harga_satuan" id="harga_satuan" class="form-control-elite"
                                           placeholder="0" required>
                                </div>
                            </div>

                            <div class="col-12 mt-5">
                                <button type="submit" class="btn btn-elite-sky w-100 py-3 fw-black shadow-sm">
                                    SIMPAN DATA PESANAN <i class="fas fa-check-circle ms-2"></i>
                                </button>
                                <p class="text-center text-slate-400 x-small mt-3 fw-bold uppercase letter-spacing-1">
                                    Pastikan data yang dimasukkan sudah benar
                                </p>
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
        --sky: #38bdf8;
    }

    .fw-black { font-weight: 900; }
    .text-sky { color: var(--sky) !important; }
    .bg-slate-900 { background-color: var(--slate-900) !important; }
    .tracking-tight { letter-spacing: -1px; }
    .x-small { font-size: 0.65rem; }
    .uppercase { text-transform: uppercase; }

    /* FORM STYLING */
    .form-label-elite {
        font-size: 0.72rem;
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
        font-size: 0.85rem;
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
