@extends('layouts.app')

@section('title', 'Dewan Pakar APPSI 2025–2029')

@section('content')
<div class="max-w-[1200px] mx-auto px-4 md:px-8 py-8 space-y-10">

    <!-- Header & Breadcrumb -->
    <section class="border-b border-border-subtle pb-6">
        <nav class="flex items-center gap-2 mb-2 font-label-caps text-label-caps text-on-surface-variant">
            <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Beranda</a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span>Tentang APPSI</span>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-primary font-bold">Dewan Pakar</span>
        </nav>
        <div>
            <h1 class="font-headline-lg-mobile md:font-headline-lg text-primary">Dewan Pakar APPSI</h1>
            <p class="text-slate-600 text-sm mt-1">Masa Bakti 2025 – 2029</p>
        </div>
    </section>

    <!-- Intro Text Card -->
    <section class="bg-surface-white p-6 md:p-8 rounded-2xl border border-border-subtle shadow-xs">
        <p class="font-body-lg text-body-lg text-on-surface-variant leading-relaxed">
            Dewan Pakar APPSI menghimpun akademisi senior, pakar otonomi daerah, serta praktisi kebijakan publik yang bertugas memberikan kajian independen, pertimbangan akademis, dan rekomendasi strategis dalam perumusan kebijakan pembangunan nasional dan daerah bagi Pemerintah Provinsi se-Indonesia.
        </p>
    </section>

    @php
        $ketua = $anggota->filter(fn($item) => str_contains($item->jabatan, 'Ketua'))->first();
        $anggotaList = $anggota->filter(fn($item) => !str_contains($item->jabatan, 'Ketua'));
    @endphp

    <!-- 1. Ketua Dewan Pakar Highlight Card -->
    @if($ketua)
    <section class="space-y-4">
        <div class="flex items-center gap-3">
            <div class="h-8 w-1.5 bg-secondary rounded-full"></div>
            <h2 class="font-headline-md text-headline-md text-primary font-bold">Ketua Dewan Pakar</h2>
        </div>

        <div class="bg-surface-white rounded-3xl overflow-hidden shadow-sm border border-border-subtle p-6 md:p-8">
            <div class="flex flex-col md:flex-row items-center md:items-stretch gap-6 md:gap-10">
                {{-- Foto Ketua Dewan Pakar --}}
                <div class="w-48 sm:w-56 md:w-64 shrink-0 flex flex-col">
                    <div class="relative rounded-2xl overflow-hidden shadow-md border-2 border-primary/10 bg-slate-100 aspect-[3/4] w-full group">
                        <img src="{{ $ketua->foto_url }}" alt="{{ $ketua->nama }}"
                             class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-500"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                        <div class="hidden w-full h-full items-center justify-center bg-slate-100 text-slate-400">
                            <span class="material-symbols-outlined text-6xl text-secondary">psychology</span>
                        </div>
                    </div>
                </div>

                {{-- Deskripsi & Profil Ketua --}}
                <div class="flex-1 flex flex-col justify-center text-center md:text-left">
                    <span class="inline-block px-3.5 py-1 rounded-full bg-primary text-white text-xs font-bold uppercase tracking-wider w-fit mx-auto md:mx-0 mb-2">
                        Ketua Dewan Pakar APPSI
                    </span>
                    <h3 class="text-2xl md:text-3xl font-extrabold text-primary leading-tight mb-2">
                        {{ $ketua->nama }}
                    </h3>
                    <p class="text-secondary font-bold text-sm mb-4">
                        Pakar Otonomi Daerah &amp; Tata Kelola Pemerintahan
                    </p>

                    <div class="w-16 h-1 bg-secondary rounded-full mb-4 mx-auto md:mx-0"></div>

                    <p class="text-on-surface-variant text-sm md:text-base leading-relaxed mb-4">
                        {{ $ketua->bio ?? 'Guru Besar Institut Pemerintahan Dalam Negeri (IPDN) dan pakar otonomi daerah terkemuka yang berperan penting dalam peletakan dasar kebijakan desentralisasi di Indonesia.' }}
                    </p>

                    <div class="p-4 rounded-xl bg-surface-container-low border-l-4 border-secondary text-left">
                        <p class="text-xs md:text-sm text-primary italic">
                            "Mendorong sinergi antara kebijakan pusat dan daerah melalui pendekatan ilmiah dan kajian yang berorientasi pada kemajuan daerah."
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- 2. Anggota Dewan Pakar Grid -->
    <section class="space-y-4">
        <div class="flex items-center gap-3">
            <div class="h-8 w-1.5 bg-secondary rounded-full"></div>
            <h2 class="font-headline-md text-headline-md text-primary font-bold">Anggota Dewan Pakar</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($anggotaList as $p)
                <div class="bg-surface-white border border-border-subtle rounded-2xl p-6 shadow-xs hover:shadow-md hover:border-primary/20 transition-all duration-300 flex flex-col items-center text-center group">
                    {{-- Foto Anggota --}}
                    <div class="w-28 h-28 rounded-full overflow-hidden border-2 border-secondary/40 group-hover:border-secondary p-1 bg-slate-50 mb-4 shadow-sm transition-colors flex items-center justify-center shrink-0">
                        <img src="{{ $p->foto_url }}" alt="{{ $p->nama }}"
                             class="w-full h-full object-cover object-top rounded-full group-hover:scale-105 transition-transform duration-300"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                        <div class="hidden w-full h-full items-center justify-center bg-slate-100 text-slate-400 rounded-full">
                            <span class="material-symbols-outlined text-4xl text-secondary">person</span>
                        </div>
                    </div>

                    {{-- Nama & Jabatan --}}
                    <h3 class="font-bold text-base text-primary leading-snug mb-1">
                        {{ $p->nama }}
                    </h3>
                    <p class="text-xs font-bold text-secondary uppercase tracking-wide mb-3">
                        {{ $p->jabatan }}
                    </p>

                    {{-- Bio / Keahlian --}}
                    @if($p->bio)
                        <p class="text-xs text-on-surface-variant leading-relaxed line-clamp-3 mt-auto pt-2 border-t border-slate-100 w-full">
                            {{ $p->bio }}
                        </p>
                    @endif
                </div>
            @empty
                <div class="col-span-full text-center text-slate-400 py-12">
                    Belum ada data Anggota Dewan Pakar.
                </div>
            @endforelse
        </div>
    </section>

    <!-- 3. Peran dan Kontribusi Dewan Pakar (Sesuai Resmi appsi.or.id) -->
    <section class="bg-surface-container-low rounded-3xl p-6 md:p-8 space-y-6">
        <div class="max-w-3xl mx-auto text-center">
            <span class="text-xs font-bold text-secondary uppercase tracking-widest block mb-1">Peran Strategis</span>
            <h2 class="text-xl md:text-2xl font-bold text-primary">Peran dan Kontribusi Dewan Pakar</h2>
            <div class="w-12 h-1 bg-secondary mx-auto rounded-full mt-2 mb-4"></div>
            <p class="text-on-surface-variant text-sm">Dewan Pakar APPSI memiliki peran strategis dalam:</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-surface-white p-5 rounded-2xl border border-border-subtle shadow-2xs flex flex-col gap-2">
                <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary mb-1">
                    <span class="material-symbols-outlined text-2xl">policy</span>
                </div>
                <h4 class="font-bold text-sm text-primary">Kajian &amp; Rekomendasi</h4>
                <p class="text-xs text-on-surface-variant leading-relaxed">Memberikan kajian dan rekomendasi kebijakan kepada Dewan Pengurus APPSI.</p>
            </div>

            <div class="bg-surface-white p-5 rounded-2xl border border-border-subtle shadow-2xs flex flex-col gap-2">
                <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary mb-1">
                    <span class="material-symbols-outlined text-2xl">psychology</span>
                </div>
                <h4 class="font-bold text-sm text-primary">Perspektif Akademis</h4>
                <p class="text-xs text-on-surface-variant leading-relaxed">Menyediakan perspektif akademis dan profesional terhadap isu-isu strategis pemerintahan daerah.</p>
            </div>

            <div class="bg-surface-white p-5 rounded-2xl border border-border-subtle shadow-2xs flex flex-col gap-2">
                <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary mb-1">
                    <span class="material-symbols-outlined text-2xl">account_balance</span>
                </div>
                <h4 class="font-bold text-sm text-primary">Sikap Resmi APPSI</h4>
                <p class="text-xs text-on-surface-variant leading-relaxed">Mendukung perumusan sikap dan pandangan resmi APPSI terhadap kebijakan nasional.</p>
            </div>

            <div class="bg-surface-white p-5 rounded-2xl border border-border-subtle shadow-2xs flex flex-col gap-2">
                <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary mb-1">
                    <span class="material-symbols-outlined text-2xl">lightbulb</span>
                </div>
                <h4 class="font-bold text-sm text-primary">Kebijakan Berbasis Bukti</h4>
                <p class="text-xs text-on-surface-variant leading-relaxed">Mendorong pengembangan gagasan inovatif dan berbasis bukti (evidence-based policy) dalam penyelenggaraan pemerintahan provinsi.</p>
            </div>
        </div>
    </section>

</div>
@endsection
