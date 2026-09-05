@extends('layouts.admin')

@section('title', 'Detail Pesan')
@section('subtitle', 'Baca & kelola pesan masuk dari pengunjung')

@section('content')
<div class="space-y-5">

    {{-- Breadcrumb / Back --}}
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.pesan.index') }}"
           class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-500 hover:text-navy-900 transition-colors group">
            <span class="material-symbols-outlined text-lg group-hover:-translate-x-0.5 transition-transform">arrow_back</span>
            Kembali ke Inbox
        </a>
        <span class="text-xs text-slate-400 bg-slate-100 px-3 py-1 rounded-full font-medium">Pesan #{{ $pesan->id }}</span>
    </div>

    {{-- 2-Column Layout --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 items-start">

        {{-- ══ KOLOM KIRI: Isi Pesan (2/3) ══ --}}
        <div class="lg:col-span-2 space-y-4">

            {{-- Subjek Header --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="bg-gradient-to-r from-navy-900 via-navy-800 to-navy-700 px-6 py-5">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-xs font-semibold text-white/50 uppercase tracking-widest mb-1">Subjek</p>
                            <h1 class="text-xl font-bold text-white leading-snug">{{ $pesan->subjek }}</h1>
                        </div>
                        @if($pesan->status === 'baru')
                            <span class="shrink-0 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-red-500 text-white">
                                <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>Baru
                            </span>
                        @elseif($pesan->status === 'dibaca')
                            <span class="shrink-0 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-white/15 text-white/80">
                                <span class="material-symbols-outlined text-xs">mark_email_read</span>Dibaca
                            </span>
                        @else
                            <span class="shrink-0 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-green-500/30 text-green-200">
                                <span class="material-symbols-outlined text-xs">done_all</span>Dibalas
                            </span>
                        @endif
                    </div>

                    <div class="flex flex-wrap items-center gap-x-5 gap-y-1 mt-4 pt-4 border-t border-white/10 text-xs text-white/55">
                        <span class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-sm">schedule</span>
                            {{ $pesan->created_at->format('d M Y, H:i') }} WIB
                        </span>
                        <span class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-sm">history</span>
                            {{ $pesan->created_at->diffForHumans() }}
                        </span>
                    </div>
                </div>

                {{-- Isi Pesan --}}
                <div class="px-6 py-6">
                    <p class="text-[11px] font-bold tracking-widest uppercase text-slate-400 mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-base">chat</span>Isi Pesan
                    </p>
                    <div class="text-slate-700 text-[15px] leading-relaxed whitespace-pre-wrap min-h-[180px]">{{ $pesan->pesan }}</div>
                </div>

                {{-- Action Bar --}}
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex items-center gap-3 flex-wrap">
                    <a href="https://mail.google.com/mail/?view=cm&fs=1&to={{ urlencode($pesan->email) }}&su={{ urlencode('Re: ' . $pesan->subjek) }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold bg-navy-900 text-white hover:bg-navy-800 transition-all hover:shadow-lg hover:shadow-navy-900/25 active:scale-[0.98]">
                        <span class="material-symbols-outlined text-base">outgoing_mail</span>
                        Balas via Gmail
                        <span class="material-symbols-outlined text-xs opacity-60">open_in_new</span>
                    </a>
                    <a href="{{ route('admin.pesan.index') }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold bg-white border border-slate-200 text-slate-600 hover:bg-slate-100 transition-colors">
                        <span class="material-symbols-outlined text-base">inbox</span>
                        Pesan Lainnya
                    </a>
                    <div class="ml-auto">
                        <form action="{{ route('admin.pesan.destroy', $pesan) }}" method="POST"
                              onsubmit="return confirm('Hapus pesan ini secara permanen?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-red-600 bg-red-50 hover:bg-red-100 border border-red-100 transition-colors">
                                <span class="material-symbols-outlined text-base">delete</span>
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- ══ KOLOM KANAN: Info Pengirim (1/3) ══ --}}
        <div class="space-y-4">

            {{-- Kartu Pengirim --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100">
                    <p class="text-[11px] font-bold tracking-widest uppercase text-slate-400">Dari Pengirim</p>
                </div>
                <div class="px-5 py-5 flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-navy-900 text-white text-2xl font-black flex items-center justify-center shrink-0 shadow-md shadow-navy-900/20">
                        {{ strtoupper(substr($pesan->nama, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="font-bold text-slate-800 truncate">{{ $pesan->nama }}</p>
                        <a href="https://mail.google.com/mail/?view=cm&fs=1&to={{ urlencode($pesan->email) }}&su={{ urlencode('Re: ' . $pesan->subjek) }}"
                           target="_blank"
                           rel="noopener noreferrer"
                           title="Buka di Gmail Web"
                           class="text-sm text-navy-700 hover:text-amber-600 hover:underline inline-flex items-center gap-1 mt-0.5 truncate max-w-full">
                            <span class="truncate">{{ $pesan->email }}</span>
                            <span class="material-symbols-outlined text-[13px] text-slate-400 shrink-0">open_in_new</span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Info Detail --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100">
                    <p class="text-[11px] font-bold tracking-widest uppercase text-slate-400">Informasi Pesan</p>
                </div>
                <div class="px-5 py-4 space-y-3.5">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-slate-500 flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-base text-slate-400">tag</span>ID
                        </span>
                        <span class="font-semibold text-slate-700">#{{ $pesan->id }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-slate-500 flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-base text-slate-400">circle</span>Status
                        </span>
                        @if($pesan->status === 'baru')
                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-700">Baru</span>
                        @elseif($pesan->status === 'dibaca')
                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">Dibaca</span>
                        @else
                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-700">Dibalas</span>
                        @endif
                    </div>
                    <div class="flex items-start justify-between text-sm gap-2">
                        <span class="text-slate-500 flex items-center gap-1.5 shrink-0">
                            <span class="material-symbols-outlined text-base text-slate-400">calendar_today</span>Masuk
                        </span>
                        <span class="font-medium text-slate-700 text-right text-xs">{{ $pesan->created_at->format('d M Y') }}<br>{{ $pesan->created_at->format('H:i') }} WIB</span>
                    </div>
                </div>
            </div>

            {{-- Tips --}}
            <div class="bg-amber-50 border border-amber-100 rounded-2xl px-5 py-4">
                <div class="flex items-start gap-3">
                    <span class="material-symbols-outlined text-amber-500 text-xl shrink-0" style="font-variation-settings:'FILL' 1">lightbulb</span>
                    <div>
                        <p class="text-xs font-bold text-amber-800 mb-1">Cara membalas pesan</p>
                        <p class="text-xs text-amber-700 leading-relaxed">Klik tombol <strong>Balas via Gmail</strong> untuk langsung membuka tab Gmail Web dengan alamat <strong>{{ $pesan->email }}</strong> dan subjek yang terisi otomatis.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
