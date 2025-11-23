<?php
namespace App\Http\Controllers;

use App\Models\Warga;
use Illuminate\Http\Request;

class WargaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $datas = Warga::when($request->search, function ($query) use ($request) {
            $query->where('nama', 'like', '%' . $request->search . '%')
                ->orWhere('no_ktp', 'like', '%' . $request->search . '%');
        })
            ->when($request->jenis_kelamin, function ($query) use ($request) {
                $query->where('jenis_kelamin', $request->jenis_kelamin);
            })
            ->orderBy('warga_id', 'DESC')
            ->paginate(8); // jumlah data per halaman

        return view('pages.warga.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.warga.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'no_ktp'        => 'required|string|unique:warga,no_ktp|max:255',
            'nama'          => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'agama'         => 'required|string|max:255',
            'pekerjaan'     => 'nullable|string|max:255',
            'telp'          => 'nullable|string|max:15',
            'email'         => 'nullable|email|max:255',
        ]);

        // 2. Buat record baru di database
        Warga::create($validatedData);

        // 3. Redirect kembali dengan pesan sukses
        return redirect()->route('warga.index')
            ->with('success', 'Data Warga berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Warga::findOrFail($id);
        return view('pages.warga.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'no_ktp'        => 'required|string|max:255|unique:warga,no_ktp,' . $id . ',warga_id',
            'nama'          => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'agama'         => 'required|string|max:255',
            'pekerjaan'     => 'nullable|string|max:255',
            'telp'          => 'nullable|string|max:15',
            'email'         => 'nullable|email|max:255',
        ]);

        Warga::where('warga_id', $id)->update($validatedData);

        return redirect()->route('warga.index')
            ->with('success', 'Data Warga berhasil diperbarui!');
    }

    public function destroy(Warga $warga)
    {
        $warga->delete();

        return redirect()->route('warga.index')
            ->with('success', 'Data Warga berhasil dihapus!');
    }
}
