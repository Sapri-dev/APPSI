@extends('layouts.app')

@section('title', 'Dewan Pengurus ' . ($appsiPeriode ?? '') . ' - APPSI')

@section('content')
<div class="max-w-max-width-content mx-auto px-4 md:px-8 py-8 space-y-10">

    <!-- Header & Breadcrumb -->
    <section class="border-b border-border-subtle pb-6">
        <nav class="flex items-center gap-2 mb-2 font-label-caps text-label-caps text-on-surface-variant">
            <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Beranda</a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span>Tentang APPSI</span>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-primary font-bold">Dewan Pengurus</span>
        </nav>
        <h1 class="font-headline-lg-mobile md:font-headline-lg text-primary">Dewan Pengurus</h1>
        <p class="text-slate-600 text-sm mt-1">Masa Bakti {{ $appsiPeriode }}</p>
    </section>

    <!-- Intro Text -->
    <section class="bg-surface-white p-6 rounded-2xl border border-border-subtle shadow-xs">
        <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
            Sesuai dengan hasil Musyawarah Nasional APPSI VII, telah ditetapkan susunan Dewan Pengurus Asosiasi Pemerintah Provinsi Seluruh Indonesia (APPSI) Masa Bakti {{ $appsiPeriode }}. Struktur ini dirancang untuk memperkuat sinergi antar pemerintah provinsi dalam mewujudkan tata kelola pemerintahan yang responsif, inovatif, dan berintegritas demi kemajuan Indonesia.
        </p>
    </section>

    @php
        $ketum  = $anggota->where('jabatan', 'Ketua Umum')->first() ?: $anggota->first();
        $wakil  = $anggota->where('jabatan', 'Wakil Ketua Umum')->first();
        $sekjen = $anggota->where('jabatan', 'Sekretaris Jenderal')->first();

        $pimpinanIds = array_filter([$ketum?->id, $wakil?->id, $sekjen?->id]);

        $korwil = $anggota->filter(function($i) {
            $j = strtolower($i->jabatan);
            return str_contains($j, 'koordinator') || str_contains($j, 'korwil');
        });
        $korwilIds = $korwil->pluck('id')->toArray();

        $jajaranPengurus = $anggota->reject(function($i) use ($pimpinanIds, $korwilIds) {
            return in_array($i->id, $pimpinanIds) || in_array($i->id, $korwilIds);
        });
    @endphp

    <!-- Leadership Section: Primary -->
    <section class="space-y-6">
        <div class="flex items-center gap-2 mb-4">
            <div class="h-8 w-1.5 bg-secondary rounded-full"></div>
            <h2 class="font-headline-sm text-headline-sm text-primary">Pimpinan Utama</h2>
        </div>

        {{-- Ketua Umum (Refined Prominent Executive Card) --}}
        @if($ketum)
        <div class="bg-primary text-white rounded-3xl overflow-hidden shadow-lg border border-primary/20 p-6 md:p-8">
            <div class="flex flex-col md:flex-row items-center md:items-stretch gap-6 md:gap-10">
                {{-- Foto Ketua Umum (Framed 3:4) --}}
                <div class="w-48 sm:w-56 md:w-60 shrink-0 flex flex-col">
                    <div class="relative rounded-2xl overflow-hidden shadow-xl border-2 border-white/20 bg-slate-900 aspect-[3/4] w-full group">
                        <img src="{{ $ketum->foto_url }}" alt="{{ $ketum->nama }}"
                             class="w-full h-full object-cover object-top grayscale-0 group-hover:scale-105 transition-transform duration-500"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'"/>
                        <div class="hidden w-full h-full items-center justify-center bg-slate-800 text-slate-400">
                            <span class="material-symbols-outlined text-6xl text-secondary">person</span>
                        </div>
                    </div>
                </div>

                {{-- Detail & Visi Ketua Umum --}}
                <div class="flex-1 flex flex-col justify-center text-center md:text-left space-y-3">
                    <span class="inline-block px-3.5 py-1 rounded-full bg-secondary/20 text-amber-300 text-xs font-bold uppercase tracking-wider w-fit mx-auto md:mx-0 border border-secondary/30">
                        Ketua Umum APPSI
                    </span>
                    <div>
                        <h3 class="text-2xl md:text-3xl font-extrabold text-white leading-tight">
                            {{ $ketum->nama }}
                        </h3>
                        <p class="text-amber-300 font-bold text-sm md:text-base mt-1">
                            {{ $ketum->provinsi ? 'Gubernur ' . $ketum->provinsi : '' }}
                        </p>
                    </div>

                    <div class="w-16 h-1 bg-secondary rounded-full mx-auto md:mx-0"></div>

                    <div class="p-4 rounded-xl bg-white/5 border-l-4 border-secondary text-left mt-2">
                        <p class="text-xs md:text-sm text-slate-200 italic leading-relaxed">
                            "Membangun kolaborasi strategis antar provinsi untuk kemandirian ekonomi daerah yang berkelanjutan."
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Wakil & Sekjen (Side by Side Horizontal Cards) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @if($wakil)
            <div class="bg-surface-white border border-border-subtle rounded-2xl p-6 shadow-xs flex items-center gap-5 hover:shadow-md hover:border-primary/20 transition-all duration-300">
                <div class="w-28 sm:w-32 h-36 sm:h-40 shrink-0 rounded-xl overflow-hidden bg-slate-100 border border-border-subtle shadow-2xs flex items-center justify-center">
                    <img src="{{ $wakil->foto_url }}" alt="{{ $wakil->nama }}"
                         class="w-full h-full object-cover object-top"
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'"/>
                    <div class="hidden w-full h-full items-center justify-center bg-slate-100 text-slate-400">
                        <span class="material-symbols-outlined text-5xl text-secondary">person</span>
                    </div>
                </div>
                <div class="space-y-1.5 flex-1">
                    <span class="text-xs font-bold text-secondary uppercase tracking-wider block">{{ $wakil->jabatan }}</span>
                    <h4 class="text-lg sm:text-xl font-bold text-primary leading-snug">{{ $wakil->nama }}</h4>
                    <p class="text-xs sm:text-sm text-on-surface-variant font-medium">{{ $wakil->provinsi ? 'Gubernur ' . $wakil->provinsi : '' }}</p>
                </div>
            </div>
            @endif

            @if($sekjen)
            <div class="bg-surface-white border border-border-subtle rounded-2xl p-6 shadow-xs flex items-center gap-5 hover:shadow-md hover:border-primary/20 transition-all duration-300">
                <div class="w-28 sm:w-32 h-36 sm:h-40 shrink-0 rounded-xl overflow-hidden bg-slate-100 border border-border-subtle shadow-2xs flex items-center justify-center">
                    <img src="{{ $sekjen->foto_url }}" alt="{{ $sekjen->nama }}"
                         class="w-full h-full object-cover object-top"
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'"/>
                    <div class="hidden w-full h-full items-center justify-center bg-slate-100 text-slate-400">
                        <span class="material-symbols-outlined text-5xl text-secondary">person</span>
                    </div>
                </div>
                <div class="space-y-1.5 flex-1">
                    <span class="text-xs font-bold text-secondary uppercase tracking-wider block">{{ $sekjen->jabatan }}</span>
                    <h4 class="text-lg sm:text-xl font-bold text-primary leading-snug">{{ $sekjen->nama }}</h4>
                    <p class="text-xs sm:text-sm text-on-surface-variant font-medium">{{ $sekjen->provinsi ? 'Gubernur ' . $sekjen->provinsi : '' }}</p>
                </div>
            </div>
            @endif
        </div>
    </section>

    <!-- Board Members Section (Jajaran Pengurus: 5 Kolom) -->
    @if($jajaranPengurus->isNotEmpty())
    <section class="space-y-6">
        <div class="flex items-center gap-2 mb-4">
            <div class="h-8 w-1.5 bg-secondary rounded-full"></div>
            <h2 class="font-headline-sm text-headline-sm text-primary">Jajaran Pengurus</h2>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
            @foreach($jajaranPengurus as $p)
            <div class="bg-surface-white border border-border-subtle p-3.5 rounded-2xl flex flex-col gap-3 group hover:shadow-md transition-all">
                <div class="aspect-[0.79] rounded-xl overflow-hidden bg-slate-100 flex items-center justify-center">
                    <img src="{{ $p->foto_url }}" alt="{{ $p->nama }}"
                         class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-300"
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'"/>
                    <div class="hidden w-full h-full items-center justify-center bg-slate-100 text-slate-400">
                        <span class="material-symbols-outlined text-4xl text-secondary">person</span>
                    </div>
                </div>
                <div>
                    <span class="text-[11px] font-bold text-secondary uppercase block mb-1">{{ $p->jabatan }}</span>
                    <h4 class="text-[14px] font-bold text-primary leading-tight">{{ $p->nama }}</h4>
                    <p class="text-[12px] text-on-surface-variant mt-0.5">{{ $p->provinsi ? 'Gubernur ' . $p->provinsi : '' }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- Regional Coordinators (Koordinator Wilayah) -->
    @if($korwil->isNotEmpty())
    <section class="space-y-6 bg-surface-container-low p-6 md:p-8 rounded-3xl border border-border-subtle">
        <div class="flex items-center gap-2 mb-2">
            <div class="h-8 w-1.5 bg-primary rounded-full"></div>
            <h2 class="font-headline-sm text-headline-sm text-primary">Koordinator Wilayah</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($korwil as $p)
            <div class="bg-surface-white p-5 rounded-2xl border border-border-subtle flex items-start gap-4 shadow-xs hover:shadow-md transition-shadow">
                <div class="w-20 h-24 flex-shrink-0 overflow-hidden rounded-xl bg-slate-100 border border-slate-100 flex items-center justify-center">
                    <img src="{{ $p->foto_url }}" alt="{{ $p->nama }}"
                         class="w-full h-full object-cover object-top"
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'"/>
                    <div class="hidden w-full h-full items-center justify-center bg-slate-100 text-slate-400">
                        <span class="material-symbols-outlined text-3xl text-secondary">person</span>
                    </div>
                </div>
                <div class="space-y-1 flex-1">
                    <span class="text-[10px] font-extrabold text-secondary tracking-wider uppercase block">{{ $p->jabatan }}</span>
                    <h4 class="font-bold text-sm text-primary leading-tight">{{ $p->nama }}</h4>
                    <p class="text-[12px] text-on-surface-variant">{{ $p->provinsi ? 'Gubernur ' . $p->provinsi : '' }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

</div>
@endsection

