<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['roles', 'jurusan'])->latest()->get();
        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        $roles    = Role::whereIn('name', ['Admin', 'Guru', 'Siswa'])->get();
        $jurusans = Jurusan::all();
        return view('admin.user.create', compact('roles', 'jurusans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|string|min:8|confirmed',
            'role'       => 'required|string|exists:roles,name',
            'jurusan_id' => 'nullable|exists:jurusans,id',
        ]);

        $user = User::create([
            'name'       => $validated['name'],
            'email'      => $validated['email'],
            'password'   => Hash::make($validated['password']),
            'jurusan_id' => $validated['jurusan_id'] ?? null,
        ]);

        $user->assignRole($validated['role']);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $roles    = Role::whereIn('name', ['Admin', 'Guru', 'Siswa'])->get();
        $jurusans = Jurusan::all();
        return view('admin.user.edit', compact('user', 'roles', 'jurusans'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email,' . $user->id,
            'password'   => 'nullable|string|min:8|confirmed',
            'role'       => 'required|string|exists:roles,name',
            'jurusan_id' => 'nullable|exists:jurusans,id',
        ]);

        $user->update([
            'name'       => $validated['name'],
            'email'      => $validated['email'],
            'jurusan_id' => $validated['jurusan_id'] ?? null,
        ]);

        if (!empty($validated['password'])) {
            $user->update(['password' => Hash::make($validated['password'])]);
        }

        $user->syncRoles([$validated['role']]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        // Prevent deleting the primary admin account or own account
        if ($user->id === auth()->id() || $user->email === 'admin@talogsmkn20.local') {
            return redirect()->route('admin.users.index')
                ->with('error', 'Akun Administrator utama atau akun Anda sendiri tidak dapat dihapus.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}
