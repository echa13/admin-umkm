@extends('layouts.admin.app')

@section('title', 'Profil UMKM - ' . $umkm->nama_usaha)

@section('content')
<div class="container-fluid py-4 px-4" style="background: #f8fafc; min-height: 100vh;">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-black text-slate-800 m-0 tracking-tight">Business <span class="text-sky">Profile</span></h2>
            <p class="text-slate-500 small mb-0">Informasi lengkap dan legalitas unit usaha warga.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('umkm.index') }}" class="btn btn-elite-dark px-4 shadow-sm">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
            <a href="{{ route('umkm.edit', $umkm->umkm_id) }}" class="btn btn-warning px-4 fw-bold text-white shadow-sm rounded-3">
                <i class="fas fa-edit me-2"></i> Edit Data
            </a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card elite-card border-0 shadow-lg mb-4" style="border-radius: 25px;">
                <div class="card-header bg-slate-900 py-3 px-4 border-0">
                    <div class="d-flex align-items-center">
                        <div class="icon-box-sm bg-sky text-dark me-3">
                            <i class="fas fa-id-card"></i>
                        </div>
                        <h5 class="text-white fw-bold mb-0">Identitas Usaha</h5>
                    </div>
                </div>
                <div class="card-body p-4 p-md-5">
                    <div class="row g-4 mb-5">
                        <div class="col-md-6">
                            <div class="info-group">
                                <label class="info-label">Nama Unit Usaha</label>
                                <div class="info-value text-slate-800">{{ $umkm->nama_usaha }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-group">
                                <label class="info-label">Pemilik / Penanggung Jawab</label>
                                <div class="info-value d-flex align-items-center">
                                    <div class="avatar-xs bg-light text-slate-600 me-2"><i class="fas fa-user-check"></i></div>
                                    {{ $umkm->pemilik?->nama ?? '-' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-group">
                                <label class="info-label">Kategori Bidang</label>
                                <span class="badge bg-sky-subtle text-sky border border-sky-subtle px-3 py-2 rounded-pill fw-bold">
                                    <i class="fas fa-tag me-1 small"></i> {{ $umkm->kategori }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-group">
                                <label class="info-label">Terdaftar Sejak</label>
                                <div class="info-value text-slate-500 small">
                                    <i class="fas fa-calendar-alt me-1"></i> {{ $umkm->created_at->format('d F Y') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="separator mb-4"></div>

                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="info-group p-3 bg-light rounded-4">
                                <label class="info-label">Titik Lokasi</label>
                                <div class="fw-black text-slate-700">RT {{ $umkm->rt }} / RW {{ $umkm->rw }}</div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="info-group p-3 bg-light rounded-4">
                                <label class="info-label">Alamat Lengkap</label>
                                <div class="fw-bold text-slate-600">{{ $umkm->alamat }}</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="info-group">
                                <label class="info-label">Hubungi Unit Bisnis</label>
                                <a href="https://wa.me/{{ $umkm->kontak }}" target="_blank" class="btn btn-outline-success border-2 fw-black rounded-pill">
                                    <i class="fab fa-whatsapp me-2"></i> {{ $umkm->kontak }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card elite-card border-0 shadow-lg" style="border-radius: 25px;">
                <div class="card-body p-4">
                    <h6 class="text-sky fw-black text-uppercase small letter-spacing-1 mb-3">Narasi Usaha</h6>
                    <p class="text-slate-600 mb-0 italic" style="line-height: 1.8; font-size: 1.05rem;">
                        "{{ $umkm->deskripsi ?? 'Pemilik belum menambahkan deskripsi untuk unit usaha ini.' }}"
                    </p>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card elite-card border-0 shadow-lg overflow-hidden mb-4" style="border-radius: 25px;">
                <div class="card-header bg-white border-0 py-3 text-center">
                    <span class="x-small fw-black text-slate-400">Main Display Image</span>
                </div>
                <div class="card-body p-3">
                    @php $foto = $umkm->media->first(); @endphp
                    <div class="main-image-frame shadow-sm">
                        @if ($foto && $foto->file_name)
                            <img src="{{ asset('storage/umkm_media/' . $foto->file_name) }}" class="img-fluid" alt="Foto UMKM">
                        @else
                            <img src="{{ asset('asset/img/logo-umkm.png') }}" class="img-fluid opacity-50" alt="Default UMKM">
                        @endif
                    </div>
                </div>
            </div>

            <div class="card elite-card border-0 shadow-lg" style="border-radius: 25px;">
                <div class="card-body p-4">
                    <h6 class="text-slate-800 fw-black small mb-3">Galeri Unit Usaha</h6>
                    <div class="d-flex flex-wrap gap-2">
                        @forelse($umkm->media as $m)
                            <div class="gallery-thumb">
                                <img src="{{ asset('storage/umkm_media/' . $m->file_name) }}" alt="Gallery">
                            </div>
                        @empty
                            <div class="text-center w-100 py-4 border rounded-4 bg-light">
                                <i class="fas fa-images text-slate-300 mb-2 fa-2x"></i>
                                <p class="x-small text-slate-400 mb-0">Tidak ada foto tambahan</p>
                            </div>
                        @endforelse
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
        --slate-700: #334155;
        --slate-600: #475569;
        --slate-500: #64748b;
        --slate-400: #94a3b8;
        --slate-300: #cbd5e1;
        --sky: #38bdf8;
        --sky-subtle: #e0f2fe;
    }

    .fw-black { font-weight: 900; }
    .text-sky { color: var(--sky) !important; }
    .bg-slate-900 { background-color: var(--slate-900) !important; }
    .letter-spacing-1 { letter-spacing: 1px; }
    .x-small { font-size: 0.65rem; font-weight: 800; text-transform: uppercase; }

    /* INFO STYLING */
    .info-label {
        font-size: 0.65rem;
        font-weight: 800;
        text-transform: uppercase;
        color: var(--slate-400);
        margin-bottom: 5px;
        display: block;
        letter-spacing: 0.5px;
    }
    .info-value {
        font-weight: 800;
        font-size: 1.1rem;
        color: var(--slate-800);
    }
    .separator { height: 1px; background: linear-gradient(to right, var(--slate-100), transparent); }

    /* IMAGE STYLING */
    .main-image-frame {
        width: 100%;
        height: 250px;
        border-radius: 20px;
        overflow: hidden;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .main-image-frame img { width: 100%; height: 100%; object-fit: cover; }

    .gallery-thumb {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        overflow: hidden;
        border: 2px solid #fff;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    }
    .gallery-thumb img { width: 100%; height: 100%; object-fit: cover; }

    .avatar-xs {
        width: 28px; height: 28px; border-radius: 8px;
        display: flex; align-items: center; justify-content: center; font-size: 0.75rem;
    }

    /* BUTTONS */
    .btn-elite-dark {
        background: var(--slate-900);
        color: #fff; border-radius: 12px; font-weight: 700; border: none; font-size: 0.85rem;
    }
    .btn-elite-dark:hover { background: var(--slate-800); color: var(--sky); }

    .icon-box-sm {
        width: 35px; height: 35px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
    }
</style>
@endsection
