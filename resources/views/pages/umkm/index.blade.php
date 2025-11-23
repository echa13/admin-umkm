@extends('layouts.admin.app')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-light rounded p-4 shadow-sm">
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
            <h5 class="mb-0 text-primary fw-bold">
                <i class="fa fa-store me-2"></i>Daftar UMKM
            </h5>
            <a href="{{ route('umkm.create') }}" class="btn btn-primary mb-2">
                <i class="fa fa-plus me-1"></i> Tambah UMKM
            </a>
        </div>

        {{-- Alert --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Filter Form --}}
        <form action="{{ route('umkm.index') }}" method="GET" class="mb-3 d-flex flex-wrap gap-2 align-items-center">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari nama usaha atau pemilik..." class="form-control" style="width: 260px;">
            <select name="kategori" class="form-select" style="width: 200px;">
                <option value="">-- Semua Kategori --</option>
                @foreach ($kategoriList as $row)
                    <option value="{{ $row->kategori }}"
                        {{ request('kategori') == $row->kategori ? 'selected' : '' }}>
                        {{ $row->kategori }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>

        {{-- Table --}}
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-primary text-center">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Nama Usaha</th>
                        <th>Pemilik</th>
                        <th>Kategori</th>
                        <th>Kontak</th>
                        <th>Alamat</th>
                        <th style="width: 120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($umkms as $index => $item)
                        <tr>
                            <td class="text-center">{{ $umkms->firstItem() + $index }}</td>
                            <td>{{ $item->nama_usaha }}</td>
                            <td>{{ $item->pemilik?->nama ?? '-' }}</td>
                            <td>{{ $item->kategori }}</td>
                            <td>{{ $item->kontak }}</td>
                            <td>RT {{ $item->rt }}/RW {{ $item->rw }} - {{ $item->alamat }}</td>
                            <td class="text-center">
                                <a href="{{ route('umkm.edit', $item->umkm_id) }}" class="btn btn-sm btn-warning me-1">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <form action="{{ route('umkm.destroy', $item->umkm_id) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Yakin ingin menghapus UMKM ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-3">Belum ada data UMKM.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="mt-2 d-flex justify-content-center">
                {{ $umkms->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

{{-- Optional: CSS tambahan --}}
<style>
    table.table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .btn-warning.btn-sm, .btn-danger.btn-sm {
        padding: 4px 10px;
        border-radius: 6px;
        transition: transform 0.2s;
    }

    .btn-warning.btn-sm:hover, .btn-danger.btn-sm:hover {
        transform: scale(1.05);
    }

    .pagination .page-link {
        padding: 0.25rem 0.5rem;
        font-size: 0.85rem;
    }

    .pagination .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
</style>
@endsection
