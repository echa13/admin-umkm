<?php

namespace App\Http\Controllers;

use App\Models\UlasanProduk;
use App\Models\Produk;
use App\Models\Warga;
use Illuminate\Http\Request;

class UlasanProdukController extends Controller
{
    public function index()
    {
        $ulasan = UlasanProduk::with('produk','warga')->get();
        return view('pages.ulasan_produk.index', compact('ulasan'));
    }

    public function create()
    {
        $produks = Produk::all();
        $wargas = Warga::all();
        return view('pages.ulasan_produk.create', compact('produks','wargas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,produk_id',
            'warga_id' => 'required|exists:warga,warga_id',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string',
        ]);

        UlasanProduk::create($request->all());

        return redirect()->route('ulasan_produk.index')->with('success','Ulasan berhasil ditambahkan.');
    }

    public function show(UlasanProduk $ulasan_produk)
    {
        $ulasan_produk->load('produk','warga');
        return view('pages.ulasan_produk.show', compact('ulasan_produk'));
    }

    public function edit(UlasanProduk $ulasan_produk)
    {
        $produks = Produk::all();
        $wargas = Warga::all();
        return view('pages.ulasan_produk.edit', compact('ulasan_produk','produks','wargas'));
    }

    public function update(Request $request, UlasanProduk $ulasan_produk)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,produk_id',
            'warga_id' => 'required|exists:warga,warga_id',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string',
        ]);

        $ulasan_produk->update($request->all());

        return redirect()->route('ulasan_produk.index')->with('success','Ulasan berhasil diperbarui.');
    }

    public function destroy(UlasanProduk $ulasan_produk)
    {
        $ulasan_produk->delete();
        return redirect()->route('ulasan_produk.index')->with('success','Ulasan berhasil dihapus.');
    }
}
