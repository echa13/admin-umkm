@extends('layouts.admin.app')

@section('title', 'Edit Produk: ' . $produk->nama_produk)

@section('content')
<div class="container-fluid py-4 px-4" style="background: #f8fafc; min-height: 100vh;">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-black text-slate-800 m-0 tracking-tight">Modify <span class="text-sky">Product</span></h2>
            <p class="text-slate-500 small mb-0">Perbarui informasi katalog, harga, dan ketersediaan stok produk.</p>
        </div>
        <a href="{{ route('produk.index') }}" class="btn btn-elite-dark px-4 shadow-sm">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-12 col-xl-11">
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

            <form action="{{ route('produk.update', $produk->produk_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    <div class="col-lg-7">
                        <div class="card elite-card border-0 shadow-lg h-100" style="border-radius: 25px;">
                            <div class="card-header bg-slate-900 py-3 px-4 border-0">
                                <div class="d-flex align-items-center">
                                    <div class="icon-box-sm bg-sky text-dark me-3">
                                        <i class="fas fa-edit"></i>
                                    </div>
                                    <h5 class="text-white fw-bold mb-0">Data Produk</h5>
                                </div>
                            </div>
                            <div class="card-body p-4 bg-white">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label-elite">UMKM Pengelola</label>
                                        <div class="input-group-elite">
                                            <span class="input-icon"><i class="fas fa-store"></i></span>
                                            <select name="umkm_id" class="form-select-elite" required>
                                                @foreach($umkms as $u)
                                                    <option value="{{ $u->umkm_id }}" {{ $u->umkm_id == $produk->umkm_id ? 'selected' : '' }}>
                                                        {{ $u->nama_usaha }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label-elite">Nama Produk</label>
                                        <div class="input-group-elite">
                                            <span class="input-icon"><i class="fas fa-tag"></i></span>
                                            <input type="text" name="nama_produk" class="form-control-elite" value="{{ $produk->nama_produk }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label-elite">Harga (Rp)</label>
                                        <div class="input-group-elite">
                                            <span class="input-icon fw-bold text-sky">Rp</span>
                                            <input type="number" name="harga" class="form-control-elite" value="{{ $produk->harga }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label-elite">Stok</label>
                                        <div class="input-group-elite">
                                            <span class="input-icon"><i class="fas fa-cubes"></i></span>
                                            <input type="number" name="stok" class="form-control-elite" value="{{ $produk->stok }}" required>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label-elite">Status Produk</label>
                                        <div class="input-group-elite">
                                            <span class="input-icon"><i class="fas fa-check-circle"></i></span>
                                            <select name="status" class="form-select-elite" required>
                                                <option value="tersedia" {{ $produk->status == 'tersedia' ? 'selected' : '' }}>Tersedia (Tampilkan)</option>
                                                <option value="kosong" {{ $produk->status == 'kosong' ? 'selected' : '' }}>Kosong (Sembunyikan)</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label-elite">Deskripsi Produk</label>
                                        <textarea name="deskripsi" class="form-control-elite px-3" rows="4">{{ $produk->deskripsi }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="card elite-card border-0 shadow-lg mb-4" style="border-radius: 25px;">
                            <div class="card-header bg-slate-800 py-3 px-4 border-0">
                                <h5 class="text-white fw-bold mb-0 small uppercase letter-spacing-1">Foto Produk</h5>
                            </div>
                            <div class="card-body p-4 bg-white text-center">
                                <label class="form-label-elite text-start w-100">Pratinjau Saat Ini</label>
                                <div class="img-preview-box mb-3 shadow-sm">
                                    @if($produk->media->first())
                                        <img src="{{ asset('storage/produk/'.$produk->media->first()->file_name) }}"
                                             class="img-fluid rounded-4" style="max-height: 250px; object-fit: cover;" alt="Foto Produk">
                                    @else
                                        <div class="py-5 bg-light rounded-4">
                                            <i class="fas fa-image fa-3x text-slate-300"></i>
                                            <p class="text-slate-500 small mt-2">Belum ada foto</p>
                                        </div>
                                    @endif
                                </div>

                                <hr class="my-4 opacity-5">

                                <label class="form-label-elite text-start w-100">Ganti Foto Baru</label>
                                <input type="file" name="foto" id="foto" class="form-control form-control-sm border-0 bg-light rounded-pill px-3" accept="image/*">
                                <p class="x-small text-slate-400 mt-2 fw-bold italic">*Kosongkan jika tidak ingin mengubah foto</p>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-elite-sky w-100 py-3 fw-black shadow-lg">
                            UPDATE PRODUK <i class="fas fa-save ms-2"></i>
                        </button>
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
        --sky: #38bdf8;
    }

    .fw-black { font-weight: 900; }
    .text-sky { color: var(--sky) !important; }
    .bg-slate-900 { background-color: var(--slate-900) !important; }
    .bg-slate-800 { background-color: var(--slate-800) !important; }
    .letter-spacing-1 { letter-spacing: 1px; }
    .x-small { font-size: 0.65rem; }

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
        padding: 10px 12px 10px 40px;
        border-radius: 12px;
        border: 2px solid #f1f5f9;
        background-color: #f8fafc;
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--slate-800);
        transition: 0.3s;
    }

    .form-control-elite:focus {
        outline: none; border-color: var(--sky); background-color: #fff;
        box-shadow: 0 0 0 4px rgba(56, 189, 248, 0.1);
    }

    /* IMAGE PREVIEW */
    .img-preview-box {
        background: #f1f5f9;
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* BUTTONS */
    .btn-elite-dark {
        background: var(--slate-900);
        color: #fff; border-radius: 12px; font-weight: 700; border: none; font-size: 0.85rem;
    }
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
