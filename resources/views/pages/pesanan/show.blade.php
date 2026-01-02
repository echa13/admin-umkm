@extends('layouts.admin.app')

@section('title', 'Detail Pesanan #' . $pesanan->nomor_pesanan)

@section('content')
<div class="container-fluid py-4 px-4" style="background: #f8fafc; min-height: 100vh;">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-black text-slate-800 m-0 tracking-tight">Order <span class="text-sky">Summary</span></h2>
            <p class="text-slate-500 small mb-0">Rincian lengkap transaksi dan pengiriman pelanggan.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('pesanan.index') }}" class="btn btn-elite-dark px-4 shadow-sm">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
            <a href="{{ route('pesanan.edit', $pesanan->pesanan_id) }}" class="btn btn-elite-sky px-4 shadow-sm">
                <i class="fas fa-edit me-2"></i> Edit Data
            </a>
        </div>
    </div>

    <div class="card elite-card border-0 shadow-lg" style="border-radius: 25px; overflow: hidden;">
        <div class="row g-0">
            <div class="col-lg-4 bg-slate-900 d-flex flex-column align-items-center justify-content-center p-4">
                <p class="text-sky small fw-bold uppercase letter-spacing-1 mb-3">Bukti Pembayaran</p>
                <div class="img-container-elite shadow-lg">
                    @if($pesanan->media->first())
                        <img src="{{ asset('storage/pesanan/'.$pesanan->media->first()->file_name) }}"
                             alt="Bukti Bayar" class="img-fluid rounded-4">
                    @else
                        <div class="text-center text-slate-500 py-5">
                            <i class="fas fa-image fa-3x mb-3"></i>
                            <p class="small fw-bold mb-0">Belum Ada Bukti</p>
                        </div>
                    @endif
                </div>
                <div class="mt-4 text-center">
                    <span class="badge rounded-pill px-3 py-2 badge-{{ $pesanan->status }}">
                        <i class="fas fa-circle me-1 small"></i> Status: {{ ucfirst($pesanan->status) }}
                    </span>
                </div>
            </div>

            <div class="col-lg-8 bg-white">
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex justify-content-between align-items-start mb-5 border-bottom pb-4">
                        <div>
                            <h3 class="fw-black text-slate-800 mb-1">{{ $pesanan->nomor_pesanan }}</h3>
                            <p class="text-slate-400 small mb-0">Dipesan pada: {{ $pesanan->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <div class="text-end">
                            <label class="text-slate-400 small fw-bold uppercase d-block">Metode Bayar</label>
                            <span class="text-slate-800 fw-black h5"><i class="fas fa-wallet text-sky me-2"></i>{{ $pesanan->metode_bayar }}</span>
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="info-group">
                                <label class="info-label">Nama Pemesan</label>
                                <p class="info-value"><i class="fas fa-user-circle me-2 text-sky"></i>{{ $pesanan->warga->nama ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-group highlight">
                                <label class="info-label">Total Pembayaran</label>
                                <p class="info-value text-sky">Rp {{ number_format($pesanan->total,0,',','.') }}</p>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="info-group">
                                <label class="info-label">Alamat Pengiriman</label>
                                <p class="info-value mb-1">
                                    <i class="fas fa-map-marker-alt me-2 text-danger"></i>{{ $pesanan->alamat_kirim }}
                                </p>
                                <div class="d-flex gap-3 ms-4">
                                    <span class="badge bg-light text-slate-600 px-3 py-2 border">RT: {{ $pesanan->rt ?? '-' }}</span>
                                    <span class="badge bg-light text-slate-600 px-3 py-2 border">RW: {{ $pesanan->rw ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 p-4 bg-light rounded-4 border-start border-sky border-4">
                        <div class="d-flex align-items-center text-slate-600">
                            <i class="fas fa-info-circle me-3 text-sky"></i>
                            <p class="small mb-0">Pastikan alamat pengiriman dan bukti bayar sudah sesuai sebelum mengubah status ke <strong>"Dikirim"</strong> atau <strong>"Selesai"</strong>.</p>
                        </div>
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
    .letter-spacing-1 { letter-spacing: 1px; }

    /* IMAGE CONTAINER */
    .img-container-elite {
        max-width: 100%;
        border-radius: 20px;
        overflow: hidden;
        border: 4px solid rgba(56, 189, 248, 0.2);
        background: #1e293b;
    }

    /* INFO GROUP */
    .info-label {
        font-size: 0.65rem;
        font-weight: 800;
        text-transform: uppercase;
        color: var(--slate-400);
        margin-bottom: 5px;
        display: block;
        letter-spacing: 1px;
    }
    .info-value {
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--slate-800);
        margin-bottom: 0;
    }
    .info-group.highlight {
        background: rgba(56, 189, 248, 0.05);
        padding: 10px 15px;
        border-radius: 12px;
    }

    /* BADGE STATUS DYNAMICS */
    .badge-pending { background: #f59e0b; color: #fff; }
    .badge-dibayar { background: #38bdf8; color: #fff; }
    .badge-dikirim { background: #6366f1; color: #fff; }
    .badge-selesai { background: #10b981; color: #fff; }
    .badge-dibatalkan { background: #ef4444; color: #fff; }

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
