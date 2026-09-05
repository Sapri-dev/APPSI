@extends('layouts.admin')

@section('title', 'Pesan Masuk')
@section('subtitle', 'Pesan dari formulir kontak website APPSI')

@section('content')
<div class="space-y-5">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                <span class="material-symbols-outlined text-navy-900" style="font-variation-settings:'FILL' 1">mail</span>
                Pesan Masuk
                @if($totalBaru > 0)
                    <span class="inline-flex items-center justify-center px-2 py-0.5 rounded-full text-xs font-black bg-red-500 text-white animate-pulse">
                        {{ $totalBaru }}
                    </span>
                @endif
            </h1>
            <p class="text-sm text-slate-500 mt-0.5">Pesan dari pengunjung melalui halaman <strong>Hubungi Kami</strong></p>
        </div>

        {{-- Info SMTP jika belum dikonfigurasi --}}
        <div class="flex items-center gap-1.5 px-3 py-2 bg-amber-50 border border-amber-200 rounded-xl text-xs text-amber-700 font-medium">
            <span class="material-symbols-outlined text-base text-amber-500">info</span>
            Email notifikasi aktif — pastikan SMTP dikonfigurasi di <code class="bg-amber-100 px-1 rounded">.env</code>
        </div>
    </div>

    {{-- Filter Tabs --}}
    <div class="flex gap-2 border-b border-slate-200 pb-0">
        @php
            $tabs = [
                ['label' => 'Semua', 'value' => null],
                ['label' => 'Baru', 'value' => 'baru'],
                ['label' => 'Sudah Dibaca', 'value' => 'dibaca'],
            ];
        @endphp
        @foreach($tabs as $tab)
        <a href="{{ route('admin.pesan.index', $tab['value'] ? ['status' => $tab['value']] : []) }}"
           class="px-4 py-2.5 text-sm font-semibold border-b-2 transition-colors -mb-px
           {{ request('status') === $tab['value'] || (!request('status') && !$tab['value'])
               ? 'border-navy-900 text-navy-900'
               : 'border-transparent text-slate-500 hover:text-slate-800 hover:border-slate-300' }}">
            {{ $tab['label'] }}
            @if($tab['value'] === 'baru' && $totalBaru > 0)
                <span class="ml-1 px-1.5 py-0.5 rounded-full text-[10px] font-black bg-red-500 text-white">{{ $totalBaru }}</span>
            @endif
        </a>
        @endforeach
    </div>

    {{-- Tabel / Empty State --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        @if($pesans->isEmpty())
            <div class="flex flex-col items-center justify-center py-24 text-slate-400">
                <span class="material-symbols-outlined text-6xl mb-4 text-slate-300" style="font-variation-settings:'FILL' 1">inbox</span>
                <p class="text-base font-semibold text-slate-500">Belum ada pesan masuk</p>
                <p class="text-sm mt-1">Pesan dari formulir kontak akan muncul di sini secara otomatis.</p>
            </div>
        @else
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-5 py-3.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider w-8"></th>
                        <th class="px-5 py-3.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Pengirim</th>
                        <th class="px-5 py-3.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Subjek</th>
                        <th class="px-5 py-3.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Status</th>
                        <th class="px-5 py-3.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Diterima</th>
                        <th class="px-5 py-3.5 text-right text-[11px] font-bold text-slate-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($pesans as $pesan)
                    <tr class="hover:bg-slate-50/80 transition-colors group {{ $pesan->status === 'baru' ? 'bg-blue-50/30' : '' }}">

                        {{-- Dot indicator --}}
                        <td class="pl-5 py-4">
                            @if($pesan->status === 'baru')
                                <span class="block w-2 h-2 rounded-full bg-red-500 ring-2 ring-red-200"></span>
                            @else
                                <span class="block w-2 h-2 rounded-full bg-slate-200"></span>
                            @endif
                        </td>

                        {{-- Pengirim --}}
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-navy-900 text-white text-xs font-bold flex items-center justify-center shrink-0">
                                    {{ strtoupper(substr($pesan->nama, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-800 leading-tight">{{ $pesan->nama }}</p>
                                    <p class="text-xs text-slate-400 mt-0.5">{{ $pesan->email }}</p>
                                </div>
                            </div>
                        </td>

                        {{-- Subjek --}}
                        <td class="px-4 py-4 max-w-xs">
                            <p class="text-slate-700 font-medium truncate {{ $pesan->status === 'baru' ? 'font-semibold' : '' }}">
                                {{ $pesan->subjek }}
                            </p>
                            <p class="text-xs text-slate-400 mt-0.5 truncate">{{ Str::limit($pesan->pesan, 60) }}</p>
                        </td>

                        {{-- Status --}}
                        <td class="px-4 py-4">
                            @if($pesan->status === 'baru')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Baru
                                </span>
                            @elseif($pesan->status === 'dibaca')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-500">
                                    <span class="material-symbols-outlined text-xs">done</span> Dibaca
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                    <span class="material-symbols-outlined text-xs">done_all</span> Dibalas
                                </span>
                            @endif
                        </td>

                        {{-- Waktu --}}
                        <td class="px-4 py-4">
                            <p class="text-xs text-slate-500">{{ $pesan->created_at->diffForHumans() }}</p>
                            <p class="text-[11px] text-slate-400">{{ $pesan->created_at->format('d M Y') }}</p>
                        </td>

                        {{-- Aksi --}}
                        <td class="px-4 py-4 text-right">
                            <div class="flex items-center justify-end gap-2 opacity-80 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('admin.pesan.show', $pesan) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-navy-900 text-white hover:bg-navy-800 transition-colors">
                                    <span class="material-symbols-outlined text-sm">open_in_new</span>
                                    Baca
                                </a>
                                <form action="{{ route('admin.pesan.destroy', $pesan) }}" method="POST"
                                      onsubmit="return confirm('Hapus pesan dari {{ addslashes($pesan->nama) }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center p-1.5 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition-colors">
                                        <span class="material-symbols-outlined text-base">delete_outline</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Pagination --}}
            @if($pesans->hasPages())
            <div class="px-5 py-4 border-t border-slate-100 flex items-center justify-between">
                <p class="text-xs text-slate-400">
                    Menampilkan {{ $pesans->firstItem() }}–{{ $pesans->lastItem() }} dari {{ $pesans->total() }} pesan
                </p>
                {{ $pesans->links() }}
            </div>
            @else
            <div class="px-5 py-3 border-t border-slate-100">
                <p class="text-xs text-slate-400">Total {{ $pesans->total() }} pesan</p>
            </div>
            @endif
        @endif
    </div>
</div>
@endsection
