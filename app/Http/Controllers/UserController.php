<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Menampilkan daftar user.
     */
    public function index()
    {
        $users = User::all();
        return view('pages.user.index', compact('users'));
    }

    /**
     * Menampilkan form tambah user.
     */
    public function create()
    {
        return view('pages.user.create');
    }

    /**
     * Menyimpan user baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:8|regex:/[A-Z]/',
        ], [
            'name.required'     => 'Nama wajib diisi!',
            'email.required'    => 'Email wajib diisi!',
            'email.unique'      => 'Email sudah digunakan!',
            'password.required' => 'Password wajib diisi!',
            'password.min'      => 'Password minimal 8 karakter!',
            'password.regex'    => 'Password harus ada huruf kapital!',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password), /** HASH PASSWORD */
        ]);

        return redirect()->route('login')->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail user.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Menampilkan form edit user.
     */
    public function edit(User $user)
    {
        return view('pages.user.edit', compact('user'));
    }

    /**
     * Memperbarui data user.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required',
            'email' => "required|email|unique:users,email,{$user->id}",
            'password' => 'nullable|min:8|regex:/[A-Z]/',
        ]);

        $data = $request->only(['name', 'email']);
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui!');
    }

    /**
     * Menghapus user.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus!');
    }
}
