@extends('layouts.admin')

@section('title', 'Log Aktivitas Sistem')
@section('subtitle', 'Catatan jejak aktivitas admin dalam menambah, memperbarui, dan menghapus data portal APPSI')

@section('content')
<div class="space-y-5">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h3 class="text-lg font-bold text-slate-800">Catatan Jejak Audit Sistem (Activity Log)</h3>
            <p class="text-xs text-slate-500">Merekam otomatis setiap perubahan data yang dilakukan oleh administrator</p>
        </div>
    </div>

    {{-- Toolbar Filter & Search --}}
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs">
        <form method="GET" action="{{ route('admin.aktivitas.index') }}" class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3">
            <div class="relative flex-1">
                <span class="material-symbols-outlined absolute left-3 top-2.5 text-slate-400 text-sm">search</span>
                <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari aktivitas atau nama administrator..."
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-9 pr-4 py-2 text-xs font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors">
            </div>

            <div class="flex items-center gap-2 shrink-0">
                <select name="modul" onchange="this.form.submit()"
                    class="text-xs border border-slate-200 rounded-xl px-3 py-2 bg-slate-50 text-slate-700 font-medium focus:outline-none focus:bg-white cursor-pointer">
                    <option value="">Semua Modul</option>
                    <option value="berita" {{ request('modul') == 'berita' ? 'selected' : '' }}>Berita</option>
                    <option value="pengurus" {{ request('modul') == 'pengurus' ? 'selected' : '' }}>Pengurus</option>
                    <option value="pustaka" {{ request('modul') == 'pustaka' ? 'selected' : '' }}>Pustaka</option>
                    <option value="provinsi" {{ request('modul') == 'provinsi' ? 'selected' : '' }}>Provinsi</option>
                    <option value="users" {{ request('modul') == 'users' ? 'selected' : '' }}>User Admin</option>
                    <option value="pengaturan" {{ request('modul') == 'pengaturan' ? 'selected' : '' }}>Pengaturan</option>
                    <option value="auth" {{ request('modul') == 'auth' ? 'selected' : '' }}>Login / Auth</option>
                </select>

                <button type="submit" class="px-4 py-2 bg-navy-900 hover:bg-navy-800 text-white font-semibold text-xs rounded-xl transition-colors">
                    Filter
                </button>

                @if(request('cari') || request('modul'))
                    <a href="{{ route('admin.aktivitas.index') }}" class="px-3 py-2 text-rose-600 hover:bg-rose-50 font-semibold text-xs rounded-xl transition-colors inline-flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">restart_alt</span>
                        <span>Reset</span>
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 uppercase font-semibold border-b border-slate-200">
                    <tr>
                        <th class="px-5 py-3.5 w-12">#</th>
                        <th class="px-5 py-3.5">Waktu</th>
                        <th class="px-5 py-3.5">Administrator</th>
                        <th class="px-5 py-3.5">Aksi & Modul</th>
                        <th class="px-5 py-3.5">Detail Catatan</th>
                        <th class="px-5 py-3.5 text-right">IP Address</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($aktivitas as $index => $act)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-5 py-3.5 text-slate-400 font-mono">
                                #{{ $aktivitas->firstItem() + $index }}
                            </td>
                            <td class="px-5 py-3.5 text-slate-500 whitespace-nowrap font-mono text-[11px]">
                                {{ $act->created_at ? $act->created_at->translatedFormat('d M Y, H:i:s') : '-' }}
                            </td>
                            <td class="px-5 py-3.5 font-bold text-slate-900">
                                {{ $act->user_name }}
                            </td>
                            <td class="px-5 py-3.5 whitespace-nowrap">
                                @php
                                    $badgeStyle = match(strtolower($act->action)) {
                                        'tambah' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                        'edit'   => 'bg-amber-100 text-amber-800 border-amber-200',
                                        'hapus'  => 'bg-rose-100 text-rose-800 border-rose-200',
                                        'login'  => 'bg-blue-100 text-blue-800 border-blue-200',
                                        default  => 'bg-slate-100 text-slate-700 border-slate-200',
                                    };
                                @endphp
                                <span class="px-2 py-0.5 rounded text-[10px] font-extrabold uppercase border {{ $badgeStyle }}">
                                    {{ $act->action }}
                                </span>
                                <span class="text-slate-400 mx-1">&bull;</span>
                                <span class="font-bold text-slate-600 uppercase text-[10px]">{{ $act->module }}</span>
                            </td>
                            <td class="px-5 py-3.5 text-slate-700 font-medium">
                                {{ $act->description }}
                            </td>
                            <td class="px-5 py-3.5 text-right text-slate-400 font-mono text-[11px]">
                                {{ $act->ip_address ?: '127.0.0.1' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center text-slate-400">
                                <span class="material-symbols-outlined text-4xl mb-1 text-slate-300 block">history_toggle_off</span>
                                Belum ada log aktivitas tercatat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($aktivitas->hasPages())
        <div class="px-5 py-4 border-t border-slate-100 bg-slate-50/60">
            {{ $aktivitas->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
