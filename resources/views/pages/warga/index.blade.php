@extends('layouts.admin.app')
@section('content')

    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded p-4 shadow-sm">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h4 class="mb-0 text-primary fw-bold">
                    <i class="fa fa-users me-2"></i>Data Warga
                </h4>
                <a href="{{ route('warga.create') }}" class="btn btn-primary rounded-pill px-3">
                    <i class="fa fa-plus me-2"></i>Tambah Warga
                </a>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form method="GET" action="{{ route('warga.index') }}" class="mb-4 d-flex flex-wrap gap-2">

                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau NIK..."
                    class="form-control" style="width: 250px;">

                <select name="jenis_kelamin" class="form-select" style="width: 200px;">
                    <option value="">-- Semua Gender --</option>
                    <option value="Laki-laki" {{ request('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                    </option>
                    <option value="Perempuan" {{ request('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan
                    </option>
                </select>

                <button type="submit" class="btn btn-primary">Filter</button>
            </form>

            @if ($datas->isEmpty())
                <div class="text-center py-5">
                    <img src="{{ asset('asset/img/empty-state.svg') }}" alt="No Data" width="120"
                        class="mb-3 opacity-75">
                    <p class="text-muted">Belum ada data warga yang tersimpan.</p>
                </div>
            @else
                <div class="row g-4">
                    @foreach ($datas as $w)
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body text-center p-4">
                                    <div class="mb-3">
                                        <img src="{{ asset('asset/img/user.jpg') }}" alt="User"
                                            class="rounded-circle border border-2 border-primary shadow-sm" width="80"
                                            height="80" style="object-fit: cover;">
                                    </div>
                                    <h6 class="fw-bold mb-1">{{ $w->nama }}</h6>
                                    <p class="text-muted small mb-2">{{ $w->no_ktp }}</p>

                                    <div class="d-flex justify-content-center flex-wrap small text-muted mb-3">
                                        <span class="me-2"><i
                                                class="fa fa-venus-mars me-1 text-primary"></i>{{ $w->jenis_kelamin }}</span>
                                        <span class="me-2"><i
                                                class="fa fa-praying-hands me-1 text-primary"></i>{{ $w->agama }}</span>
                                        <span><i
                                                class="fa fa-briefcase me-1 text-primary"></i>{{ $w->pekerjaan ?? '-' }}</span>
                                    </div>

                                    <div class="mb-3 small">
                                        <i class="fa fa-phone me-2 text-success"></i>{{ $w->telp ?? '-' }}<br>
                                        <i class="fa fa-envelope me-2 text-danger"></i>{{ $w->email ?? '-' }}
                                    </div>

                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('warga.edit', $w->warga_id) }}"
                                            class="btn btn-sm btn-warning px-3">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form action="{{ route('warga.destroy', $w->warga_id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger px-3">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4 d-flex justify-content-center">
                    {{ $datas->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>

    <style>
        /* CARD WARGA */
        .warga-card {
            border-radius: 18px;
            overflow: hidden;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08);
            background: #ffffff;
        }

        .warga-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12);
        }

        /* HEADER */
        .warga-header {
            background: linear-gradient(135deg, #2a6df4, #4f8dfc);
            color: #fff;
            padding: 12px;
            text-align: center;
            border-bottom: none;
        }

        /* AVATAR CIRCLE */
        .avatar-wrapper {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            background: linear-gradient(135deg, #dfe9ff, #f3f6ff);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .avatar-wrapper i {
            font-size: 40px;
            color: #2a6df4;
        }

        /* TEXT LIST */
        .info-list p {
            margin: 6px 0;
            font-size: 14px;
        }

        /* BUTTONS */
        .btn-warning.btn-sm {
            border-radius: 10px;
            padding: 6px 10px;
        }

        .btn-danger.btn-sm {
            border-radius: 10px;
            padding: 6px 10px;
        }

        /* Hover animated */
        .btn-warning:hover,
        .btn-danger:hover {
            transform: scale(1.05);
            transition: 0.2s;
        }

        .pagination .page-link {
            padding: 0.25rem 0.5rem;
            /* lebih kecil */
            font-size: 0.85rem;
            /* ukuran font kecil */
        }

        .pagination .page-item.active .page-link {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
    </style>
@endsection
