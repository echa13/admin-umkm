<?php
namespace App\Http\Controllers;

use App\Models\Umkm;
use Illuminate\Http\Request;

class UmkmController extends Controller
{
    /**
     * Tampilkan semua data UMKM
     */
    public function index()
    {
        // Ambil semua data UMKM
        $umkms = Umkm::all();
        return view('pages.Umkm.index', compact('umkms'));
    }

    /**
     * Tampilkan form tambah data UMKM
     */
    public function create()
    {
        return view('page.Umkm.create');
    }

    /**
     * Simpan data UMKM baru ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_usaha'   => 'required|string|max:150',
            'pemilik_nama' => 'required|string|max:150',
            'alamat'       => 'required|string|max:255',
            'rt'           => 'nullable|string|max:5',
            'rw'           => 'nullable|string|max:5',
            'kategori'     => 'required|string|max:100',
            'kontak'       => 'nullable|string|max:20',
            'deskripsi'    => 'nullable|string',
        ]);

        Umkm::create($request->all());

        return redirect()->route('umkm.index')->with('success', 'Data UMKM berhasil ditambahkan!');
    }

    /**
     * Tampilkan detail data UMKM berdasarkan ID
     */
    public function show($id)
    {
        $umkm = Umkm::findOrFail($id);
        return view('page.umkm.show', compact('umkm'));
    }

    /**
     * Tampilkan form edit data UMKM
     */
    public function edit($id)
    {
        $umkm = Umkm::findOrFail($id);
        return view('umkm.edit', compact('umkm'));
    }

    /**
     * Update data UMKM
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_usaha'   => 'required|string|max:150',
            'pemilik_nama' => 'required|string|max:150',
            'alamat'       => 'required|string|max:255',
            'rt'           => 'nullable|string|max:5',
            'rw'           => 'nullable|string|max:5',
            'kategori'     => 'required|string|max:100',
            'kontak'       => 'nullable|string|max:20',
            'deskripsi'    => 'nullable|string',
        ]);

        $umkm = Umkm::findOrFail($id);
        $umkm->update($request->all());

        return redirect()->route('umkm.index')->with('success', 'Data UMKM berhasil diperbarui!');
    }

    /**
     * Hapus data UMKM
     */
    public function destroy($id)
    {
        $umkm = Umkm::findOrFail($id);
        $umkm->delete();

        return redirect()->route('umkm.index')->with('success', 'Data UMKM berhasil dihapus!');
    }
}
