@extends('layouts.admin')

@section('title', 'Profil Saya & Ubah Password')
@section('subtitle', 'Kelola informasi identitas pribadi dan keamanan password akun admin Anda')

@section('content')
<div class="max-w-4xl space-y-6">

    <form action="{{ route('admin.profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="bg-white p-6 md:p-8 rounded-2xl border border-slate-200 shadow-xs space-y-6">
            <div class="flex items-center gap-4 border-b border-slate-100 pb-5">
                <div class="w-14 h-14 rounded-2xl bg-navy-900 text-white font-black text-xl flex items-center justify-center shadow-md">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-900">{{ $user->name }}</h3>
                    <p class="text-xs text-slate-500 font-medium">{{ $user->email }} &bull; <span class="uppercase tracking-wider font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded">{{ $user->role ?: 'Admin' }}</span></p>
                </div>
            </div>

            <!-- Informasi Akun -->
            <div class="space-y-4">
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Informasi Akun</h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Lengkap <span class="text-rose-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                            class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors">
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Alamat Email <span class="text-rose-500">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                            class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors">
                    </div>
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- Keamanan & Ubah Password -->
            <div class="space-y-4">
                <div>
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Ubah Password Akun</h4>
                    <p class="text-xs text-slate-500 mt-0.5">Biarkan kosong jika Anda tidak ingin mengubah password akun Anda saat ini.</p>
                </div>

                <div class="space-y-4">
                    <div>
                        <label for="current_password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Password Saat Ini</label>
                        <input type="password" id="current_password" name="current_password"
                            class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors"
                            placeholder="Wajib diisi jika ingin mengganti password">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="new_password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Password Baru</label>
                            <input type="password" id="new_password" name="new_password"
                                class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors"
                                placeholder="Minimal 6 karakter">
                        </div>

                        <div>
                            <label for="new_password_confirmation" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Konfirmasi Password Baru</label>
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                                class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors"
                                placeholder="Ulangi password baru">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Submit -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <button type="submit" class="px-6 py-3 bg-amber-500 hover:bg-amber-600 text-navy-950 font-bold text-xs rounded-xl shadow-md transition-all inline-flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">security</span>
                    <span>Simpan Perubahan Profil</span>
                </button>
            </div>
        </div>
    </form>

</div>
@endsection
