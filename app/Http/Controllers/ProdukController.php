<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Umkm;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index()
    {
        $produks = Produk::with('umkm', 'media')->get();
        return view('pages.produk.index', compact('produks'));
    }

    public function create()
    {
        $umkms = Umkm::all();
        return view('pages.produk.create', compact('umkms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'umkm_id' => 'required|exists:umkm,umkm_id',
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'status' => 'required|in:tersedia,kosong',
            'foto' => 'nullable|image|max:2048',
        ]);

        $produk = Produk::create($request->all());

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fileName = time().'_'.$file->getClientOriginalName();
            $file->storeAs('public/produk', $fileName);

            Media::create([
                'ref_table' => 'produk',
                'ref_id' => $produk->produk_id,
                'file_name' => $fileName,
                'caption' => $request->nama_produk,
                'mime_type' => $file->getClientMimeType(),
                'sort_order' => 1,
            ]);
        }

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show(Produk $produk)
    {
        // load relasi umkm dan media
        $produk->load('umkm', 'media');

        return view('pages.produk.show', compact('produk'));
    }

    public function edit(Produk $produk)
    {
        $umkms = Umkm::all();
        return view('pages.produk.edit', compact('produk', 'umkms'));
    }

    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'umkm_id' => 'required|exists:umkm,umkm_id',
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'status' => 'required|in:tersedia,kosong',
            'foto' => 'nullable|image|max:2048',
        ]);

        $produk->update($request->all());

        if ($request->hasFile('foto')) {
            $oldMedia = Media::where('ref_table', 'produk')
                             ->where('ref_id', $produk->produk_id)
                             ->first();
            if ($oldMedia) {
                Storage::delete('public/produk/'.$oldMedia->file_name);
                $oldMedia->delete();
            }

            $file = $request->file('foto');
            $fileName = time().'_'.$file->getClientOriginalName();
            $file->storeAs('public/produk', $fileName);

            Media::create([
                'ref_table' => 'produk',
                'ref_id' => $produk->produk_id,
                'file_name' => $fileName,
                'caption' => $request->nama_produk,
                'mime_type' => $file->getClientMimeType(),
                'sort_order' => 1,
            ]);
        }

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Produk $produk)
    {
        $medias = Media::where('ref_table', 'produk')
                       ->where('ref_id', $produk->produk_id)
                       ->get();
        foreach($medias as $media){
            Storage::delete('public/produk/'.$media->file_name);
            $media->delete();
        }

        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');
    }
}
