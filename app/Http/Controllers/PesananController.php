<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Warga;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PesananController extends Controller
{
    public function index()
    {
        $pesanans = Pesanan::with('warga','media')->get();
        return view('pages.pesanan.index', compact('pesanans'));
    }

    public function create()
    {
        $wargas = Warga::all();
        return view('pages.pesanan.create', compact('wargas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_pesanan' => 'required|unique:pesanan,nomor_pesanan',
            'warga_id' => 'required|exists:warga,warga_id',
            'total' => 'required|numeric',
            'status' => 'required|in:pending,dibayar,dikirim,selesai,dibatalkan',
            'alamat_kirim' => 'required|string|max:255',
            'rt' => 'nullable|string|max:5',
            'rw' => 'nullable|string|max:5',
            'metode_bayar' => 'required|string|max:50',
            'bukti' => 'nullable|image|max:2048', // media
        ]);

        $pesanan = Pesanan::create($request->all());

        // Upload bukti/resi
        if($request->hasFile('bukti')){
            $file = $request->file('bukti');
            $fileName = time().'_'.$file->getClientOriginalName();
            $file->storeAs('public/pesanan', $fileName);

            Media::create([
                'ref_table' => 'pesanan',
                'ref_id' => $pesanan->pesanan_id,
                'file_name' => $fileName,
                'caption' => 'Bukti Bayar '.$pesanan->nomor_pesanan,
                'mime_type' => $file->getClientMimeType(),
                'sort_order' => 1,
            ]);
        }

        return redirect()->route('pesanan.index')->with('success','Pesanan berhasil dibuat.');
    }

    public function show(Pesanan $pesanan)
    {
        $pesanan->load('warga','media');
        return view('pages.pesanan.show', compact('pesanan'));
    }

    public function edit(Pesanan $pesanan)
    {
        $wargas = Warga::all();
        return view('pages.pesanan.edit', compact('pesanan','wargas'));
    }

    public function update(Request $request, Pesanan $pesanan)
    {
        $request->validate([
            'nomor_pesanan' => 'required|unique:pesanan,nomor_pesanan,'.$pesanan->pesanan_id.',pesanan_id',
            'warga_id' => 'required|exists:warga,warga_id',
            'total' => 'required|numeric',
            'status' => 'required|in:pending,dibayar,dikirim,selesai,dibatalkan',
            'alamat_kirim' => 'required|string|max:255',
            'rt' => 'nullable|string|max:5',
            'rw' => 'nullable|string|max:5',
            'metode_bayar' => 'required|string|max:50',
            'bukti' => 'nullable|image|max:2048',
        ]);

        $pesanan->update($request->all());

        if($request->hasFile('bukti')){
            $oldMedia = Media::where('ref_table','pesanan')
                             ->where('ref_id',$pesanan->pesanan_id)
                             ->first();
            if($oldMedia){
                Storage::delete('public/pesanan/'.$oldMedia->file_name);
                $oldMedia->delete();
            }

            $file = $request->file('bukti');
            $fileName = time().'_'.$file->getClientOriginalName();
            $file->storeAs('public/pesanan', $fileName);

            Media::create([
                'ref_table' => 'pesanan',
                'ref_id' => $pesanan->pesanan_id,
                'file_name' => $fileName,
                'caption' => 'Bukti Bayar '.$pesanan->nomor_pesanan,
                'mime_type' => $file->getClientMimeType(),
                'sort_order' => 1,
            ]);
        }

        return redirect()->route('pesanan.index')->with('success','Pesanan berhasil diperbarui.');
    }

    public function destroy(Pesanan $pesanan)
    {
        $medias = Media::where('ref_table','pesanan')
                       ->where('ref_id',$pesanan->pesanan_id)
                       ->get();
        foreach($medias as $media){
            Storage::delete('public/pesanan/'.$media->file_name);
            $media->delete();
        }

        $pesanan->delete();

        return redirect()->route('pesanan.index')->with('success','Pesanan berhasil dihapus.');
    }
}
