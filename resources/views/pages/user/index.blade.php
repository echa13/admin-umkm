@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid pt-4 px-4">
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="text-primary fw-bold mb-0">
                <i class="fa fa-users me-2"></i>Daftar User
            </h4>
            <a href="{{ route('users.create') }}" class="btn btn-primary rounded-pill px-3">
                <i class="fa fa-plus me-2"></i>Tambah User
            </a>
        </div>

        {{-- Alert --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Search --}}
        <form action="{{ route('users.index') }}" method="GET" class="d-flex gap-2 mb-4 flex-wrap">
            <input type="text" name="search" class="form-control" placeholder="Cari nama / email..."
                value="{{ request('search') }}" style="width: 220px;">
            <button type="submit" class="btn btn-primary">Cari</button>
        </form>

        {{-- Empty State --}}
        @if ($users->isEmpty())
            <div class="text-center py-5">
                <img src="{{ asset('asset/img/empty-state.svg') }}" alt="No Data" width="130" class="opacity-75 mb-3">
                <p class="text-muted mb-0">Belum ada data user yang tersimpan.</p>
            </div>
        @else
            {{-- Users Grid --}}
            <div class="row g-4">
                @foreach ($users as $user)
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="card border-0 shadow-sm h-100 user-card">
                            <div class="card-body text-center p-3">
                                {{-- Avatar --}}
                                @php
                                    $foto = $user->media->first()->file_name ?? null;
                                @endphp

                                <img src="{{ $foto ? asset('storage/user_media/' . $foto) : asset('asset/img/default.png') }}"
                                    alt="User Avatar" class="rounded-circle border border-3 border-primary shadow-sm"
                                    width="70" height="70" style="object-fit: cover;">


                                {{-- User Info --}}
                                <h6 class="fw-bold mb-1 text-dark">{{ $user->name }}</h6>
                                <p class="text-muted small mb-2">{{ $user->email }}</p>
                                <p class="small text-secondary mb-3">
                                    <i class="fa fa-calendar me-1 text-primary"></i>
                                    Dibuat: {{ $user->created_at->format('d M Y') }}
                                </p>

                                {{-- Action Buttons --}}
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning px-3">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-info px-3">
                                        <i class="fa fa-eye"></i>
                                    </a>

                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus user ini?')" class="m-0">
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

            {{-- Pagination --}}
            <div class="mt-3 d-flex justify-content-center">
                {{ $users->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>

    {{-- Custom CSS --}}
    <style>
        /* Card Hover */
        .user-card {
            transition: transform 0.25s ease-in-out, box-shadow 0.25s ease-in-out;
            border-radius: 1rem;
        }

        .user-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }

        /* Buttons */
        .btn-warning.btn-sm,
        .btn-danger.btn-sm {
            border-radius: 8px;
            padding: 4px 10px;
            transition: transform 0.2s;
        }

        .btn-warning.btn-sm:hover,
        .btn-danger.btn-sm:hover {
            transform: scale(1.05);
        }

        /* Pagination */
        .pagination .page-link {
            padding: 0.25rem 0.5rem;
            font-size: 0.85rem;
        }

        .pagination .page-item.active .page-link {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        /* Responsive text */
        @media (max-width: 576px) {
            .user-card h6 {
                font-size: 0.95rem;
            }

            .user-card p {
                font-size: 0.75rem;
            }
        }
    </style>
@endsection
