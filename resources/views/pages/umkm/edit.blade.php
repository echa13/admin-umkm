@extends('layouts.admin.app')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-light rounded p-4">
        <h5 class="mb-3">Edit UMKM</h5>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('umkm.update', $umkm->umkm_id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Usaha</label>
                    <input type="text" name="nama_usaha" class="form-control" value="{{ old('nama_usaha', $umkm->nama_usaha) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Pemilik (Warga)</label>
                    <select name="pemilik_warga_id" class="form-select">
                        @foreach($warga as $w)
                            <option value="{{ $w->warga_id }}" {{ $umkm->pemilik_warga_id == $w->warga_id ? 'selected' : '' }}>
                                {{ $w->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">RT</label>
                    <input type="text" name="rt" class="form-control" value="{{ old('rt', $umkm->rt) }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">RW</label>
                    <input type="text" name="rw" class="form-control" value="{{ old('rw', $umkm->rw) }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Kategori</label>
                    <input type="text" name="kategori" class="form-control" value="{{ old('kategori', $umkm->kategori) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Kontak</label>
                    <input type="text" name="kontak" class="form-control" value="{{ old('kontak', $umkm->kontak) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Alamat</label>
                    <input type="text" name="alamat" class="form-control" value="{{ old('alamat', $umkm->alamat) }}">
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $umkm->deskripsi) }}</textarea>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('umkm.index') }}" class="btn btn-secondary me-2">Kembali</a>
                <button type="submit" class="btn btn-success">Perbarui</button>
            </div>
        </form>
    </div>
</div>
@endsection
