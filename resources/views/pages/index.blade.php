@extends('layouts.admin.app')

@section('content')
<div class="container-fluid py-4 px-4" style="background: #f8fafc; min-height: 100vh;">

    <div class="header-box d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-slate-400 small">Main</a></li>
                    <li class="breadcrumb-item active small text-slate-500" aria-current="page">Command Center</li>
                </ol>
            </nav>
            <h2 class="fw-black text-slate-800 m-0 tracking-tight">Command <span class="text-sky">Center</span></h2>
            <p class="text-slate-500 small mb-0">Monitor seluruh ekosistem UMKM dalam satu layar kendali.</p>
        </div>
        <div class="action-area d-flex gap-2">
            <div class="btn-group shadow-sm">
                <button class="btn btn-white border-0 text-slate-600 small fw-bold shadow-sm px-3">
                    <i class="fas fa-file-export me-2 text-sky"></i> Laporan
                </button>
            </div>
            <button class="btn btn-elite-primary shadow-sm fw-bold px-4">
                <i class="fas fa-plus me-2"></i> Input Data
            </button>
        </div>
    </div>

    <div class="row g-4 mb-4">
        @php
            $stats = [
                ['label' => 'Total Warga', 'val' => $totalWarga ?? '1.240', 'icon' => 'fa-users', 'color' => '#38bdf8'],
                ['label' => 'Total UMKM', 'val' => $totalUmkm ?? '48', 'icon' => 'fa-store', 'color' => '#64748b'],
                ['label' => 'Pesanan Baru', 'val' => $totalPesanan ?? '156', 'icon' => 'fa-shopping-cart', 'color' => '#1e293b'],
                ['label' => 'Total Omzet', 'val' => 'Rp 12.5M', 'icon' => 'fa-wallet', 'color' => '#0f172a'],
            ];
        @endphp
        @foreach($stats as $s)
        <div class="col-sm-6 col-xl-3">
            <div class="card elite-card border-0 shadow-sm card-hover h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="icon-shape-elite" style="background: {{ $s['color'] }}10; color: {{ $s['color'] }};">
                            <i class="fa {{ $s['icon'] }}"></i>
                        </div>
                        <span class="text-success small fw-bold"><i class="fas fa-arrow-up me-1"></i>12%</span>
                    </div>
                    <h6 class="text-slate-400 text-uppercase x-small fw-black mb-1" style="letter-spacing: 1px;">{{ $s['label'] }}</h6>
                    <h3 class="fw-black text-slate-800 mb-0">{{ $s['val'] }}</h3>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card elite-card border-0 shadow-sm p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h5 class="fw-black text-slate-800 mb-0">Pertumbuhan Transaksi</h5>
                        <small class="text-slate-400 text-uppercase x-small fw-bold">Statistik Mingguan</small>
                    </div>
                    <ul class="nav nav-pills small bg-light rounded-pill p-1">
                        <li class="nav-item"><a class="nav-link active rounded-pill py-1 px-3" href="#">Mingguan</a></li>
                        <li class="nav-item"><a class="nav-link rounded-pill py-1 px-3 text-slate-500" href="#">Bulanan</a></li>
                    </ul>
                </div>
                <div style="height: 320px;">
                    <canvas id="mainChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card elite-card border-0 shadow-sm p-4 h-100">
                <h5 class="fw-black text-slate-800 mb-4">Kategori Terpopuler</h5>
                <div style="height: 220px;">
                    <canvas id="categoryChart"></canvas>
                </div>
                <div class="mt-4">
                    <div class="d-flex justify-content-between mb-3 p-2 rounded-3 hover-light transition-all">
                        <span class="text-slate-600 small fw-bold"><i class="fas fa-circle me-2" style="color: #1e293b"></i> Makanan</span>
                        <span class="fw-black text-slate-800">45%</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 p-2 rounded-3 hover-light transition-all">
                        <span class="text-slate-600 small fw-bold"><i class="fas fa-circle me-2" style="color: #38bdf8"></i> Kerajinan</span>
                        <span class="fw-black text-slate-800">30%</span>
                    </div>
                    <div class="d-flex justify-content-between p-2 rounded-3 hover-light transition-all">
                        <span class="text-slate-600 small fw-bold"><i class="fas fa-circle me-2" style="color: #cbd5e1"></i> Jasa</span>
                        <span class="fw-black text-slate-800">25%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card elite-card border-0 shadow-sm h-100">
                <div class="p-4 d-flex justify-content-between align-items-center">
                    <h5 class="fw-black text-slate-800 mb-0">Pesanan Baru</h5>
                    <a href="#" class="btn btn-light btn-sm rounded-pill px-3 fw-bold x-small text-slate-600">Lihat Semua</a>
                </div>
                <div class="table-responsive px-4 pb-4">
                    <table class="table table-borderless align-middle mb-0">
                        <thead class="text-slate-400 x-small text-uppercase">
                            <tr>
                                <th class="ps-0">ID Order</th>
                                <th>Pelanggan</th>
                                <th>Status</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody class="small">
                            @foreach(range(1, 4) as $item)
                            <tr class="border-bottom border-light">
                                <td class="ps-0 fw-bold text-slate-800">#ORD-0921{{ $item }}</td>
                                <td>
                                    <div class="fw-black text-slate-800">Warga Name {{ $item }}</div>
                                    <small class="text-slate-400">2 jam yang lalu</small>
                                </td>
                                <td>
                                    <span class="badge rounded-pill bg-success-subtle text-success px-3">Selesai</span>
                                </td>
                                <td class="text-end fw-black text-slate-800">Rp 125.000</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card elite-card border-0 shadow-sm h-100">
                <div class="p-4">
                    <h5 class="fw-black text-slate-800 mb-4">Aktivitas Sistem</h5>
                    <div class="activity-feed">
                        @foreach(range(1, 4) as $index)
                        <div class="d-flex mb-4">
                            <div class="flex-shrink-0">
                                <div class="activity-dot bg-slate-800 shadow-sm">
                                    <i class="fas fa-bolt x-small text-sky"></i>
                                </div>
                            </div>
                            <div class="ms-3 border-bottom border-light pb-3 w-100">
                                <p class="mb-1 small text-slate-700 fw-bold">UMKM <span class="text-sky">"Berkah Jaya"</span> menambahkan produk baru.</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-slate-400 x-small font-monospace">15:30 WIB</span>
                                    <span class="text-slate-800 fw-black x-small cursor-pointer">DETAIL <i class="fas fa-arrow-right ms-1"></i></span>
                                </div>
                            </div>
                        </div>
                        @endforeach
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
        --slate-400: #94a3b8;
        --sky: #38bdf8;
    }

    .fw-black { font-weight: 900; }
    .text-sky { color: var(--sky) !important; }
    .x-small { font-size: 0.7rem; }
    .tracking-tight { letter-spacing: -1px; }

    .elite-card { border-radius: 24px; background: #fff; }

    .card-hover { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    .card-hover:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(15, 23, 42, 0.1) !important;
    }

    .icon-shape-elite {
        width: 50px; height: 50px;
        border-radius: 15px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.2rem;
    }

    .btn-elite-primary {
        background: var(--slate-800); color: white; border-radius: 12px;
        transition: 0.3s; border: none;
    }
    .btn-elite-primary:hover { background: var(--slate-900); color: var(--sky); }

    .nav-pills .nav-link.active { background: var(--slate-800); color: var(--sky); font-weight: 800; }

    .bg-success-subtle { background-color: #f0fdf4 !important; }
    .text-success { color: #166534 !important; }

    .activity-dot {
        width: 32px; height: 32px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center; color: white;
    }

    .hover-light:hover { background: #f8fafc; cursor: pointer; }
    .transition-all { transition: 0.3s; }

    /* Custom Scrollbar */
    ::-webkit-scrollbar { width: 5px; }
    ::-webkit-scrollbar-thumb { background: var(--slate-400); border-radius: 10px; }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Line Chart: Transaksi
const ctxMain = document.getElementById('mainChart').getContext('2d');
let gradient = ctxMain.createLinearGradient(0, 0, 0, 300);
gradient.addColorStop(0, 'rgba(56, 189, 248, 0.2)');
gradient.addColorStop(1, 'rgba(255, 255, 255, 0)');

new Chart(ctxMain, {
    type: 'line',
    data: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        datasets: [{
            label: 'Transaksi',
            data: [30, 45, 35, 60, 50, 85, 75],
            borderColor: '#38bdf8',
            borderWidth: 4,
            tension: 0.4,
            fill: true,
            backgroundColor: gradient,
            pointRadius: 4,
            pointBackgroundColor: '#fff',
            pointBorderColor: '#38bdf8',
            pointBorderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: { grid: { borderDash: [5, 5] }, ticks: { color: '#94a3b8' } },
            x: { grid: { display: false }, ticks: { color: '#94a3b8', font: { weight: '700' } } }
        }
    }
});

// Doughnut Chart: Kategori
const ctxCat = document.getElementById('categoryChart').getContext('2d');
new Chart(ctxCat, {
    type: 'doughnut',
    data: {
        labels: ['Makanan', 'Kerajinan', 'Jasa'],
        datasets: [{
            data: [45, 30, 25],
            backgroundColor: ['#1e293b', '#38bdf8', '#cbd5e1'],
            borderWidth: 0,
            hoverOffset: 15
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '85%',
        plugins: { legend: { display: false } }
    }
});
</script>
@endsection
