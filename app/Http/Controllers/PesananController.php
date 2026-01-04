<?php
namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Pesanan;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PesananController extends Controller
{
    public function index()
    {
        $pesanans = Pesanan::with('warga', 'media')->get();
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
            'warga_id'      => 'required|exists:warga,warga_id',
            'total'         => 'required|numeric',
            'status'        => 'required|in:pending,dibayar,dikirim,selesai,dibatalkan',
            'alamat_kirim'  => 'required|string|max:255',
            'rt'            => 'nullable|string|max:5',
            'rw'            => 'nullable|string|max:5',
            'metode_bayar'  => 'required|string|max:50',
            'bukti'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $pesanan = Pesanan::create([
            'nomor_pesanan' => $request->nomor_pesanan,
            'warga_id'      => $request->warga_id,
            'total'         => $request->total,
            'status'        => $request->status,
            'alamat_kirim'  => $request->alamat_kirim,
            'rt'            => $request->rt,
            'rw'            => $request->rw,
            'metode_bayar'  => $request->metode_bayar,
        ]);

        if ($request->hasFile('bukti')) {
            $file = $request->file('bukti');

            $file->storeAs(
                'pesanan',
                $file->hashName(),
                'public'
            );

            Media::create([
                'ref_table'  => 'pesanan',
                'ref_id'     => $pesanan->pesanan_id,
                'file_name'  => $file->hashName(),
                'caption'    => 'Bukti Bayar ' . $pesanan->nomor_pesanan,
                'mime_type'  => $file->getClientMimeType(),
                'sort_order' => 1,
            ]);
        }

        return redirect()
            ->route('pesanan.index')
            ->with('success', 'Pesanan berhasil dibuat.');
    }

    public function show(Pesanan $pesanan)
    {
        $pesanan->load('warga', 'media');
        return view('pages.pesanan.show', compact('pesanan'));
    }

    public function edit(Pesanan $pesanan)
    {
        $wargas = Warga::all();
        return view('pages.pesanan.edit', compact('pesanan', 'wargas'));
    }

    public function update(Request $request, Pesanan $pesanan)
    {
        $request->validate([
            'nomor_pesanan' => 'required|unique:pesanan,nomor_pesanan,' . $pesanan->pesanan_id . ',pesanan_id',
            'warga_id'      => 'required|exists:warga,warga_id',
            'total'         => 'required|numeric',
            'status'        => 'required|in:pending,dibayar,dikirim,selesai,dibatalkan',
            'alamat_kirim'  => 'required|string|max:255',
            'rt'            => 'nullable|string|max:5',
            'rw'            => 'nullable|string|max:5',
            'metode_bayar'  => 'required|string|max:50',
            'bukti'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // update data TANPA file
        $pesanan->update([
            'nomor_pesanan' => $request->nomor_pesanan,
            'warga_id'      => $request->warga_id,
            'total'         => $request->total,
            'status'        => $request->status,
            'alamat_kirim'  => $request->alamat_kirim,
            'rt'            => $request->rt,
            'rw'            => $request->rw,
            'metode_bayar'  => $request->metode_bayar,
        ]);

        if ($request->hasFile('bukti')) {

            $oldMedia = Media::where('ref_table', 'pesanan')
                ->where('ref_id', $pesanan->pesanan_id)
                ->first();

            if ($oldMedia && Storage::disk('public')->exists('pesanan/' . $oldMedia->file_name)) {
                Storage::disk('public')->delete('pesanan/' . $oldMedia->file_name);
                $oldMedia->delete();
            }

            $file = $request->file('bukti');

            $file->storeAs(
                'pesanan',
                $file->hashName(),
                'public'
            );

            Media::create([
                'ref_table'  => 'pesanan',
                'ref_id'     => $pesanan->pesanan_id,
                'file_name'  => $file->hashName(),
                'caption'    => 'Bukti Bayar ' . $pesanan->nomor_pesanan,
                'mime_type'  => $file->getClientMimeType(),
                'sort_order' => 1,
            ]);
        }

        return redirect()
            ->route('pesanan.index')
            ->with('success', 'Pesanan berhasil diperbarui.');
    }

    public function destroy(Pesanan $pesanan)
    {
        $medias = Media::where('ref_table', 'pesanan')
            ->where('ref_id', $pesanan->pesanan_id)
            ->get();
        foreach ($medias as $media) {
            Storage::delete('public/pesanan/' . $media->file_name);
            $media->delete();
        }

        $pesanan->delete();

        return redirect()->route('pesanan.index')->with('success', 'Pesanan berhasil dihapus.');
    }
}
