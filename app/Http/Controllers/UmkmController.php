<?php
namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Umkm;
use App\Models\Warga; // Import model Media
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// Import Storage facade

// Import Str untuk generate nama file

class UmkmController extends Controller
{
    /**
     * Tampilkan semua data UMKM
     */
    public function index(Request $request)
    {
        $umkm = Umkm::with('pemilik')
            ->when($request->search, function ($q) use ($request) {
                $q->where('nama_usaha', 'like', '%' . $request->search . '%')
                    ->orWhereHas('pemilik', function ($w) use ($request) {
                        $w->where('nama', 'like', '%' . $request->search . '%');
                    });
            })
            ->when($request->kategori, function ($q) use ($request) {
                $q->where('kategori', $request->kategori);
            })
            ->orderBy('nama_usaha', 'asc')
            ->paginate(10);

        // Untuk filter list kategori unik
        $kategoriList = Umkm::select('kategori')->distinct()->get();

        return view('pages.umkm.index', compact('umkm', 'kategoriList'));
    }

    /**
     * Tampilkan form tambah data UMKM
     */
    public function create()
    {
        $warga = Warga::orderBy('nama')->get();

        return view('pages.umkm.create', compact('warga'));
    }

    /**
     * Simpan data UMKM baru ke database (termasuk upload multiple file)
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_usaha'       => 'required|string|max:150',
            'pemilik_warga_id' => 'required|exists:warga,warga_id',
            'foto'             => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Simpan UMKM
        $umkm = Umkm::create([
            'nama_usaha'       => $request->nama_usaha,
            'pemilik_warga_id' => $request->pemilik_warga_id,
            'rt'               => $request->rt,
            'rw'               => $request->rw,
            'kategori'         => $request->kategori,
            'kontak'           => $request->kontak,
            'alamat'           => $request->alamat,
            'deskripsi'        => $request->deskripsi,
        ]);

        // Upload foto (JALUR BENAR)
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');

            // 🔥 SIMPAN KE storage/app/public/produk
            $path = $file->store('umkm_media', 'public');

            Media::create([
                'ref_table'  => 'umkm',
                'ref_id'     => $umkm->umkm_id,
                'file_name'  => basename($path),
                'mime_type'  => $file->getClientMimeType(),
                'sort_order' => 1,
            ]);

        }

        return redirect()->route('umkm.index')
            ->with('success', 'UMKM berhasil ditambahkan');
    }

    /**
     * Tampilkan detail data UMKM berdasarkan ID
     */
    public function show($id)
    {
        $umkm = Umkm::findOrFail($id);

        $media = Media::where('ref_table', 'umkm')
            ->where('ref_id', $umkm->umkm_id)
            ->first();

        return view('pages.umkm.show', compact('umkm', 'media'));

    }

    /**
     * Tampilkan form edit data UMKM
     */
    public function edit($id)
    {
        $umkm  = Umkm::findOrFail($id);
        $warga = Warga::orderBy('nama')->get();
        $media = $umkm->media()->orderBy('sort_order')->get(); // pakai relasi
        return view('pages.umkm.edit', compact('umkm', 'warga', 'media'));
    }

    /**
     * Update data UMKM (termasuk upload multiple file baru)
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_usaha'       => 'required|string|max:150',
            'pemilik_warga_id' => 'required|exists:warga,warga_id',
            'alamat'           => 'required|string|max:255',
            'rt'               => 'nullable|string|max:5',
            'rw'               => 'nullable|string|max:5',
            'kategori'         => 'required|string|max:100',
            'kontak'           => 'nullable|string|max:20',
            'deskripsi'        => 'nullable|string',
            'images.*'         => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $umkm = Umkm::findOrFail($id);

        // Update data UMKM
        $umkm->update([
            'nama_usaha'       => $request->nama_usaha,
            'pemilik_warga_id' => $request->pemilik_warga_id,
            'alamat'           => $request->alamat,
            'rt'               => $request->rt,
            'rw'               => $request->rw,
            'kategori'         => $request->kategori,
            'kontak'           => $request->kontak,
            'deskripsi'        => $request->deskripsi,
        ]);

        // Upload foto baru (MULTIPLE)
        if ($request->hasFile('images')) {
            $lastOrder = $umkm->media()->max('sort_order') ?? 0;

            foreach ($request->file('images') as $file) {
                $path = $file->store('umkm_media', 'public');

                $umkm->media()->create([
                    'ref_table'  => 'umkm',
                    'file_name'  => basename($path),
                    'mime_type'  => $file->getClientMimeType(),
                    'sort_order' => ++$lastOrder,
                ]);

            }
        }

        return redirect()->route('umkm.index')
            ->with('success', 'UMKM berhasil diperbarui');
    }

    public function destroy(Request $request, $id)
    {
        $umkm = Umkm::findOrFail($id);

        if ($request->has('media_id')) {
            // Hapus media tertentu
            $mediaRecords = Media::where('ref_table', 'umkm')
                ->where('ref_id', $umkm->id)
                ->whereIn('id', $request->media_id)
                ->get();

            foreach ($mediaRecords as $media) {
                if (Storage::disk('public')->exists('umkm_media/' . $media->file_name)) {
                    Storage::disk('public')->delete('umkm_media/' . $media->file_name);
                }
                $media->delete();
            }

            return back()->with('success', 'Media berhasil dihapus!');
        } else {
            // Hapus seluruh UMKM beserta semua media
            $mediaRecords = Media::where('ref_table', 'umkm')
                ->where('ref_id', $umkm->id)
                ->get();

            foreach ($mediaRecords as $media) {
                if (Storage::disk('public')->exists('umkm_media/' . $media->file_name)) {
                    Storage::disk('public')->delete('umkm_media/' . $media->file_name);
                }
                $media->delete();
            }

            $umkm->delete();

            return redirect()->route('umkm.index')->with('success', 'Data UMKM dan media terkait berhasil dihapus!');
        }

    }

    public function destroyMedia(Media $media)
    {
        // keamanan: pastikan ini media UMKM
        if ($media->ref_table !== 'umkm') {
            abort(403);
        }

        // hapus file
        if (Storage::disk('public')->exists('produk/' . $media->file_name)) {
            Storage::disk('public')->delete('produk/' . $media->file_name);
        }

        // hapus DB
        $media->delete();

        return back()->with('success', 'Foto berhasil dihapus');
    }

}
