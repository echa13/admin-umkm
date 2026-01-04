<?php
namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Produk;
use App\Models\Umkm;
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
            'nama_produk' => 'required',
            'foto'        => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $produk = Produk::create([
            'umkm_id'     => $request->umkm_id,
            'nama_produk' => $request->nama_produk,
            'deskripsi'   => $request->deskripsi,
            'harga'       => $request->harga,
            'stok'        => $request->stok,
            'status'      => $request->status,
        ]);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');

            // ⬇⬇⬇ INI PENTING
            $file->storeAs(
                'produk',          // folder
                $file->hashName(), // nama unik
                'public'           // DISK PUBLIC
            );

            Media::create([
                'ref_table'  => 'produk',
                'ref_id'     => $produk->produk_id,
                'file_name'  => $file->hashName(),
                'mime_type'  => $file->getClientMimeType(),
                'sort_order' => 1,
            ]);
        }

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan');
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
            'umkm_id'     => 'required|exists:umkm,umkm_id',
            'nama_produk' => 'required|string|max:255',
            'deskripsi'   => 'nullable|string',
            'harga'       => 'required|numeric',
            'stok'        => 'required|integer',
            'status'      => 'required|in:tersedia,kosong',
            'foto'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // update data produk (TANPA FOTO)
        $produk->update([
            'umkm_id'     => $request->umkm_id,
            'nama_produk' => $request->nama_produk,
            'deskripsi'   => $request->deskripsi,
            'harga'       => $request->harga,
            'stok'        => $request->stok,
            'status'      => $request->status,
        ]);

        // JIKA ADA FOTO BARU
        if ($request->hasFile('foto')) {

            // ambil media lama
            $oldMedia = Media::where('ref_table', 'produk')
                ->where('ref_id', $produk->produk_id)
                ->first();

            // hapus file lama
            if ($oldMedia && Storage::disk('public')->exists('produk/' . $oldMedia->file_name)) {
                Storage::disk('public')->delete('produk/' . $oldMedia->file_name);
                $oldMedia->delete();
            }

            // upload foto baru
            $file = $request->file('foto');
            $file->storeAs(
                'produk',
                $file->hashName(),
                'public'
            );

            // simpan media baru
            Media::create([
                'ref_table'  => 'produk',
                'ref_id'     => $produk->produk_id,
                'file_name'  => $file->hashName(),
                'caption'    => $request->nama_produk,
                'mime_type'  => $file->getClientMimeType(),
                'sort_order' => 1,
            ]);
        }

        return redirect()
            ->route('produk.index')
            ->with('success', 'Produk berhasil diperbarui');
    }

    public function destroy(Produk $produk)
    {
        $medias = Media::where('ref_table', 'produk')
            ->where('ref_id', $produk->produk_id)
            ->get();
        foreach ($medias as $media) {
            Storage::delete('public/produk/' . $media->file_name);
            $media->delete();
        }

        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');
    }
}
