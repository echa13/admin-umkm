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

            {{-- Aksi form menggunakan ID UMKM --}}
            <form action="{{ route('umkm.update', ['umkm' => $umkm->umkm_id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    {{-- Nama Usaha --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Usaha</label>
                        <input type="text" name="nama_usaha" class="form-control"
                            value="{{ old('nama_usaha', $umkm->nama_usaha) }}">
                        @error('nama_usaha')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Pemilik (Warga) --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Pemilik (Warga)</label>
                        <select name="pemilik_warga_id" class="form-select">
                            @foreach ($warga as $w)
                                {{-- Menggunakan warga_id untuk value dan komparasi --}}
                                <option value="{{ $w->warga_id }}"
                                    {{ old('pemilik_warga_id', $umkm->pemilik_warga_id) == $w->warga_id ? 'selected' : '' }}>
                                    {{ $w->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('pemilik_warga_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- RT --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">RT</label>
                        <input type="text" name="rt" class="form-control" value="{{ old('rt', $umkm->rt) }}">
                        @error('rt')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- RW --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">RW</label>
                        <input type="text" name="rw" class="form-control" value="{{ old('rw', $umkm->rw) }}">
                        @error('rw')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- Kategori --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Kategori</label>
                        <input type="text" name="kategori" class="form-control"
                            value="{{ old('kategori', $umkm->kategori) }}">
                        @error('kategori')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Kontak --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kontak</label>
                        <input type="text" name="kontak" class="form-control"
                            value="{{ old('kontak', $umkm->kontak) }}">
                        @error('kontak')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Alamat --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Alamat</label>
                        <input type="text" name="alamat" class="form-control"
                            value="{{ old('alamat', $umkm->alamat) }}">
                        @error('alamat')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div class="col-12 mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $umkm->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Upload Multiple Files --}}
                    <div class="col-12 mb-3">
                        <label class="form-label">Upload Foto/Logo UMKM (Tambahkan foto baru)</label>
                        {{-- Nama input harus 'images[]' --}}
                        <input type="file" name="images[]" class="form-control" multiple>
                        @error('images')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        @error('images.*')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    @foreach ($media as $m)
                        <div class="position-relative border p-1 rounded">
                            <img src="{{ asset('storage/umkm_media/' . $m->file_name) }}" alt="Media UMKM"
                                class="img-fluid rounded" style="width:100px; height:100px; object-fit:cover;">

                            {{-- Form hapus media individual --}}
                            <form action="{{ route('umkm.destroy', $umkm->umkm_id) }}" method="POST"
                                class="position-absolute top-0 end-0">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="media_id[]" value="{{ $m->id }}">
                                <button type="submit" class="btn btn-sm btn-danger p-0 m-0"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus media ini?')"
                                    style="width: 20px; height: 20px; line-height: 1; border-radius: 50%;">
                                    &times;
                                </button>
                            </form>
                        </div>
                    @endforeach



                </div>

                <div class="d-flex justify-content-end mt-3">
                    <a href="{{ route('umkm.index') }}" class="btn btn-secondary me-2">Kembali</a>
                    <button type="submit" class="btn btn-success">Perbarui</button>
                </div>
            </form>


        </div>
    </div>
@endsection
