<?php
namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::with('media')
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            })
            ->latest()
            ->paginate(8);

        return view('pages.user.index', compact('users'));
    }

    public function create()
    {
        return view('pages.user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:8|regex:/[A-Z]/',
            'role'     => 'required',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $i => $file) {
                $name = time() . '_' . Str::random(6) . '.' . $file->extension();
                $file->storeAs('public/user_media', $name);

                $user->media()->create([
                    'ref_table'  => 'users',
                    'ref_id'     => $user->id,
                    'file_name'  => $name,
                    'mime_type'  => $file->getClientMimeType(),
                    'sort_order' => $i,
                ]);
            }
        }

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan');
    }

    public function show(User $user)
    {
        $user->load('media');
        return view('pages.user.show', compact('user'));
    }

    public function edit(User $user)
    {
        $user->load('media');
        return view('pages.user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => "required|email|unique:users,email,$user->id",
            'password' => 'nullable|min:8|regex:/[A-Z]/',
            'role'     => 'required',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->only('name', 'email', 'role');

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        if ($request->hasFile('images')) {
            foreach ($user->media as $media) {
                Storage::delete('public/user_media/' . $media->file_name);
                $media->delete();
            }

            foreach ($request->file('images') as $i => $file) {
                $name = time() . '_' . Str::random(6) . '.' . $file->extension();
                $file->storeAs('public/user_media', $name);

                $user->media()->create([
                    'ref_table'  => 'users',
                    'ref_id'     => $user->id,
                    'file_name'  => $name,
                    'mime_type'  => $file->getClientMimeType(),
                    'sort_order' => $i,
                ]);
            }
        }

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui');
    }

    public function destroy(User $user)
    {
        foreach ($user->media as $media) {
            Storage::delete('public/user_media/' . $media->file_name);
            $media->delete();
        }

        $user->delete();
        return back()->with('success', 'User berhasil dihapus');
    }
}
