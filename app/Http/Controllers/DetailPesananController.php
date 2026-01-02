<?php

namespace App\Http\Controllers;

use App\Models\DetailPesanan;
use App\Models\Pesanan;
use App\Models\Produk;
use Illuminate\Http\Request;

class DetailPesananController extends Controller
{
    public function index()
    {
        $details = DetailPesanan::with('pesanan','produk')->get();
        return view('pages.detail_pesanan.index', compact('details'));
    }

    public function create()
    {
        $pesanans = Pesanan::all();
        $produks = Produk::all();
        return view('pages.detail_pesanan.create', compact('pesanans','produks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pesanan_id' => 'required|exists:pesanan,pesanan_id',
            'produk_id' => 'required|exists:produks,produk_id',
            'qty' => 'required|integer|min:1',
            'harga_satuan' => 'required|numeric|min:0',
        ]);

        $subtotal = $request->qty * $request->harga_satuan;

        DetailPesanan::create([
            'pesanan_id' => $request->pesanan_id,
            'produk_id' => $request->produk_id,
            'qty' => $request->qty,
            'harga_satuan' => $request->harga_satuan,
            'subtotal' => $subtotal,
        ]);

        return redirect()->route('detail_pesanan.index')->with('success','Detail pesanan berhasil dibuat.');
    }

    public function show(DetailPesanan $detail_pesanan)
    {
        $detail_pesanan->load('pesanan','produk');
        return view('pages.detail_pesanan.show', compact('detail_pesanan'));
    }

    public function edit(DetailPesanan $detail_pesanan)
    {
        $pesanans = Pesanan::all();
        $produks = Produk::all();
        return view('pages.detail_pesanan.edit', compact('detail_pesanan','pesanans','produks'));
    }

    public function update(Request $request, DetailPesanan $detail_pesanan)
    {
        $request->validate([
            'pesanan_id' => 'required|exists:pesanan,pesanan_id',
            'produk_id' => 'required|exists:produks,produk_id',
            'qty' => 'required|integer|min:1',
            'harga_satuan' => 'required|numeric|min:0',
        ]);

        $subtotal = $request->qty * $request->harga_satuan;

        $detail_pesanan->update([
            'pesanan_id' => $request->pesanan_id,
            'produk_id' => $request->produk_id,
            'qty' => $request->qty,
            'harga_satuan' => $request->harga_satuan,
            'subtotal' => $subtotal,
        ]);

        return redirect()->route('detail_pesanan.index')->with('success','Detail pesanan berhasil diperbarui.');
    }

    public function destroy(DetailPesanan $detail_pesanan)
    {
        $detail_pesanan->delete();
        return redirect()->route('detail_pesanan.index')->with('success','Detail pesanan berhasil dihapus.');
    }
}
