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

        @if($datas->isEmpty())
            <div class="text-center py-5">
                <img src="{{ asset('asset/img/empty-state.svg') }}" alt="No Data" width="120" class="mb-3 opacity-75">
                <p class="text-muted">Belum ada data warga yang tersimpan.</p>
            </div>
        @else
            <div class="row g-4">
                @foreach($datas as $w)
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body text-center p-4">
                                <div class="mb-3">
                                    <img src="{{ asset('asset/img/user.jpg') }}" alt="User"
                                         class="rounded-circle border border-2 border-primary shadow-sm"
                                         width="80" height="80" style="object-fit: cover;">
                                </div>
                                <h6 class="fw-bold mb-1">{{ $w->nama }}</h6>
                                <p class="text-muted small mb-2">{{ $w->no_ktp }}</p>

                                <div class="d-flex justify-content-center flex-wrap small text-muted mb-3">
                                    <span class="me-2"><i class="fa fa-venus-mars me-1 text-primary"></i>{{ $w->jenis_kelamin }}</span>
                                    <span class="me-2"><i class="fa fa-praying-hands me-1 text-primary"></i>{{ $w->agama }}</span>
                                    <span><i class="fa fa-briefcase me-1 text-primary"></i>{{ $w->pekerjaan ?? '-' }}</span>
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
        @endif
    </div>
</div>

@endsection
