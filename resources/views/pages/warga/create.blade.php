@extends('layouts.admin.app')
@section('content')

<div class="container-fluid pt-4 px-4">
    <div class="bg-light rounded p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h6 class="mb-0">Tambah Data Warga</h6>
            <a href="{{ route('warga.index') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left me-2"></i>Kembali
            </a>
        </div>

        <form action="{{ route('warga.store') }}" method="POST">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">No KTP</label>
                    <input type="text" name="no_ktp" value="{{ old('no_ktp') }}" class="form-control @error('no_ktp') is-invalid @enderror">
                    @error('no_ktp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ old('nama') }}" class="form-control @error('nama') is-invalid @enderror">
                    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror">
                        <option value="">-- Pilih --</option>
                        <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Agama</label>
                    <input type="text" name="agama" value="{{ old('agama') }}" class="form-control @error('agama') is-invalid @enderror">
                    @error('agama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Pekerjaan</label>
                    <input type="text" name="pekerjaan" value="{{ old('pekerjaan') }}" class="form-control">
                </div>

                <div class="col-md-3">
                    <label class="form-label">No Telp</label>
                    <input type="text" name="telp" value="{{ old('telp') }}" class="form-control">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control">
                </div>

                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-save me-2"></i>Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
