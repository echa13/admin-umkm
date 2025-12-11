<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Media;


class UserController extends Controller
{
    /**
     * Menampilkan daftar user.
     */
    public function index(Request $request)
    {
        $users = User::when($request->search, function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
        })
            ->orderBy('created_at', 'DESC')
            ->paginate(8); // jumlah per halaman

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
            'images.*'          => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role ?? 'user',
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $file) {
                $fileName = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/user_media', $fileName);

                $user->media()->create([
                    'ref_table'  => 'users',
                    'ref_id'     => $user->id,
                    'file_name'  => $fileName,
                    'mime_type'  => $file->getClientMimeType(),
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('login')->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail user.
     */
    public function show(User $user)
    {
        $media = Media::where('ref_table', 'users')
            ->where('ref_id', $user->id)
            ->get();

        return view('pages.user.show', [
            'user'  => $user,
            'media' => $media,
        ]);
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
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->only(['name', 'email', 'role']);
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        // Upload foto baru
        if ($request->hasFile('images')) {
            // Hapus file lama
            foreach ($user->media as $media) {
                if (\Storage::exists('public/user_media/' . $media->file_name)) {
                    \Storage::delete('public/user_media/' . $media->file_name);
                }
                $media->delete();
            }

            // Simpan file baru
            foreach ($request->file('images') as $index => $file) {
                $fileName = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/user_media', $fileName);

                $user->media()->create([
                    'ref_table'  => 'users',
                    'file_name'  => $fileName,
                    'mime_type'  => $file->getClientMimeType(),
                    'sort_order' => $index,
                ]);

            }
        }

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
