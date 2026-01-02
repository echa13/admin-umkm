@extends('layouts.admin.app')

@section('title', 'Profil Pengguna - ' . $user->name)

@section('content')
<div class="container-fluid py-4 px-4" style="background: #f8fafc; min-height: 100vh;">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-black text-slate-800 m-0 tracking-tight">User <span class="text-sky">Intelligence</span></h2>
            <p class="text-slate-500 small mb-0">Informasi autentikasi dan berkas digital milik pengguna.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('users.index') }}" class="btn btn-elite-dark px-4 shadow-sm">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning px-4 fw-bold text-white shadow-sm rounded-3">
                <i class="fas fa-edit me-2"></i> Edit Profil
            </a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card elite-card border-0 shadow-lg overflow-hidden" style="border-radius: 25px;">
                <div class="card-body p-0">
                    <div class="profile-header bg-slate-900 position-relative" style="height: 100px;">
                        <div class="avatar-container shadow-lg">
                            @php $foto = $user->media->first()->file_name ?? null; @endphp
                            <img src="{{ $foto ? asset('storage/user_media/' . $foto) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=38bdf8&color=0f172a&bold=true' }}"
                                 alt="Avatar">
                            <span class="status-indicator {{ $user->is_active ? 'bg-success' : 'bg-danger' }}"></span>
                        </div>
                    </div>

                    <div class="p-4 pt-5 text-center mt-3">
                        <h4 class="fw-black text-slate-800 mb-1">{{ $user->name }}</h4>
                        <span class="badge bg-sky-subtle text-sky rounded-pill px-3 py-1 fw-bold x-small mb-3">
                            <i class="fas fa-shield-alt me-1"></i> {{ strtoupper($user->role) }}
                        </span>
                        <p class="text-slate-500 small mb-4"><i class="fas fa-envelope me-2"></i>{{ $user->email }}</p>

                        <div class="separator mb-4"></div>

                        <div class="row g-3 text-start">
                            <div class="col-6">
                                <label class="info-label">User ID</label>
                                <div class="info-value-sm">#{{ $user->id }}</div>
                            </div>
                            <div class="col-6">
                                <label class="info-label">Status Akun</label>
                                <div class="info-value-sm text-{{ $user->is_active ? 'success' : 'danger' }}">
                                    {{ $user->is_active ? 'Terverifikasi' : 'Ditangguhkan' }}
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="info-label">Tanggal Registrasi</label>
                                <div class="info-value-sm text-slate-600">
                                    <i class="far fa-calendar-alt me-1"></i> {{ $user->created_at->format('d F Y') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card elite-card border-0 shadow-lg h-100" style="border-radius: 25px;">
                <div class="card-header bg-white border-0 py-4 px-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-black text-slate-800 mb-0">Digital Asset Repository</h5>
                        <p class="text-slate-400 x-small mb-0">Berkas gambar dan dokumen yang diunggah pengguna.</p>
                    </div>
                    <span class="badge bg-slate-100 text-slate-600 px-3 py-2 rounded-4 fw-bold">
                        {{ $media->count() }} Berkas
                    </span>
                </div>

                <div class="card-body p-4 pt-0">
                    @if ($media->count() == 0)
                        <div class="text-center py-5">
                            <div class="icon-box-lg bg-light text-slate-300 mx-auto mb-3">
                                <i class="fas fa-folder-open fa-2x"></i>
                            </div>
                            <h6 class="text-slate-400 fw-bold">Tidak ada media ditemukan</h6>
                        </div>
                    @else
                        <div class="row g-3">
                            @foreach ($media as $m)
                                <div class="col-md-4 col-sm-6">
                                    <div class="asset-card shadow-sm h-100 border">
                                        <div class="asset-preview">
                                            @if (str_starts_with($m->mime_type, 'image/'))
                                                <img src="{{ asset('storage/user_media/' . $m->file_name) }}" alt="Preview">
                                            @else
                                                <div class="file-icon-placeholder">
                                                    <i class="fas fa-file-alt fa-3x text-slate-200"></i>
                                                </div>
                                            @endif
                                            <div class="asset-overlay">
                                                <a href="{{ asset('storage/user_media/' . $m->file_name) }}" target="_blank" class="btn btn-sky btn-sm rounded-pill px-3 fw-bold">
                                                    <i class="fas fa-external-link-alt me-1"></i> Lihat
                                                </a>
                                            </div>
                                        </div>
                                        <div class="p-3">
                                            <p class="text-truncate small fw-bold text-slate-700 mb-1">{{ $m->file_name }}</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="x-small text-slate-400">{{ strtoupper(explode('/', $m->mime_type)[1] ?? 'FILE') }}</span>
                                                <span class="x-small text-slate-400"><i class="fas fa-clock me-1"></i>{{ $m->created_at->diffForHumans() }}</span>
                                            </div>
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
</div>

<style>
    :root {
        --slate-900: #0f172a;
        --slate-800: #1e293b;
        --slate-600: #475569;
        --slate-500: #64748b;
        --slate-400: #94a3b8;
        --slate-100: #f1f5f9;
        --sky: #38bdf8;
    }

    .fw-black { font-weight: 900; }
    .x-small { font-size: 0.65rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; }
    .text-sky { color: var(--sky) !important; }
    .bg-sky-subtle { background-color: #e0f2fe; }

    /* AVATAR STYLE */
    .avatar-container {
        position: absolute;
        bottom: -40px;
        left: 50%;
        transform: translateX(-50%);
        width: 100px;
        height: 100px;
        border-radius: 30px;
        border: 5px solid #fff;
        background: #fff;
        overflow: visible;
    }
    .avatar-container img { width: 100%; height: 100%; object-fit: cover; border-radius: 25px; }
    .status-indicator {
        position: absolute;
        bottom: -5px;
        right: -5px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: 4px solid #fff;
    }

    /* INFO STYLE */
    .info-label { font-size: 0.6rem; font-weight: 800; text-transform: uppercase; color: var(--slate-400); margin-bottom: 2px; display: block; }
    .info-value-sm { font-weight: 800; font-size: 0.9rem; color: var(--slate-800); }
    .separator { height: 1px; background: linear-gradient(to right, transparent, var(--slate-100), transparent); }

    /* ASSET CARD */
    .asset-card { border-radius: 18px; overflow: hidden; background: #fff; transition: 0.3s; }
    .asset-card:hover { transform: translateY(-5px); }
    .asset-preview { position: relative; height: 140px; background: #f8fafc; overflow: hidden; }
    .asset-preview img { width: 100%; height: 100%; object-fit: cover; }
    .file-icon-placeholder { height: 100%; display: flex; align-items: center; justify-content: center; }

    .asset-overlay {
        position: absolute; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(15, 23, 42, 0.7); display: flex; align-items: center; justify-content: center;
        opacity: 0; transition: 0.3s;
    }
    .asset-preview:hover .asset-overlay { opacity: 1; }

    /* MISC */
    .icon-box-lg { width: 80px; height: 80px; border-radius: 20px; display: flex; align-items: center; justify-content: center; }
    .btn-elite-dark { background: var(--slate-900); color: #fff; border-radius: 12px; font-weight: 700; border: none; font-size: 0.85rem; }
    .btn-sky { background: var(--sky); color: var(--slate-900); border: none; }
</style>
@endsection
