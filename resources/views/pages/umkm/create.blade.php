@extends('layouts.admin.app')

@section('title', 'Tambah Unit UMKM')

@section('content')
<div class="container-fluid py-4 px-4" style="background: #f8fafc; min-height: 100vh;">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-black text-slate-800 m-0 tracking-tight">Register <span class="text-sky">UMKM</span></h2>
            <p class="text-slate-500 small mb-0">Daftarkan unit usaha warga untuk memperluas jangkauan pasar digital.</p>
        </div>
        <a href="{{ route('umkm.index') }}" class="btn btn-elite-dark px-4 shadow-sm">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-12 col-xl-10">
            @if ($errors->any())
                <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="d-flex align-items-center text-danger">
                        <i class="fas fa-exclamation-triangle me-3 fa-lg"></i>
                        <ul class="mb-0 small fw-bold">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('umkm.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card elite-card border-0 shadow-lg overflow-hidden" style="border-radius: 25px;">
                    <div class="card-header bg-slate-900 py-3 px-4 border-0">
                        <div class="d-flex align-items-center">
                            <div class="icon-box-sm bg-sky text-dark me-3">
                                <i class="fas fa-store-alt"></i>
                            </div>
                            <h5 class="text-white fw-bold mb-0">Formulir Pendaftaran Usaha</h5>
                        </div>
                    </div>

                    <div class="card-body p-4 p-md-5 bg-white">
                        <div class="mb-5">
                            <h6 class="text-sky fw-black text-uppercase small letter-spacing-1 mb-4">
                                <i class="fas fa-info-circle me-2"></i> 1. Profil Bisnis Utama
                            </h6>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label-elite">Nama Unit Usaha</label>
                                    <div class="input-group-elite">
                                        <span class="input-icon"><i class="fas fa-briefcase"></i></span>
                                        <input type="text" name="nama_usaha" class="form-control-elite"
                                               value="{{ old('nama_usaha') }}" placeholder="Contoh: Kripik Barokah" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-elite">Pemilik (Warga)</label>
                                    <div class="input-group-elite">
                                        <span class="input-icon"><i class="fas fa-user-tie"></i></span>
                                        <select name="pemilik_warga_id" class="form-select-elite" required>
                                            <option value="" disabled selected>-- Pilih Pemilik Usaha --</option>
                                            @foreach($warga as $w)
                                                <option value="{{ $w->warga_id }}" {{ old('pemilik_warga_id') == $w->warga_id ? 'selected' : '' }}>
                                                    {{ $w->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label-elite">Kategori Bidang</label>
                                    <div class="input-group-elite">
                                        <span class="input-icon"><i class="fas fa-tags"></i></span>
                                        <input type="text" name="kategori" class="form-control-elite"
                                               value="{{ old('kategori') }}" placeholder="Kuliner, Kerajinan, Jasa Rumah Tangga, dll">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-5">
                            <h6 class="text-sky fw-black text-uppercase small letter-spacing-1 mb-4">
                                <i class="fas fa-map-marked-alt me-2"></i> 2. Lokasi & Akses Kontak
                            </h6>
                            <div class="row g-4">
                                <div class="col-md-3 col-6">
                                    <label class="form-label-elite">RT</label>
                                    <input type="text" name="rt" class="form-control-elite px-3" value="{{ old('rt') }}" placeholder="001">
                                </div>
                                <div class="col-md-3 col-6">
                                    <label class="form-label-elite">RW</label>
                                    <input type="text" name="rw" class="form-control-elite px-3" value="{{ old('rw') }}" placeholder="005">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-elite">Nomor Kontak / WA</label>
                                    <div class="input-group-elite">
                                        <span class="input-icon"><i class="fab fa-whatsapp"></i></span>
                                        <input type="text" name="kontak" class="form-control-elite" value="{{ old('kontak') }}" placeholder="0812xxxx">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label-elite">Alamat Lengkap</label>
                                    <div class="input-group-elite">
                                        <span class="input-icon"><i class="fas fa-map-marker-alt"></i></span>
                                        <input type="text" name="alamat" class="form-control-elite" value="{{ old('alamat') }}" placeholder="Jl. Raya No. X...">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h6 class="text-sky fw-black text-uppercase small letter-spacing-1 mb-4">
                                <i class="fas fa-photo-video me-2"></i> 3. Narasi & Visual
                            </h6>
                            <div class="row g-4">
                                <div class="col-lg-8">
                                    <label class="form-label-elite">Tentang Usaha (Deskripsi)</label>
                                    <textarea name="deskripsi" class="form-control-elite px-3" rows="5"
                                              placeholder="Ceritakan sejarah singkat atau produk unggulan usaha ini...">{{ old('deskripsi') }}</textarea>
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-label-elite">Foto Profil UMKM</label>
                                    <div class="upload-zone text-center p-4 border-dashed rounded-4 bg-light">
                                        <i class="fas fa-cloud-upload-alt text-slate-300 fa-2x mb-2"></i>
                                        <input type="file" name="foto" class="form-control form-control-sm border-0 bg-transparent" accept="image/*">
                                        <p class="x-small text-slate-400 mt-2 mb-0">Format: JPG/PNG (Max. 2MB)</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-end mt-5">
                            <button type="submit" class="btn btn-elite-sky px-5 py-3 fw-black shadow-lg">
                                SIMPAN DATA UMKM <i class="fas fa-check-circle ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    :root {
        --slate-900: #0f172a;
        --slate-800: #1e293b;
        --slate-500: #64748b;
        --slate-400: #94a3b8;
        --slate-300: #cbd5e1;
        --sky: #38bdf8;
    }

    .fw-black { font-weight: 900; }
    .text-sky { color: var(--sky) !important; }
    .bg-slate-900 { background-color: var(--slate-900) !important; }
    .letter-spacing-1 { letter-spacing: 1px; }
    .border-dashed { border: 2px dashed #e2e8f0; }
    .x-small { font-size: 0.65rem; font-weight: 700; text-transform: uppercase; }

    /* FORM STYLING */
    .form-label-elite {
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        color: var(--slate-500);
        margin-bottom: 6px;
        display: block;
    }

    .input-group-elite {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-icon {
        position: absolute;
        left: 15px;
        color: var(--sky);
        z-index: 10;
        font-size: 0.85rem;
    }

    .form-control-elite, .form-select-elite {
        width: 100%;
        padding: 12px 12px 12px 40px;
        border-radius: 12px;
        border: 2px solid #f1f5f9;
        background-color: #f8fafc;
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--slate-800);
        transition: 0.3s;
    }

    .form-control-elite:focus, .form-select-elite:focus {
        outline: none; border-color: var(--sky); background-color: #fff;
        box-shadow: 0 0 0 4px rgba(56, 189, 248, 0.1);
    }

    /* BUTTONS */
    .btn-elite-dark {
        background: var(--slate-900);
        color: #fff; border-radius: 12px; font-weight: 700; border: none; font-size: 0.85rem;
    }
    .btn-elite-dark:hover { background: var(--slate-800); color: var(--sky); }

    .btn-elite-sky {
        background: var(--sky);
        color: var(--slate-900); border-radius: 15px; border: none;
        transition: 0.3s; letter-spacing: 1px;
    }
    .btn-elite-sky:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(56, 189, 248, 0.3); }

    .icon-box-sm {
        width: 35px; height: 35px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
    }
</style>
@endsection
