@extends('layouts.admin.app')

@section('title', 'Edit Data Warga: ' . $data->nama)

@section('content')
<div class="container-fluid py-4 px-4" style="background: #f8fafc; min-height: 100vh;">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-black text-slate-800 m-0 tracking-tight">Modify <span class="text-sky">Resident</span> Data</h2>
            <p class="text-slate-500 small mb-0">Memperbarui informasi kependudukan untuk <strong>{{ $data->nama }}</strong>.</p>
        </div>
        <a href="{{ route('warga.index') }}" class="btn btn-elite-dark px-4 shadow-sm">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-12 col-xl-10">
            <div class="card elite-card border-0 shadow-lg overflow-hidden" style="border-radius: 25px;">
                <div class="card-header bg-slate-900 py-3 px-4 border-0 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="icon-box-sm bg-warning text-dark me-3">
                            <i class="fas fa-user-edit"></i>
                        </div>
                        <h5 class="text-white fw-bold mb-0">Mode Penyuntingan</h5>
                    </div>
                    <span class="badge bg-white bg-opacity-10 text-sky px-3 py-1 rounded-pill small fw-bold">ID: {{ $data->warga_id }}</span>
                </div>

                <div class="card-body p-4 p-md-5 bg-white">
                    <form action="{{ route('warga.update', $data->warga_id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-4 mb-5">
                            <div class="col-12">
                                <h6 class="text-sky fw-black text-uppercase small letter-spacing-1 mb-3">
                                    <i class="fas fa-id-card me-2"></i> 1. Identitas Legal
                                </h6>
                                <div class="separator-slim mb-4"></div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label-elite">Nomor KTP (NIK)</label>
                                <div class="input-group-elite">
                                    <span class="input-icon"><i class="fas fa-fingerprint"></i></span>
                                    <input type="text" name="no_ktp" value="{{ old('no_ktp', $data->no_ktp) }}"
                                           class="form-control-elite @error('no_ktp') is-invalid-elite @enderror"
                                           placeholder="16 Digit NIK">
                                </div>
                                @error('no_ktp') <div class="error-msg">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label-elite">Nama Lengkap</label>
                                <div class="input-group-elite">
                                    <span class="input-icon"><i class="fas fa-user-tag"></i></span>
                                    <input type="text" name="nama" value="{{ old('nama', $data->nama) }}"
                                           class="form-control-elite @error('nama') is-invalid-elite @enderror">
                                </div>
                                @error('nama') <div class="error-msg">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row g-4 mb-5">
                            <div class="col-12">
                                <h6 class="text-sky fw-black text-uppercase small letter-spacing-1 mb-3">
                                    <i class="fas fa-info-circle me-2"></i> 2. Detail Biografis
                                </h6>
                                <div class="separator-slim mb-4"></div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label-elite">Jenis Kelamin</label>
                                <div class="input-group-elite">
                                    <span class="input-icon"><i class="fas fa-venus-mars"></i></span>
                                    <select name="jenis_kelamin" class="form-select-elite @error('jenis_kelamin') is-invalid-elite @enderror">
                                        <option value="Laki-laki" {{ old('jenis_kelamin', $data->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ old('jenis_kelamin', $data->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label-elite">Agama</label>
                                <div class="input-group-elite">
                                    <span class="input-icon"><i class="fas fa-kaaba"></i></span>
                                    <input type="text" name="agama" value="{{ old('agama', $data->agama) }}"
                                           class="form-control-elite @error('agama') is-invalid-elite @enderror">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label-elite">Pekerjaan</label>
                                <div class="input-group-elite">
                                    <span class="input-icon"><i class="fas fa-briefcase"></i></span>
                                    <input type="text" name="pekerjaan" value="{{ old('pekerjaan', $data->pekerjaan) }}"
                                           class="form-control-elite">
                                </div>
                            </div>
                        </div>

                        <div class="row g-4 mb-4">
                            <div class="col-12">
                                <h6 class="text-sky fw-black text-uppercase small letter-spacing-1 mb-3">
                                    <i class="fas fa-phone-alt me-2"></i> 3. Kontak Person
                                </h6>
                                <div class="separator-slim mb-4"></div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label-elite">Nomor Telepon/WA</label>
                                <div class="input-group-elite">
                                    <span class="input-icon"><i class="fab fa-whatsapp"></i></span>
                                    <input type="text" name="telp" value="{{ old('telp', $data->telp) }}"
                                           class="form-control-elite">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label-elite">Alamat Email</label>
                                <div class="input-group-elite">
                                    <span class="input-icon"><i class="fas fa-envelope"></i></span>
                                    <input type="email" name="email" value="{{ old('email', $data->email) }}"
                                           class="form-control-elite">
                                </div>
                            </div>
                        </div>

                        <div class="text-end mt-5 border-top pt-4">
                            <button type="submit" class="btn btn-elite-warning px-5 py-3 fw-black shadow-lg">
                                PERBARUI DATA <i class="fas fa-sync-alt ms-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --slate-900: #0f172a;
        --slate-500: #64748b;
        --slate-100: #f1f5f9;
        --sky: #38bdf8;
        --amber: #f59e0b;
    }

    .fw-black { font-weight: 900; }
    .text-sky { color: var(--sky) !important; }
    .letter-spacing-1 { letter-spacing: 1px; }

    /* FORM STYLING */
    .form-label-elite { font-size: 0.7rem; font-weight: 800; text-transform: uppercase; color: var(--slate-500); margin-bottom: 6px; display: block; }
    .input-group-elite { position: relative; display: flex; align-items: center; }
    .input-icon { position: absolute; left: 15px; color: var(--sky); z-index: 10; font-size: 0.85rem; }

    .form-control-elite, .form-select-elite {
        width: 100%; padding: 12px 12px 12px 40px; border-radius: 12px; border: 2px solid var(--slate-100);
        background-color: #f8fafc; font-weight: 600; font-size: 0.9rem; transition: 0.3s;
    }
    .form-control-elite:focus { outline: none; border-color: var(--amber); background-color: #fff; box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.1); }

    .separator-slim { height: 2px; background: linear-gradient(to right, var(--amber), transparent); width: 100px; border-radius: 2px; }
    .icon-box-sm { width: 35px; height: 35px; border-radius: 10px; display: flex; align-items: center; justify-content: center; }
    .error-msg { color: #ef4444; font-size: 0.7rem; font-weight: 700; margin-top: 5px; }

    /* BUTTONS */
    .btn-elite-dark { background: var(--slate-900); color: #fff; border-radius: 12px; font-weight: 700; border: none; font-size: 0.85rem; }
    .btn-elite-warning { background: var(--amber); color: #fff; border-radius: 15px; border: none; transition: 0.3s; letter-spacing: 1px; }
    .btn-elite-warning:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(245, 158, 11, 0.3); background: #d97706; }
</style>
@endsection
