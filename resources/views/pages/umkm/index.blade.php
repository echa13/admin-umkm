@extends('layouts.admin.app')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-light rounded p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Daftar UMKM</h5>
            <a href="{{ route('umkm.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Tambah UMKM
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-primary text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama Usaha</th>
                        <th>Pemilik</th>
                        <th>Kategori</th>
                        <th>Kontak</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($umkms as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $item->nama_usaha }}</td>
                            <td>{{ $item->pemilik?->nama ?? '-' }}</td>
                            <td>{{ $item->kategori }}</td>
                            <td>{{ $item->kontak }}</td>
                            <td>RT {{ $item->rt }}/RW {{ $item->rw }} - {{ $item->alamat }}</td>
                            <td class="text-center">
                                <a href="{{ route('umkm.edit', $item->umkm_id) }}" class="btn btn-sm btn-warning me-2">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <form action="{{ route('umkm.destroy', $item->umkm_id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus UMKM ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada data UMKM.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
