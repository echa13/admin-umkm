@extends('layouts.admin.app')

@section('title', 'Edit UMKM: ' . $umkm->nama_usaha)

@section('content')
<div class="container-fluid py-4 px-4" style="background: #f8fafc; min-height: 100vh;">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-black text-slate-800 m-0 tracking-tight">Update <span class="text-sky">Business</span></h2>
            <p class="text-slate-500 small mb-0">Mengubah data unit usaha: <strong class="text-slate-700">{{ $umkm->nama_usaha }}</strong></p>
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
                        <i class="fas fa-exclamation-circle me-3 fa-lg"></i>
                        <div class="small fw-bold">Terjadi kesalahan pada input. Silakan periksa kembali formulir di bawah.</div>
                    </div>
                </div>
            @endif

            <div class="card elite-card border-0 shadow-lg overflow-hidden" style="border-radius: 25px;">
                <div class="card-header bg-slate-900 py-3 px-4 border-0 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="icon-box-sm bg-sky text-dark me-3">
                            <i class="fas fa-edit"></i>
                        </div>
                        <h5 class="text-white fw-bold mb-0">Modifikasi Data UMKM</h5>
                    </div>
                    <span class="badge bg-white bg-opacity-10 text-sky px-3 py-1 rounded-pill small">ID #{{ $umkm->umkm_id }}</span>
                </div>

                <div class="card-body p-4 p-md-5 bg-white">
                    <form action="{{ route('umkm.update', ['umkm' => $umkm->umkm_id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-5">
                            <h6 class="text-sky fw-black text-uppercase small letter-spacing-1 mb-4">
                                <i class="fas fa-info-circle me-2"></i> 1. Profil Bisnis Utama
                            </h6>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label-elite">Nama Unit Usaha</label>
                                    <div class="input-group-elite">
                                        <span class="input-icon"><i class="fas fa-briefcase"></i></span>
                                        <input type="text" name="nama_usaha" class="form-control-elite @error('nama_usaha') is-invalid-elite @enderror"
                                               value="{{ old('nama_usaha', $umkm->nama_usaha) }}">
                                    </div>
                                    @error('nama_usaha') <div class="error-msg">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-elite">Pemilik (Warga)</label>
                                    <div class="input-group-elite">
                                        <span class="input-icon"><i class="fas fa-user-tie"></i></span>
                                        <select name="pemilik_warga_id" class="form-select-elite @error('pemilik_warga_id') is-invalid-elite @enderror">
                                            @foreach ($warga as $w)
                                                <option value="{{ $w->warga_id }}" {{ old('pemilik_warga_id', $umkm->pemilik_warga_id) == $w->warga_id ? 'selected' : '' }}>
                                                    {{ $w->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('pemilik_warga_id') <div class="error-msg">{{ $message }}</div> @enderror
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
                                    <input type="text" name="rt" class="form-control-elite px-3 @error('rt') is-invalid-elite @enderror" value="{{ old('rt', $umkm->rt) }}">
                                    @error('rt') <div class="error-msg">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-3 col-6">
                                    <label class="form-label-elite">RW</label>
                                    <input type="text" name="rw" class="form-control-elite px-3 @error('rw') is-invalid-elite @enderror" value="{{ old('rw', $umkm->rw) }}">
                                    @error('rw') <div class="error-msg">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-elite">Kategori</label>
                                    <div class="input-group-elite">
                                        <span class="input-icon"><i class="fas fa-tags"></i></span>
                                        <input type="text" name="kategori" class="form-control-elite @error('kategori') is-invalid-elite @enderror" value="{{ old('kategori', $umkm->kategori) }}">
                                    </div>
                                    @error('kategori') <div class="error-msg">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-elite">Nomor Kontak / WA</label>
                                    <div class="input-group-elite">
                                        <span class="input-icon"><i class="fab fa-whatsapp"></i></span>
                                        <input type="text" name="kontak" class="form-control-elite @error('kontak') is-invalid-elite @enderror" value="{{ old('kontak', $umkm->kontak) }}">
                                    </div>
                                    @error('kontak') <div class="error-msg">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-elite">Alamat Lokasi</label>
                                    <div class="input-group-elite">
                                        <span class="input-icon"><i class="fas fa-map-marker-alt"></i></span>
                                        <input type="text" name="alamat" class="form-control-elite @error('alamat') is-invalid-elite @enderror" value="{{ old('alamat', $umkm->alamat) }}">
                                    </div>
                                    @error('alamat') <div class="error-msg">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h6 class="text-sky fw-black text-uppercase small letter-spacing-1 mb-4">
                                <i class="fas fa-photo-video me-2"></i> 3. Narasi & Media Visual
                            </h6>
                            <div class="row g-4">
                                <div class="col-12">
                                    <label class="form-label-elite">Deskripsi Usaha</label>
                                    <textarea name="deskripsi" class="form-control-elite px-3 @error('deskripsi') is-invalid-elite @enderror" rows="4">{{ old('deskripsi', $umkm->deskripsi) }}</textarea>
                                    @error('deskripsi') <div class="error-msg">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 mt-4">
                                    <label class="form-label-elite mb-3">Manajemen Foto (Klik 'X' untuk hapus)</label>
                                    <div class="d-flex flex-wrap gap-3 mb-4">
                                        @foreach ($media as $m)
                                            <div class="media-preview-card">
                                                <img src="{{ asset('storage/umkm_media/' . $m->file_name) }}" alt="Media UMKM">
                                                <button type="button" class="btn-delete-media"
                                                        onclick="if(confirm('Hapus foto ini?')) document.getElementById('delete-media-{{ $m->id }}').submit();">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        @endforeach

                                        <label class="upload-btn-placeholder" for="images-input">
                                            <i class="fas fa-plus-circle fa-2x mb-2 text-slate-300"></i>
                                            <span class="x-small text-slate-400">Tambah Foto</span>
                                            <input type="file" name="images[]" id="images-input" class="d-none" multiple>
                                        </label>
                                    </div>
                                    @error('images') <div class="error-msg">{{ $message }}</div> @enderror
                                    @error('images.*') <div class="error-msg">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="text-end mt-5 border-top pt-4">
                            <button type="submit" class="btn btn-elite-sky px-5 py-3 fw-black shadow-lg">
                                SIMPAN PERUBAHAN <i class="fas fa-save ms-2"></i>
                            </button>
                        </div>
                    </form>

                    @foreach ($media as $m)
                        <form id="delete-media-{{ $m->id }}" action="{{ route('umkm.destroy_media', $m->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --slate-900: #0f172a;
        --slate-800: #1e293b;
        --slate-500: #64748b;
        --slate-400: #94a3b8;
        --slate-100: #f1f5f9;
        --sky: #38bdf8;
    }

    .fw-black { font-weight: 900; }
    .text-sky { color: var(--sky) !important; }
    .bg-slate-900 { background-color: var(--slate-900) !important; }
    .letter-spacing-1 { letter-spacing: 1px; }
    .x-small { font-size: 0.65rem; font-weight: 700; text-transform: uppercase; }

    /* FORM STYLING */
    .form-label-elite { font-size: 0.7rem; font-weight: 800; text-transform: uppercase; color: var(--slate-500); margin-bottom: 6px; display: block; }
    .input-group-elite { position: relative; display: flex; align-items: center; }
    .input-icon { position: absolute; left: 15px; color: var(--sky); z-index: 10; font-size: 0.85rem; }

    .form-control-elite, .form-select-elite {
        width: 100%; padding: 12px 12px 12px 40px; border-radius: 12px; border: 2px solid var(--slate-100);
        background-color: #f8fafc; font-weight: 600; font-size: 0.9rem; transition: 0.3s;
    }
    .form-control-elite:focus, .form-select-elite:focus { outline: none; border-color: var(--sky); background-color: #fff; box-shadow: 0 0 0 4px rgba(56, 189, 248, 0.1); }

    .is-invalid-elite { border-color: #ef4444 !important; }
    .error-msg { color: #ef4444; font-size: 0.75rem; font-weight: 700; margin-top: 5px; margin-left: 5px; }

    /* MEDIA GALLERY */
    .media-preview-card {
        position: relative; width: 120px; height: 120px; border-radius: 15px; overflow: hidden; border: 3px solid var(--slate-100);
    }
    .media-preview-card img { width: 100%; height: 100%; object-fit: cover; }
    .btn-delete-media {
        position: absolute; top: 5px; right: 5px; width: 24px; height: 24px; border-radius: 50%;
        background: #ef4444; color: white; border: none; font-size: 10px; display: flex; align-items: center; justify-content: center;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2); transition: 0.2s;
    }
    .btn-delete-media:hover { transform: scale(1.1); background: #dc2626; }

    .upload-btn-placeholder {
        width: 120px; height: 120px; border-radius: 15px; border: 2px dashed var(--slate-400);
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        cursor: pointer; background: #fff; transition: 0.3s;
    }
    .upload-btn-placeholder:hover { border-color: var(--sky); background: var(--slate-100); }

    /* BUTTONS */
    .btn-elite-dark { background: var(--slate-900); color: #fff; border-radius: 12px; font-weight: 700; border: none; }
    .btn-elite-sky { background: var(--sky); color: var(--slate-900); border-radius: 15px; border: none; transition: 0.3s; letter-spacing: 1px; }
    .btn-elite-sky:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(56, 189, 248, 0.3); }

    .icon-box-sm { width: 35px; height: 35px; border-radius: 10px; display: flex; align-items: center; justify-content: center; }
</style>
@endsection
