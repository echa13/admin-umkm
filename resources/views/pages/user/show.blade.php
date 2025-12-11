@extends('layouts.admin.app')

@section('title', 'Detail User')
@section('page', 'Manajemen User')
@section('page-title', 'Detail User')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-light rounded p-4 shadow-sm">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="mb-0">Detail User: {{ $user->name }}</h5>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <div class="row">

            {{-- ======================
                KOLOM KIRI – INFO USER
            ======================== --}}
            <div class="col-lg-4 col-md-5 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center">

                        {{-- Foto Profil --}}
                        @php
                            $foto = $user->media->first()->file_name ?? null;
                        @endphp

                        <img src="{{ $foto ? asset('storage/user_media/' . $foto) : asset('asset/img/default.png') }}"
                             class="rounded-circle mb-3 border border-3 border-primary shadow-sm"
                             width="120" height="120" style="object-fit: cover;">

                        <h6 class="fw-bold mb-1">{{ $user->name }}</h6>
                        <p class="text-muted mb-1">{{ $user->email }}</p>

                        <p class="small text-secondary">
                            <i class="fa fa-calendar text-primary me-1"></i>
                            Dibuat: {{ $user->created_at->format('d M Y') }}
                        </p>

                        <hr>

                        <h6 class="fw-bold mb-3 text-start">Informasi User</h6>
                        <p class="text-start"><strong>ID:</strong> {{ $user->id }}</p>
                        <p class="text-start"><strong>Email:</strong> {{ $user->email }}</p>
                        <p class="text-start"><strong>Status:</strong>
                            @if ($user->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-danger">Tidak Aktif</span>
                            @endif
                        </p>

                    </div>
                </div>
            </div>

            {{-- ======================
                KOLOM KANAN – MEDIA
            ======================== --}}
            <div class="col-lg-8 col-md-7 mb-4">
                <h6 class="fw-bold mb-3">Media User</h6>

                @if ($media->count() == 0)
                    <p class="text-muted">Belum ada media yang di-upload.</p>
                @else
                    <div class="row">
                        @foreach ($media as $m)
                            <div class="col-md-4 col-sm-6 mb-4">
                                <div class="card shadow-sm h-100">

                                    <div class="p-2 text-center">

                                        {{-- Jika Image --}}
                                        @if (str_starts_with($m->mime_type, 'image/'))
                                            <img src="{{ asset('storage/user_media/' . $m->file_name) }}"
                                                class="img-fluid rounded"
                                                style="height: 150px; width: 100%; object-fit: cover;">
                                        @else
                                            <i class="bi bi-file-earmark-text" style="font-size: 60px;"></i>
                                        @endif

                                        <p class="small mt-2 text-truncate">{{ $m->file_name }}</p>
                                    </div>

                                    <div class="card-footer bg-white border-0">
                                        <a href="{{ asset('storage/user_media/' . $m->file_name) }}"
                                            target="_blank"
                                            class="btn btn-sm btn-outline-primary w-100">
                                            <i class="fa fa-download me-1"></i> Lihat
                                        </a>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>

        </div>

    </div>
</div>
@endsection
