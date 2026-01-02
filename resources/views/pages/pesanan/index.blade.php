
@extends('layouts.admin.app')

@section('content')
<div class="container-fluid py-4 px-4">
    <div class="header-box d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-slate-400 small">Dashboard</a></li>
                    <li class="breadcrumb-item active small text-slate-500" aria-current="page">Order Management</li>
                </ol>
            </nav>
            <h2 class="fw-black text-slate-800 m-0 tracking-tight">Daftar <span class="text-sky">Pesanan</span></h2>
            <p class="text-slate-500 small mb-0">Pantau dan kelola seluruh transaksi UMKM HUB.</p>
        </div>
        <div class="action-area">
            <a href="{{ route('pesanan.create') }}" class="btn btn-elite-primary shadow-sm">
                <i class="fas fa-plus-circle me-2"></i> Tambah Pesanan Baru
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
                <i class="fas fa-shopping-cart me-2 text-sky"></i>
                <span class="fw-bold text-white small text-uppercase letter-spacing-1">Master Order List</span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-elite align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">No. Pesanan</th>
                            <th>Pemesan</th>
                            <th>Total Bayar</th>
                            <th class="text-center">Status</th>
                            <th style="width: 250px;">Alamat Kirim</th>
                            <th class="text-center">Bukti/Resi</th>
                            <th class="text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pesanans as $p)
                        <tr>
                            <td class="ps-4">
                                <div class="order-tag">
                                    <span class="hash">#</span>{{ $p->nomor_pesanan }}
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar-small me-2">
                                        {{ substr($p->warga->nama ?? 'U', 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-slate-800 mb-0">{{ $p->warga->nama ?? 'Umum' }}</div>
                                        <small class="text-slate-400">ID: {{ $p->warga_id ?? '-' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="fw-black text-slate-900">Rp {{ number_format($p->total,0,',','.') }}</span>
                            </td>
                            <td class="text-center">
                                @php
                                    $statusStyle = [
                                        'pending' => ['bg' => '#fff7ed', 'color' => '#c2410c', 'border' => '#ffedd5', 'icon' => 'fa-clock'],
                                        'proses'  => ['bg' => '#f0f9ff', 'color' => '#0369a1', 'border' => '#e0f2fe', 'icon' => 'fa-sync'],
                                        'selesai' => ['bg' => '#f0fdf4', 'color' => '#15803d', 'border' => '#dcfce7', 'icon' => 'fa-check-circle'],
                                        'batal'   => ['bg' => '#fef2f2', 'color' => '#b91c1c', 'border' => '#fee2e2', 'icon' => 'fa-times-circle'],
                                    ][$p->status ?? ''] ?? ['bg' => '#f8fafc', 'color' => '#475569', 'border' => '#e2e8f0', 'icon' => 'fa-info-circle'];
                                @endphp
                                <span class="status-pill" style="background: {{ $statusStyle['bg'] }}; color: {{ $statusStyle['color'] }}; border: 1px solid {{ $statusStyle['border'] }}">
                                    <i class="fas {{ $statusStyle['icon'] }} me-1"></i> {{ ucfirst($p->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="address-box">
                                    <p class="text-truncate-2 mb-1" title="{{ $p->alamat_kirim }}">{{ $p->alamat_kirim }}</p>
                                    <span class="badge-location">RT {{ $p->rt ?? '-' }} / RW {{ $p->rw ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="text-center">
                                @php $media = optional($p->media->first()); @endphp
                                @if($media)
                                    <div class="receipt-wrapper">
                                        <a href="{{ asset('storage/pesanan/'.$media->file_name) }}" target="_blank">
                                            <img src="{{ asset('storage/pesanan/'.$media->file_name) }}" class="img-receipt" alt="bukti">
                                            <div class="receipt-overlay"><i class="fas fa-search-plus"></i></div>
                                        </a>
                                    </div>
                                @else
                                    <span class="no-receipt"><i class="fas fa-image-slash"></i></span>
                                @endif
                            </td>
                            <td class="pe-4">
                                <div class="action-bundle justify-content-center">
                                    <a href="{{ route('pesanan.show', $p->pesanan_id) }}" class="btn-action btn-view" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('pesanan.edit', $p->pesanan_id) }}" class="btn-action btn-edit" title="Edit">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form action="{{ route('pesanan.destroy', $p->pesanan_id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete"
                                                onclick="return confirm('Hapus pesanan ini?')" title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="fas fa-box-open fa-4x text-slate-200 mb-3"></i>
                                    <h5 class="fw-bold text-slate-700">Belum ada pesanan</h5>
                                    <p class="text-slate-400">Transaksi yang masuk akan muncul di sini.</p>
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
    /* CSS REUSE DARI DETAIL (UNIFIED THEME) */
    :root {
        --slate-900: #0f172a;
        --slate-800: #1e293b;
        --slate-600: #475569;
        --slate-500: #64748b;
        --slate-400: #94a3b8;
        --slate-200: #e2e8f0;
        --sky: #38bdf8;
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
        padding: 10px 20px; border-radius: 10px; border: none; transition: 0.3s;
    }
    .btn-elite-primary:hover { background: #0ea5e9; transform: translateY(-2px); color: white; }

    /* TABLE STYLE */
    .table-elite thead th {
        background: #f8fafc; color: var(--slate-600);
        font-size: 0.65rem; text-transform: uppercase;
        font-weight: 800; padding: 15px 10px;
        border-bottom: 2px solid #e2e8f0;
    }
    .table-elite td { padding: 18px 10px; border-bottom: 1px solid #f1f5f9; }

    /* ORDER TAG (MIRIP SIDEBAR) */
    .order-tag {
        display: inline-block; background: var(--slate-900);
        color: white; padding: 5px 12px; border-radius: 6px;
        font-family: 'Monaco', monospace; font-weight: 700; font-size: 0.8rem;
    }
    .order-tag .hash { color: var(--sky); }

    /* STATUS PILL MODERN */
    .status-pill {
        padding: 4px 12px; border-radius: 20px;
        font-size: 0.75rem; font-weight: 700; display: inline-flex; align-items: center;
    }

    /* AVATAR & ADDRESS */
    .user-avatar-small {
        width: 32px; height: 32px; background: #e2e8f0;
        color: var(--slate-600); display: flex; align-items: center;
        justify-content: center; border-radius: 8px; font-weight: 800; font-size: 0.8rem;
    }
    .address-box { font-size: 0.8rem; color: var(--slate-600); line-height: 1.4; }
    .text-truncate-2 {
        display: -webkit-box; -webkit-line-clamp: 2;
        -webkit-box-orient: vertical; overflow: hidden;
    }
    .badge-location {
        background: #f1f5f9; color: var(--slate-500);
        padding: 2px 8px; border-radius: 4px; font-size: 0.7rem; font-weight: 600;
    }

    /* RECEIPT IMAGE */
    .receipt-wrapper { position: relative; width: 45px; height: 45px; margin: 0 auto; }
    .img-receipt {
        width: 100%; height: 100%; object-fit: cover;
        border-radius: 8px; border: 2px solid #fff; shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .receipt-overlay {
        position: absolute; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(15, 23, 42, 0.6); color: white;
        display: flex; align-items: center; justify-content: center;
        border-radius: 8px; opacity: 0; transition: 0.3s;
    }
    .receipt-wrapper:hover .receipt-overlay { opacity: 1; }
    .no-receipt { color: #cbd5e1; font-size: 1.2rem; }

    /* ACTIONS (SAMA DENGAN DETAIL) */
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
