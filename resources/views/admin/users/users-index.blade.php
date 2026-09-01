@extends('layouts.admin')

@section('title', 'Akun Pengelola')
@section('subtitle', 'Daftar administrator dan staf pengelola portal website APPSI')

@section('content')
<div class="space-y-5">

    {{-- Header Action Bar --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h3 class="text-lg font-bold text-slate-800">Daftar Akun Pengelola Admin</h3>
            <p class="text-xs text-slate-500">Kelola daftar pengguna yang berhak mengakses panel kontrol admin</p>
        </div>

        <a href="{{ route('admin.users.create') }}" class="px-4 py-2.5 bg-amber-500 hover:bg-amber-600 text-navy-950 font-bold text-xs rounded-xl shadow-xs transition-all inline-flex items-center gap-2 shrink-0">
            <span class="material-symbols-outlined text-sm">person_add</span>
            <span>+ Tambah Staf Admin</span>
        </a>
    </div>

    {{-- Data Table --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 uppercase font-semibold border-b border-slate-200">
                    <tr>
                        <th class="px-5 py-3.5 w-12">#</th>
                        <th class="px-5 py-3.5">Nama Administrator</th>
                        <th class="px-5 py-3.5">Alamat Email</th>
                        <th class="px-5 py-3.5">Peran / Hak Akses</th>
                        <th class="px-5 py-3.5">Tanggal Dibuat</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $index => $u)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-5 py-3.5 text-slate-400 font-mono">
                                #{{ $users->firstItem() + $index }}
                            </td>
                            <td class="px-5 py-3.5 font-bold text-slate-900 flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-navy-900 text-white font-bold flex items-center justify-center text-xs shrink-0">
                                    {{ strtoupper(substr($u->name, 0, 1)) }}
                                </div>
                                <div>
                                    <span class="block">{{ $u->name }}</span>
                                    @if(Auth::id() === $u->id)
                                        <span class="inline-block text-[10px] font-extrabold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded">Akun Anda (Saya)</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-slate-600 font-mono">
                                {{ $u->email }}
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="px-2.5 py-1 rounded-md text-[10px] font-extrabold uppercase tracking-wider {{ strtolower($u->role) === 'admin' ? 'bg-indigo-100 text-indigo-700' : 'bg-slate-100 text-slate-700' }}">
                                    {{ $u->role ?: 'admin' }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-slate-500">
                                {{ $u->created_at ? $u->created_at->translatedFormat('d M Y, H:i') : '-' }}
                            </td>
                            <td class="px-5 py-3.5 text-right whitespace-nowrap space-x-1">
                                <a href="{{ route('admin.users.edit', $u->id) }}" title="Edit User"
                                   class="p-1.5 text-indigo-600 hover:text-indigo-800 font-semibold inline-block">
                                    <span class="material-symbols-outlined text-base">edit</span>
                                </a>

                                @if(Auth::id() !== $u->id)
                                <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun admin ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Hapus User" class="p-1.5 text-rose-500 hover:text-rose-700 font-semibold cursor-pointer">
                                        <span class="material-symbols-outlined text-base">delete</span>
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center text-slate-400">
                                Belum ada data pengguna admin.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
        <div class="px-5 py-4 border-t border-slate-100 bg-slate-50/60">
            {{ $users->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
