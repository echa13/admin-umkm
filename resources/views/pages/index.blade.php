@extends('layouts.admin.app')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <!-- CARD STATISTIK -->
        <div class="col-sm-6 col-xl-3">
            <div class="bg-primary text-white rounded p-4 d-flex align-items-center shadow-sm">
                <i class="fa fa-users fa-3x me-3"></i>
                <div>
                    <h6 class="mb-1">Total Warga</h6>
                    <h3 class="mb-0 fw-bold">{{ $totalWarga ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="bg-success text-white rounded p-4 d-flex align-items-center shadow-sm">
                <i class="fa fa-user-shield fa-3x me-3"></i>
                <div>
                    <h6 class="mb-1">Total User</h6>
                    <h3 class="mb-0 fw-bold">{{ $totalUser ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="bg-warning text-white rounded p-4 d-flex align-items-center shadow-sm">
                <i class="fa fa-store fa-3x me-3"></i>
                <div>
                    <h6 class="mb-1">Total UMKM</h6>
                    <h3 class="mb-0 fw-bold">{{ $totalUmkm ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- GRAFIK & DATA -->
    <div class="row g-4 mt-4">
        <!-- Grafik -->
        <div class="col-lg-8">
            <div class="bg-light rounded p-4 shadow-sm">
                <div class="d-flex justify-content-between mb-3">
                    <h5 class="text-primary fw-bold mb-0"><i class="fa fa-chart-line me-2"></i>Statistik UMKM</h5>
                    <select class="form-select form-select-sm w-auto">
                        <option>7 Hari Terakhir</option>
                        <option>30 Hari Terakhir</option>
                        <option>1 Tahun Terakhir</option>
                    </select>
                </div>
                <canvas id="chartUmkm" height="120"></canvas>
            </div>
        </div>

        <!-- Aktivitas Terbaru -->
        <div class="col-lg-4">
            <div class="bg-light rounded p-4 shadow-sm">
                <h5 class="text-primary fw-bold mb-3"><i class="fa fa-clock me-2"></i>Aktivitas Terbaru</h5>
                <ul class="list-group list-group-flush small">
                    @forelse ($activities ?? [] as $activity)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fa fa-circle text-success me-2"></i>{{ $activity->deskripsi }}</span>
                            <span class="text-muted">{{ $activity->created_at->diffForHumans() }}</span>
                        </li>
                    @empty
                        <li class="list-group-item text-muted text-center">Belum ada aktivitas.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <!-- Data Singkat -->
    <div class="row g-4 mt-4">
        <div class="col-lg-6">
            <div class="bg-light rounded p-4 shadow-sm">
                <h5 class="fw-bold text-primary mb-3"><i class="fa fa-users me-2"></i>5 Warga Terbaru</h5>
                <ul class="list-group list-group-flush small">
                    @forelse ($latestWarga ?? [] as $w)
                        <li class="list-group-item d-flex justify-content-between">
                            <span>{{ $w->nama }}</span>
                            <span class="text-muted">Baru ditambahkan</span>

                        </li>
                    @empty
                        <li class="list-group-item text-muted text-center">Belum ada data warga.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="bg-light rounded p-4 shadow-sm">
                <h5 class="fw-bold text-primary mb-3"><i class="fa fa-store me-2"></i>5 UMKM Terbaru</h5>
                <ul class="list-group list-group-flush small">
                    @forelse ($latestUmkm ?? [] as $u)
                        <li class="list-group-item d-flex justify-content-between">
                            <span>{{ $u->nama_usaha }}</span>
                            <span class="text-muted">{{ $u->created_at->diffForHumans() }}</span>
                        </li>
                    @empty
                        <li class="list-group-item text-muted text-center">Belum ada data UMKM.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Script Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('chartUmkm').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode($chartLabels ?? ['Jan','Feb','Mar','Apr','May']) !!},
        datasets: [{
            label: 'Jumlah UMKM',
            data: {!! json_encode($chartData ?? [5, 9, 7, 12, 15]) !!},
            borderColor: '#007bff',
            tension: 0.3,
            fill: false,
            borderWidth: 3
        }]
    },
    options: {
        scales: {
            y: { beginAtZero: true }
        },
        plugins: {
            legend: { display: false }
        }
    }
});
</script>

<style>
    .card, .bg-light {
        border-radius: 1rem;
    }
</style>
@endsection
