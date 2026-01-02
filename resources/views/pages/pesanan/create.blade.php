@extends('layouts.admin.app')

@section('title', 'Tambah Pesanan Baru')

@section('content')
<div class="container-fluid py-4 px-4" style="background: #f8fafc; min-height: 100vh;">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-black text-slate-800 m-0 tracking-tight">Create <span class="text-sky">Order</span></h2>
            <p class="text-slate-500 small mb-0">Input data transaksi pesanan baru ke dalam sistem.</p>
        </div>
        <a href="{{ route('pesanan.index') }}" class="btn btn-elite-dark px-4 shadow-sm">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-12 col-xl-10">
            @if ($errors->any())
                <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="d-flex align-items-center text-danger">
                        <i class="fas fa-shield-virus me-3 fa-lg"></i>
                        <ul class="mb-0 small fw-bold">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('pesanan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-4">

                    <div class="col-lg-7">
                        <div class="card elite-card border-0 shadow-lg h-100" style="border-radius: 25px;">
                            <div class="card-header bg-slate-900 py-3 px-4 border-0">
                                <div class="d-flex align-items-center">
                                    <div class="icon-box-sm bg-sky text-dark me-3">
                                        <i class="fas fa-shopping-cart"></i>
                                    </div>
                                    <h5 class="text-white fw-bold mb-0">Rincian Transaksi</h5>
                                </div>
                            </div>
                            <div class="card-body p-4 bg-white">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label-elite">Nomor Pesanan</label>
                                        <div class="input-group-elite">
                                            <span class="input-icon"><i class="fas fa-barcode"></i></span>
                                            <input type="text" name="nomor_pesanan" class="form-control-elite" placeholder="Contoh: ORD-2023001" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label-elite">Pilih Warga</label>
                                        <div class="input-group-elite">
                                            <span class="input-icon"><i class="fas fa-user-tag"></i></span>
                                            <select name="warga_id" class="form-select-elite" required>
                                                <option value="" disabled selected>-- Pilih Pemesan --</option>
                                                @foreach($wargas as $w)
                                                    <option value="{{ $w->warga_id }}">{{ $w->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label-elite">Total Harga</label>
                                        <div class="input-group-elite">
                                            <span class="input-icon fw-bold">Rp</span>
                                            <input type="number" name="total" class="form-control-elite" placeholder="0" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label-elite">Status Awal</label>
                                        <div class="input-group-elite">
                                            <span class="input-icon"><i class="fas fa-tasks"></i></span>
                                            <select name="status" class="form-select-elite" required>
                                                <option value="pending">Pending</option>
                                                <option value="dibayar">Dibayar</option>
                                                <option value="dikirim">Dikirim</option>
                                                <option value="selesai">Selesai</option>
                                                <option value="dibatalkan">Dibatalkan</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label-elite">Metode Pembayaran</label>
                                        <div class="input-group-elite">
                                            <span class="input-icon"><i class="fas fa-wallet"></i></span>
                                            <input type="text" name="metode_bayar" class="form-control-elite" placeholder="Contoh: Transfer Bank / COD" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="card elite-card border-0 shadow-lg mb-4" style="border-radius: 25px;">
                            <div class="card-header bg-slate-800 py-3 px-4 border-0">
                                <h5 class="text-white fw-bold mb-0 small uppercase letter-spacing-1">Logistik & Bukti</h5>
                            </div>
                            <div class="card-body p-4 bg-white">
                                <label class="form-label-elite">Alamat Pengiriman</label>
                                <div class="input-group-elite mb-3">
                                    <span class="input-icon"><i class="fas fa-map-pin"></i></span>
                                    <input type="text" name="alamat_kirim" class="form-control-elite" placeholder="Nama Jalan / Perumahan" required>
                                </div>

                                <div class="row g-2 mb-4">
                                    <div class="col-6">
                                        <input type="text" name="rt" class="form-control-elite px-3" placeholder="RT">
                                    </div>
                                    <div class="col-6">
                                        <input type="text" name="rw" class="form-control-elite px-3" placeholder="RW">
                                    </div>
                                </div>

                                <hr class="my-4 opacity-5">

                                <label class="form-label-elite">Bukti Pembayaran / Resi</label>
                                <div class="upload-placeholder mb-3">
                                    <div class="text-center py-4 border-dashed rounded-4 bg-light">
                                        <i class="fas fa-cloud-upload-alt text-sky fa-2x mb-2"></i>
                                        <p class="small text-slate-500 mb-0">Klik tombol di bawah untuk pilih file</p>
                                    </div>
                                </div>
                                <input type="file" name="bukti" id="bukti" class="form-control form-control-sm border-0 bg-light rounded-pill px-3" accept="image/*">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-elite-sky w-100 py-3 fw-black shadow-lg">
                            SIMPAN PESANAN BARU <i class="fas fa-check-circle ms-2"></i>
                        </button>
                    </div>

                </div>
            </form>
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
    .bg-slate-800 { background-color: var(--slate-800) !important; }
    .letter-spacing-1 { letter-spacing: 1px; }
    .border-dashed { border: 2px dashed #e2e8f0; }

    /* FORM STYLING */
    .form-label-elite {
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        color: var(--slate-500);
        margin-bottom: 6px;
        display: block;
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

    .form-control-elite, .form-select-elite {
        width: 100%;
        padding: 10px 12px 10px 40px;
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
    .btn-elite-dark:hover { background: var(--slate-800); color: var(--sky); }

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
