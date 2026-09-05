<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aktivitas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::latest()->paginate(15);
        return view('admin.users.users-index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.users-form', ['user' => null]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users',
            'role'     => 'required|string|in:admin,staf',
            'password' => 'required|min:6',
        ]);

        $data['password'] = Hash::make($data['password']);
        $newUser = User::create($data);

        Aktivitas::log('tambah', 'users', "Menambahkan staf admin baru: {$newUser->name} ({$newUser->email})");

        return redirect()->route('admin.users.index')->with('success', 'Staf admin baru berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.users-form', compact('user'));
    }

    public function update(Request $request, int $id)
    {
        $targetUser = User::findOrFail($id);

        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email,' . $targetUser->id,
            'role'     => 'required|string|in:admin,staf',
            'password' => 'nullable|min:6',
        ]);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        $targetUser->update($data);

        Aktivitas::log('edit', 'users', "Memperbarui data akun staf admin: {$targetUser->name}");

        return redirect()->route('admin.users.index')->with('success', 'Data staf admin berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        if (Auth::id() === $id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $targetUser = User::findOrFail($id);
        $name = $targetUser->name;
        $targetUser->delete();

        Aktivitas::log('hapus', 'users', "Menghapus akun staf admin: {$name}");

        return back()->with('success', 'Akun staf admin berhasil dihapus.');
    }

    // Aliases for backward compatibility
    public function usersIndex(Request $request) { return $this->index($request); }
    public function usersCreate() { return $this->create(); }
    public function usersStore(Request $request) { return $this->store($request); }
    public function usersEdit(int $id) { return $this->edit($id); }
    public function usersUpdate(Request $request, int $id) { return $this->update($request, $id); }
    public function usersDestroy(int $id) { return $this->destroy($id); }
}
