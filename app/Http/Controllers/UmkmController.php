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
            'nama_usaha'       => 'required',
            'pemilik_warga_id' => 'required',
            'foto'             => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

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

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');

            $path = $file->store('umkm_media', 'public');

            Media::create([
                'ref_table' => 'umkm',
                'ref_id'    => $umkm->umkm_id,
                'file_name' => $file->getClientOriginalName(), // ✅ WAJIB
                'file_path' => $path,                          // kalau ada kolom ini
            ]);
        }

        return redirect()->route('umkm.index')->with('success', 'UMKM berhasil ditambahkan');
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
        $validatedData = $request->validate([
            'nama_usaha'       => 'required|string|max:150',
            'pemilik_warga_id' => 'required|integer|exists:warga,warga_id',
            'alamat'           => 'required|string|max:255',
            'rt'               => 'nullable|string|max:5',
            'rw'               => 'nullable|string|max:5',
            'kategori'         => 'required|string|max:100',
            'kontak'           => 'nullable|string|max:20',
            'deskripsi'        => 'nullable|string',
            'images'           => 'nullable',
            'images.*'         => 'file|mimes:png,jpg,gif,svg,webp|max:2048',
        ]);

        $umkm = Umkm::findOrFail($id);

// Update data UMKM
        $umkm->update($validatedData);

// Upload multiple file baru jika ada
        if ($request->hasFile('images')) {
            $sortOrder = 1; // default start dari 1

            foreach ($request->file('images') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalExtension();
                $file->storeAs('umkm_media', $fileName, 'public');

                // Pakai relasi media() supaya ref_id otomatis
                $umkm->media()->create([
                    'ref_table'  => 'umkm',
                    'file_name'  => $fileName,
                    'mime_type'  => $file->getClientMimeType(),
                    'sort_order' => $sortOrder++,
                    'caption'    => null,
                ]);
            }
        }

        return redirect()->route('umkm.index')->with('success', 'Data UMKM dan media berhasil diperbarui!');
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

}
