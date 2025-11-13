<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => ['required', 'min:8', 'regex:/[A-Z]/'],
        ], [
            'email.required'    => 'Email wajib diisi!',
            'email.email'       => 'Format email tidak valid!',
            'password.required' => 'Password wajib diisi!',
            'password.min'      => 'Password minimal 8 karakter!',
        ]);

        // Cek user di database
        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Simpan sesi login
            session(['user' => $user]);
            return redirect()->route('home')->with('success', 'Login berhasil! Selamat datang, ' . $user->name);
        }

        return back()->with('error', 'Email atau password salah!')->withInput();
    }

    public function logout(Request $request)
    {
        // Hapus session user
        $request->session()->forget('user');

        // Regenerasi token agar sesi aman
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Kembali ke halaman login
        return redirect()->route('login')->with('success', 'Anda berhasil logout.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
