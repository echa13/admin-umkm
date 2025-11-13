@extends('layouts.admin.app')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-light rounded p-4 shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="text-primary fw-bold mb-0">
                <i class="fa fa-users me-2"></i>Daftar User
            </h4>
            <a href="{{ route('users.create') }}" class="btn btn-primary rounded-pill px-3">
                <i class="fa fa-plus me-2"></i>Tambah User
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($users->isEmpty())
            <div class="text-center py-5">
                <img src="{{ asset('asset/img/empty-state.svg') }}" alt="No Data" width="130" class="opacity-75 mb-3">
                <p class="text-muted mb-0">Belum ada data user yang tersimpan.</p>
            </div>
        @else
            <div class="row g-4">
                @foreach ($users as $user)
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="card border-0 shadow-sm h-100 user-card hover-lift">
                            <div class="card-body text-center p-4">
                                <div class="position-relative d-inline-block mb-3">
                                    <img src="{{ asset('asset/img/user.jpg') }}"
                                         alt="User Avatar"
                                         class="rounded-circle border border-3 border-primary shadow-sm"
                                         width="80" height="80" style="object-fit: cover;">
                                    <span class="position-absolute bottom-0 end-0 translate-middle p-1 bg-success border border-2 border-white rounded-circle"></span>
                                </div>

                                <h6 class="fw-bold mb-1 text-dark">{{ $user->name }}</h6>
                                <p class="text-muted small mb-2">{{ $user->email }}</p>
                                <p class="small text-secondary">
                                    <i class="fa fa-calendar me-1 text-primary"></i>
                                    Dibuat: {{ $user->created_at->format('d M Y') }}
                                </p>

                                <div class="d-flex justify-content-center gap-2 mt-3">
                                    <a href="{{ route('users.edit', $user->id) }}"
                                       class="btn btn-sm btn-warning px-3 shadow-sm">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form action="{{ route('users.destroy', $user->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger px-3 shadow-sm">
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

{{-- Optional: Sedikit CSS tambahan untuk efek hover --}}
<style>
    .user-card {
        transition: all 0.25s ease-in-out;
        border-radius: 1rem;
    }
    .user-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.08);
    }
    .hover-lift {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
</style>
@endsection
