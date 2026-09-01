@extends('layouts.admin')

@section('title', $user ? 'Edit Staf Admin: ' . $user->name : 'Tambah Staf Admin Baru')
@section('subtitle', $user ? 'Perbarui informasi kredensial dan hak akses staf admin' : 'Daftarkan akun staf pengelola admin baru')

@section('content')
<div class="max-w-3xl space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-slate-800 transition-colors">
            <span class="material-symbols-outlined text-base">arrow_back</span>
            <span>Kembali ke Daftar Admin</span>
        </a>
    </div>

    <form action="{{ $user ? route('admin.users.update', $user->id) : route('admin.users.store') }}" method="POST">
        @csrf
        @if($user)
            @method('PUT')
        @endif

        <div class="bg-white p-6 md:p-8 rounded-2xl border border-slate-200 shadow-xs space-y-6">
            <h3 class="font-bold text-slate-900 text-lg border-b border-slate-100 pb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-amber-500">manage_accounts</span>
                <span>{{ $user ? 'Form Edit Akun Admin' : 'Form Pendaftaran Staf Admin Baru' }}</span>
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Lengkap <span class="text-rose-500">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name ?? '') }}" required
                        class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors"
                        placeholder="Contoh: Ahmad Rizki">
                </div>

                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Alamat Email <span class="text-rose-500">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email ?? '') }}" required
                        class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors"
                        placeholder="Contoh: rizki@appsi.or.id">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="role" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Peran / Hak Akses <span class="text-rose-500">*</span></label>
                    <select id="role" name="role" required
                        class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors cursor-pointer">
                        <option value="admin" {{ old('role', $user->role ?? 'admin') === 'admin' ? 'selected' : '' }}>Administrator Utama</option>
                        <option value="staf"  {{ old('role', $user->role ?? '') === 'staf' ? 'selected' : '' }}>Staf Redaksi / Admin Berita</option>
                    </select>
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Password {{ $user ? '(Biarkan kosong jika tidak diubah)' : '*' }}
                    </label>
                    <input type="password" id="password" name="password" {{ $user ? '' : 'required' }}
                        class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors"
                        placeholder="{{ $user ? 'Ketik password baru...' : 'Minimal 6 karakter...' }}">
                </div>
            </div>

            <!-- Submit Bar -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs rounded-xl transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-navy-950 font-bold text-xs rounded-xl shadow-md transition-all inline-flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-sm">save</span>
                    <span>{{ $user ? 'Simpan Perubahan' : 'Daftarkan Admin' }}</span>
                </button>
            </div>
        </div>
    </form>

</div>
@endsection
