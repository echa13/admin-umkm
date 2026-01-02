@extends('layouts.admin.app')

@section('title', 'Edit User: ' . $user->name)

@section('content')
<div class="container-fluid py-4 px-4" style="background: #f8fafc; min-height: 100vh;">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-black text-slate-800 m-0 tracking-tight">Update <span class="text-sky">User</span> Account</h2>
            <p class="text-slate-500 small mb-0">Modifikasi hak akses dan informasi profil pengguna.</p>
        </div>
        <a href="{{ route('users.index') }}" class="btn btn-elite-dark px-4 shadow-sm">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-12 col-xl-9">

            @if ($errors->any())
                <div class="alert alert-danger border-0 shadow-sm mb-4 rounded-4">
                    <div class="d-flex align-items-center text-danger small fw-bold">
                        <i class="fas fa-exclamation-triangle me-3 fa-lg"></i>
                        <div>Mohon perbaiki kesalahan input pada formulir di bawah.</div>
                    </div>
                </div>
            @endif

            <div class="card elite-card border-0 shadow-lg overflow-hidden" style="border-radius: 25px;">
                <div class="card-header bg-slate-900 py-3 px-4 border-0 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="icon-box-sm bg-sky text-dark me-3">
                            <i class="fas fa-user-cog"></i>
                        </div>
                        <h5 class="text-white fw-bold mb-0">Pengaturan Akun</h5>
                    </div>
                    <span class="badge bg-white bg-opacity-10 text-sky px-3 py-1 rounded-pill small">UID #{{ $user->id }}</span>
                </div>

                <div class="card-body p-4 p-md-5 bg-white">
                    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            <div class="col-md-8">
                                <h6 class="text-sky fw-black text-uppercase small letter-spacing-1 mb-4">
                                    <i class="fas fa-id-card me-2"></i> 1. Informasi Dasar
                                </h6>

                                <div class="mb-4">
                                    <label class="form-label-elite">Nama Lengkap</label>
                                    <div class="input-group-elite">
                                        <span class="input-icon"><i class="fas fa-user"></i></span>
                                        <input type="text" name="name" class="form-control-elite @error('name') is-invalid-elite @enderror"
                                               value="{{ old('name', $user->name) }}" placeholder="Contoh: Ahmad Subardjo">
                                    </div>
                                    @error('name') <div class="error-msg">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label-elite">Alamat Email</label>
                                    <div class="input-group-elite">
                                        <span class="input-icon"><i class="fas fa-envelope"></i></span>
                                        <input type="email" name="email" class="form-control-elite @error('email') is-invalid-elite @enderror"
                                               value="{{ old('email', $user->email) }}" placeholder="email@domain.com">
                                    </div>
                                    @error('email') <div class="error-msg">{{ $message }}</div> @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label-elite">Role / Hak Akses</label>
                                        <div class="input-group-elite">
                                            <span class="input-icon"><i class="fas fa-shield-alt"></i></span>
                                            <select name="role" class="form-select-elite @error('role') is-invalid-elite @enderror">
                                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrator</option>
                                                <option value="pemilik" {{ old('role', $user->role) == 'pemilik' ? 'selected' : '' }}>Pemilik UMKM</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label-elite">Password Baru <span class="text-slate-400 fw-normal">(Opsional)</span></label>
                                        <div class="input-group-elite">
                                            <span class="input-icon"><i class="fas fa-key"></i></span>
                                            <input type="password" name="password" class="form-control-elite" placeholder="••••••••">
                                        </div>
                                        <div class="x-small text-slate-400 mt-1">Kosongkan jika tidak ingin diubah.</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <h6 class="text-sky fw-black text-uppercase small letter-spacing-1 mb-4">
                                    <i class="fas fa-camera me-2"></i> 2. Foto Profil
                                </h6>

                                <div class="text-center p-4 rounded-4 border-dashed mb-3">
                                    <div class="avatar-preview-wrapper mb-3">
                                        @if($user->media && $user->media->count() > 0)
                                            <img src="{{ asset('storage/user_media/' . $user->media->first()->file_name) }}" class="avatar-img" id="img-preview">
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0f172a&color=38bdf8&bold=true" class="avatar-img" id="img-preview">
                                        @endif
                                    </div>
                                    <label class="btn btn-sm btn-outline-slate fw-bold w-100" for="upload-photo">
                                        <i class="fas fa-upload me-2"></i> Pilih Foto Baru
                                    </label>
                                    <input type="file" name="images[]" id="upload-photo" class="d-none" multiple onchange="previewImage(event)">
                                </div>
                                @error('images') <div class="error-msg text-center">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="text-end mt-5 border-top pt-4">
                            <button type="submit" class="btn btn-elite-sky px-5 py-3 fw-black shadow-lg">
                                PERBARUI AKUN <i class="fas fa-check-circle ms-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('img-preview');
            output.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

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

    .border-dashed { border: 2px dashed var(--slate-300); background: #fdfdfd; }

    /* AVATAR PREVIEW */
    .avatar-preview-wrapper {
        width: 120px; height: 120px; margin: 0 auto; border-radius: 50%; border: 4px solid #fff;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1); overflow: hidden; background: #eee;
    }
    .avatar-img { width: 100%; height: 100%; object-fit: cover; }

    /* BUTTONS */
    .btn-elite-dark { background: var(--slate-900); color: #fff; border-radius: 12px; font-weight: 700; border: none; font-size: 0.85rem; }
    .btn-outline-slate { border: 2px solid var(--slate-100); color: var(--slate-600); border-radius: 10px; transition: 0.2s; }
    .btn-outline-slate:hover { background: var(--slate-100); }
    .btn-elite-sky { background: var(--sky); color: var(--slate-900); border-radius: 15px; border: none; transition: 0.3s; letter-spacing: 1px; }
    .btn-elite-sky:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(56, 189, 248, 0.3); }

    .icon-box-sm { width: 35px; height: 35px; border-radius: 10px; display: flex; align-items: center; justify-content: center; }
    .error-msg { color: #ef4444; font-size: 0.7rem; font-weight: 700; margin-top: 5px; }
</style>
@endsection
