<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('admin.users.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|max:255|unique:users,email,' . $user->id,
            'current_password'      => 'nullable|required_with:new_password',
            'new_password'          => 'nullable|min:6|confirmed',
        ]);

        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
            }
            $data['password'] = Hash::make($request->new_password);
        }

        unset($data['current_password'], $data['new_password'], $data['new_password_confirmation']);
        $user->update($data);

        Aktivitas::log('edit', 'auth', "Memperbarui akun profil/password: {$user->name}");

        return back()->with('success', 'Profil & password berhasil diperbarui.');
    }

    // Aliases for backward compatibility
    public function profileIndex() { return $this->index(); }
    public function profileUpdate(Request $request) { return $this->update($request); }
}
