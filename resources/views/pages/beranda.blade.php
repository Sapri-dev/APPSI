@extends('layouts.app')

@section('title', 'Beranda - APPSI')

@section('content')
<!-- Hero News & Featured Slider -->
<section class="relative w-full px-4 mt-4 max-w-[1200px] mx-auto"
         x-data="{
             active: 0,
             total: {{ count($sliderBerita) > 0 ? count($sliderBerita) : 1 }},
             timer: null,
             next() {
                 this.active = (this.active + 1) % this.total;
             },
             prev() {
                 this.active = (this.active - 1 + this.total) % this.total;
             },
             start() {
                 this.stop();
                 this.timer = setInterval(() => { this.next(); }, 5000);
             },
             stop() {
                 if (this.timer) clearInterval(this.timer);
             },
             goTo(index) {
                 this.active = index;
                 this.start();
             }
         }"
         x-init="start()"
         @mouseenter="stop()"
         @mouseleave="start()">
    
    <div class="relative w-full rounded-2xl overflow-hidden shadow-2xl bg-[#001647] aspect-[16/9] min-h-[260px] md:min-h-[420px] lg:min-h-[460px]">
        @forelse($sliderBerita as $index => $item)
            <div x-cloak
                 x-show="active === {{ $index }}"
                 x-transition:enter="transition ease-out duration-700"
                 x-transition:enter-start="opacity-0 scale-105"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-500 absolute inset-0"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute inset-0 w-full h-full">
                
                <!-- Slide Background Image -->
                <img src="{{ $item->gambar_url }}"
                     alt="{{ $item->judul }}"
                     class="w-full h-full object-cover"
                     onerror="this.src='{{ asset('images/placeholder-berita.jpg') }}'">
                
                <!-- Soft Navy Gradient Overlay focused on text area -->
                <div class="absolute inset-0 bg-gradient-to-t from-[#001647]/95 via-[#001647]/40 via-35% to-transparent"></div>

                <!-- Slide Content Overlay (News Info & CTA) -->
                <div class="absolute inset-0 flex flex-col justify-end p-5 md:p-10 lg:p-12 max-w-3xl z-10">
                    <!-- Badges & Date -->
                    <div class="flex items-center gap-2 mb-2 flex-wrap">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-amber-500 text-slate-950 shadow-sm">
                            <span class="material-symbols-outlined text-[14px]">newspaper</span>
                            {{ $item->kategori ?? 'BERITA APPSI' }}
                        </span>
                        @if($item->tanggal_publikasi)
                            <span class="text-xs text-slate-200/90 flex items-center gap-1 font-medium bg-black/40 backdrop-blur-sm px-2.5 py-1 rounded-full border border-white/10">
                                <span class="material-symbols-outlined text-[13px]">calendar_today</span>
                                {{ $item->tanggal_publikasi->translatedFormat('d F Y') }}
                            </span>
                        @endif
                    </div>

                    <!-- News Title -->
                    <a href="{{ route('artikel', $item->slug) }}" class="group block">
                        <h2 class="text-lg sm:text-2xl md:text-3xl lg:text-4xl font-bold text-white leading-tight line-clamp-2 group-hover:text-amber-400 transition-colors drop-shadow-md">
                            {{ $item->judul }}
                        </h2>
                    </a>

                    <!-- News Summary -->
                    @if($item->ringkasan || $item->konten)
                        <p class="hidden sm:block text-slate-200/90 text-xs md:text-sm mt-2 line-clamp-2 leading-relaxed max-w-2xl">
                            {{ Str::limit(strip_tags($item->ringkasan ?: $item->konten), 140) }}
                        </p>
                    @endif

                    <!-- CTA Button -->
                    <div class="mt-4 flex items-center gap-3">
                        <a href="{{ route('artikel', $item->slug) }}"
                           class="inline-flex items-center gap-2 px-4 py-2 md:px-5 md:py-2.5 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-bold text-xs md:text-sm shadow-lg hover:shadow-amber-500/20 active:scale-95 transition-all">
                            <span>Baca Selengkapnya</span>
                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="relative w-full h-full">
                <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuBKN6XRe6dFjEBfPyUa68Lh9xfD3hPZQjyu6bB-yvMcVe_FmbyG-TNhwNFbcbuZ-RVbU7l0rZN0PO7tDYaklP67e3FV3bV4D49A7L1DosqL52GU37_r9AP21inDyRYdqoTHAtcjb6Z3I_SG-Hni81PyfErYrmQsV4VWW_KBjFDgPjLrFN6cXw7wcvVk4hXxCo8Im5riWzJQLL21_QaDdKVl3EdkLl-G5Cz4Ic8W_J0HhZoYqZcARj5qoQHD-Mw3MUoC9tS2oI4mL6A"
                     alt="APPSI" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-[#001647]/90 to-transparent flex items-end p-8">
                    <h2 class="text-2xl font-bold text-white">Selamat Datang di Portal Resmi APPSI</h2>
                </div>
            </div>
        @endforelse

        <!-- Left / Right Navigation Arrows -->
        <div class="absolute inset-y-0 left-3 md:left-5 flex items-center z-20">
            <button @click.prevent="prev(); start();"
                    aria-label="Slide Sebelumnya"
                    class="w-9 h-9 md:w-11 md:h-11 rounded-full bg-black/40 hover:bg-black/70 backdrop-blur-md text-white flex items-center justify-center border border-white/20 transition-all active:scale-90 hover:scale-105 cursor-pointer">
                <span class="material-symbols-outlined text-lg md:text-xl">chevron_left</span>
            </button>
        </div>
        <div class="absolute inset-y-0 right-3 md:right-5 flex items-center z-20">
            <button @click.prevent="next(); start();"
                    aria-label="Slide Selanjutnya"
                    class="w-9 h-9 md:w-11 md:h-11 rounded-full bg-black/40 hover:bg-black/70 backdrop-blur-md text-white flex items-center justify-center border border-white/20 transition-all active:scale-90 hover:scale-105 cursor-pointer">
                <span class="material-symbols-outlined text-lg md:text-xl">chevron_right</span>
            </button>
        </div>

        <!-- Navigation Dots -->
        <div class="absolute bottom-4 right-4 md:bottom-6 md:right-8 flex items-center gap-1.5 z-20 bg-black/30 backdrop-blur-md px-3 py-1.5 rounded-full border border-white/10">
            @foreach($sliderBerita as $index => $item)
                <button @click.prevent="goTo({{ $index }})"
                        :class="active === {{ $index }} ? 'w-6 bg-amber-400' : 'w-2 bg-white/50 hover:bg-white/80'"
                        class="h-2 rounded-full transition-all duration-300 cursor-pointer"
                        aria-label="Pilih Slide {{ $index + 1 }}"></button>
            @endforeach
        </div>
    </div>
</section>

<!-- Quick Stats / Kutipan Tokoh -->
<section class="px-4 mt-6 max-w-[1200px] mx-auto">
    <div class="bg-surface-container-low border-l-4 border-secondary p-8 rounded-xl shadow-sm">
        <div class="flex flex-col gap-4">
            <span class="material-symbols-outlined text-secondary/40 text-4xl">format_quote</span>
            <p class="font-headline-sm text-headline-sm text-primary italic leading-relaxed">
                "{{ $pengaturan['quote_teks'] ?? '' }}"
            </p>
            <div class="flex items-center gap-3 mt-2">
                <div class="w-8 h-px bg-outline-variant"></div>
                <p class="font-label-caps text-label-caps text-on-surface-variant font-bold uppercase tracking-wider">
                    {{ $pengaturan['quote_tokoh'] ?? '' }}
                </p>
                @if(!empty($pengaturan['quote_sub']))
                    <span class="text-xs text-slate-500 font-medium">— {{ $pengaturan['quote_sub'] }}</span>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Tentang APPSI -->
<section class="py-stack-lg px-4 max-w-[1200px] mx-auto flex flex-col gap-6">
    <div class="flex flex-col gap-2.5">
        <h2 class="font-headline-md text-headline-md text-primary font-bold">Mengenal APPSI</h2>
        <div class="w-12 h-1 bg-secondary rounded-full"></div>
    </div>

    {{-- Banner Split Profile - Selaras dengan Card Tema Website --}}
    <div class="bg-surface-white rounded-3xl overflow-hidden shadow-sm border border-border-subtle p-6 md:p-10">
        <div class="flex flex-col lg:flex-row items-center lg:items-stretch gap-8 lg:gap-12">

            {{-- Kolom Kiri: Foto Resmi Ketua Umum (Utuh & Proporsional) --}}
            <div class="w-full sm:w-72 lg:w-80 shrink-0 flex flex-col">
                <div class="relative rounded-2xl overflow-hidden shadow-md border border-border-subtle bg-slate-100 aspect-[3/4] w-full group">
                    <img src="{{ $pengaturan['foto_ketua_url'] ?? asset('storage/pengurus/kaltim.jpg') }}"
                         alt="Ketua Umum APPSI - {{ $pengaturan['ketua_umum'] ?? '' }}"
                         class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-500"
                         onerror="this.src='{{ asset('storage/pengurus/kaltim.jpg') }}'">
                    <div class="hidden w-full h-full items-center justify-center bg-slate-200">
                        <span class="material-symbols-outlined text-secondary text-6xl">person</span>
                    </div>

                    {{-- Plakat Nama di Bawah Foto (Navy & Gold Accent) --}}
                    <div class="absolute bottom-0 inset-x-0 p-4"
                         style="background: linear-gradient(to top, rgba(0,22,71,0.95) 0%, rgba(0,22,71,0.8) 65%, transparent 100%);">
                        <p class="text-[10px] font-black tracking-widest text-secondary uppercase mb-0.5">
                            KETUA UMUM APPSI {{ !empty($pengaturan['periode']) ? $pengaturan['periode'] : $appsiPeriode }}
                        </p>
                        <p class="text-sm md:text-base font-bold text-white leading-tight">
                            {{ $pengaturan['ketua_umum'] ?? '' }}
                        </p>
                        <p class="text-[11px] text-slate-200 font-medium mt-0.5">
                            {{ $pengaturan['ketua_provinsi'] ?? '' }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Informasi & Deskripsi APPSI --}}
            <div class="flex-1 flex flex-col justify-center">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-secondary/15 border border-secondary/20 text-primary text-xs font-bold w-fit mb-3.5">
                    <span class="w-2 h-2 rounded-full bg-secondary"></span>
                    <span>{{ $pengaturan['sambutan_badge'] ?? '' }}</span>
                </div>

                <h3 class="text-2xl sm:text-3xl font-headline-md text-headline-md text-primary font-bold leading-tight mb-2">
                    {{ $pengaturan['sambutan_judul'] ?? '' }}
                </h3>

                <div class="w-16 h-1 bg-secondary rounded-full mb-5"></div>

                <div class="space-y-4 text-on-surface-variant text-base md:text-[17px] leading-relaxed font-normal">
                    @php
                        $rawTeksSambutan = $pengaturan['sambutan_teks'] ?? '';
                        $paragrafSambutan = array_values(array_filter(explode("\n", str_replace("\r", "", $rawTeksSambutan))));
                    @endphp
                    @foreach($paragrafSambutan as $paragraf)
                        @if(trim($paragraf) !== '')
                            <p>{{ trim($paragraf) }}</p>
                        @endif
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Visi & Misi -->
<section id="visi-misi" class="bg-surface-container-low py-stack-lg px-4">
    <div class="max-w-[1200px] mx-auto">
        <div class="bg-secondary-fixed/30 p-8 rounded-2xl border border-secondary/20 mb-8">
            <span class="font-label-caps text-label-caps text-secondary mb-2 block uppercase">Visi APPSI</span>
            <p class="font-headline-md text-headline-md text-primary leading-tight">{{ $pengaturan['visi'] ?? '' }}</p>
        </div>
        <h3 class="font-headline-sm text-headline-sm text-primary mb-4">Misi Utama</h3>
        @php
            $rawMisi = $pengaturan['misi'] ?? '';
            $misiItems = array_values(array_filter(explode("\n", str_replace("\r", "", $rawMisi))));
            $misiIcons = ['handshake', 'sync_alt', 'trending_up', 'campaign', 'groups', 'verified', 'hub'];
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($misiItems as $mIdx => $mText)
            <div class="bg-surface-white border border-border-subtle p-6 rounded-xl flex flex-col justify-start">
                <span class="material-symbols-outlined text-primary mb-3 text-3xl">{{ $misiIcons[$mIdx % count($misiIcons)] }}</span>
                <p class="font-body-md text-body-md font-bold text-primary mb-1">Misi {{ $mIdx + 1 }}</p>
                <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">{{ trim($mText) }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Peran & Fungsi -->
<section class="py-stack-lg px-4 bg-surface-container-lowest">
    <div class="max-w-[1200px] mx-auto">
        {{-- Section Header --}}
        <div class="text-center mb-10">
            <span class="inline-block font-label-caps text-label-caps text-secondary uppercase tracking-widest mb-2">Peran dan Fungsi APPSI</span>
            <h2 class="font-headline-md text-headline-md text-primary">Peran &amp; Fungsi</h2>
            <p class="font-body-lg text-body-lg text-on-surface-variant mt-2">Kontribusi APPSI bagi Pemerintah Provinsi</p>
            <div class="w-16 h-1 bg-secondary mx-auto mt-4"></div>
        </div>

        {{-- 4-column grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- Koordinasi Nasional --}}
            <div class="group bg-surface-white border border-border-subtle rounded-2xl p-6 hover:shadow-lg hover:border-primary/20 transition-all duration-300 flex flex-col items-start">
                <div class="w-14 h-14 rounded-xl bg-primary/10 flex items-center justify-center mb-4 group-hover:bg-primary/20 transition-colors duration-300">
                    <span class="material-symbols-outlined text-primary text-3xl">hub</span>
                </div>
                <h3 class="font-headline-sm text-headline-sm text-primary mb-2">{{ $pengaturan['peran_1_judul'] ?? '' }}</h3>
                <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">{{ $pengaturan['peran_1_deskripsi'] ?? '' }}</p>
            </div>

            {{-- Advokasi Kebijakan --}}
            <div class="group bg-surface-white border border-border-subtle rounded-2xl p-6 hover:shadow-lg hover:border-primary/20 transition-all duration-300 flex flex-col items-start">
                <div class="w-14 h-14 rounded-xl bg-primary/10 flex items-center justify-center mb-4 group-hover:bg-primary/20 transition-colors duration-300">
                    <span class="material-symbols-outlined text-primary text-3xl">policy</span>
                </div>
                <h3 class="font-headline-sm text-headline-sm text-primary mb-2">{{ $pengaturan['peran_2_judul'] ?? '' }}</h3>
                <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">{{ $pengaturan['peran_2_deskripsi'] ?? '' }}</p>
            </div>

            {{-- Penguatan Kapasitas --}}
            <div class="group bg-surface-white border border-border-subtle rounded-2xl p-6 hover:shadow-lg hover:border-primary/20 transition-all duration-300 flex flex-col items-start">
                <div class="w-14 h-14 rounded-xl bg-primary/10 flex items-center justify-center mb-4 group-hover:bg-primary/20 transition-colors duration-300">
                    <span class="material-symbols-outlined text-primary text-3xl">school</span>
                </div>
                <h3 class="font-headline-sm text-headline-sm text-primary mb-2">{{ $pengaturan['peran_3_judul'] ?? '' }}</h3>
                <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">{{ $pengaturan['peran_3_deskripsi'] ?? '' }}</p>
            </div>

            {{-- Sinergi Pembangunan --}}
            <div class="group bg-surface-white border border-border-subtle rounded-2xl p-6 hover:shadow-lg hover:border-primary/20 transition-all duration-300 flex flex-col items-start">
                <div class="w-14 h-14 rounded-xl bg-primary/10 flex items-center justify-center mb-4 group-hover:bg-primary/20 transition-colors duration-300">
                    <span class="material-symbols-outlined text-primary text-3xl">diversity_3</span>
                </div>
                <h3 class="font-headline-sm text-headline-sm text-primary mb-2">{{ $pengaturan['peran_4_judul'] ?? '' }}</h3>
                <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">{{ $pengaturan['peran_4_deskripsi'] ?? '' }}</p>
            </div>
        </div>
    </div>
</section>

<!-- Program Utama -->
<section class="py-stack-lg px-4 bg-surface-container-low">
    <div class="max-w-[1200px] mx-auto">
        {{-- Section Header --}}
        <div class="text-center mb-10">
            <span class="inline-block font-label-caps text-label-caps text-secondary uppercase tracking-widest mb-2">Program Strategis APPSI</span>
            <h2 class="font-headline-md text-headline-md text-primary">Program Utama</h2>
            <p class="font-body-lg text-body-lg text-on-surface-variant mt-2">Inisiatif strategis yang dijalankan APPSI</p>
            <div class="w-16 h-1 bg-secondary mx-auto mt-4"></div>
        </div>

        {{-- 3-column grid --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Rapat Koordinasi Nasional --}}
            <div class="group bg-surface-white border border-border-subtle rounded-2xl p-8 hover:shadow-lg hover:border-primary/20 transition-all duration-300 flex flex-col items-start shadow-xs">
                <div class="w-16 h-16 rounded-2xl bg-secondary/15 flex items-center justify-center mb-5 group-hover:scale-110 group-hover:bg-secondary transition-all duration-300">
                    <span class="material-symbols-outlined text-secondary group-hover:text-white text-3xl transition-colors duration-300">forum</span>
                </div>
                <h3 class="font-headline-sm text-headline-sm text-primary mb-3">{{ $pengaturan['program_1_judul'] ?? '' }}</h3>
                <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">{{ $pengaturan['program_1_deskripsi'] ?? '' }}</p>
            </div>

            {{-- Forum Best Practice --}}
            <div class="group bg-surface-white border border-border-subtle rounded-2xl p-8 hover:shadow-lg hover:border-primary/20 transition-all duration-300 flex flex-col items-start shadow-xs">
                <div class="w-16 h-16 rounded-2xl bg-secondary/15 flex items-center justify-center mb-5 group-hover:scale-110 group-hover:bg-secondary transition-all duration-300">
                    <span class="material-symbols-outlined text-secondary group-hover:text-white text-3xl transition-colors duration-300">workspace_premium</span>
                </div>
                <h3 class="font-headline-sm text-headline-sm text-primary mb-3">{{ $pengaturan['program_2_judul'] ?? '' }}</h3>
                <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">{{ $pengaturan['program_2_deskripsi'] ?? '' }}</p>
            </div>

            {{-- Kajian & Rekomendasi --}}
            <div class="group bg-surface-white border border-border-subtle rounded-2xl p-8 hover:shadow-lg hover:border-primary/20 transition-all duration-300 flex flex-col items-start shadow-xs">
                <div class="w-16 h-16 rounded-2xl bg-secondary/15 flex items-center justify-center mb-5 group-hover:scale-110 group-hover:bg-secondary transition-all duration-300">
                    <span class="material-symbols-outlined text-secondary group-hover:text-white text-3xl transition-colors duration-300">description</span>
                </div>
                <h3 class="font-headline-sm text-headline-sm text-primary mb-3">{{ $pengaturan['program_3_judul'] ?? '' }}</h3>
                <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">{{ $pengaturan['program_3_deskripsi'] ?? '' }}</p>
            </div>
        </div>
    </div>
</section>

<!-- Provinsi Anggota — Marquee + Background Peta Indonesia -->
<section id="beranda-provinsi" class="relative py-12 md:py-16 border-y border-border-subtle overflow-hidden"
         style="background: linear-gradient(180deg, #F0F4F9 0%, #E8EFF7 100%); min-height: 400px;">

    {{-- Background Peta Indonesia Vektor Bersih & Proporsional (Lebih Besar) --}}
    <div class="absolute inset-0 pointer-events-none flex items-center justify-center overflow-hidden px-2 md:px-6 opacity-85">
        <div class="w-full max-w-[1600px] h-full max-h-[440px] flex items-center justify-center">
            @include('components.peta-indonesia-svg')
        </div>
    </div>

    {{-- Garis Ekuator Samar --}}
    <div class="absolute left-0 right-0 top-1/2 -translate-y-1/2 pointer-events-none border-b border-[#001647]/10 border-dashed z-0"></div>

    {{-- Konten Utama --}}
    <div class="relative z-10">
        <div class="max-w-[1200px] mx-auto px-4 mb-6">
            <h2 class="font-headline-md text-headline-md text-primary">Provinsi Anggota</h2>
            <div class="w-12 h-1 bg-secondary mt-2"></div>
        </div>

        {{-- Marquee Lambang --}}
        <div class="relative w-full overflow-hidden"
             x-data="{ paused: false }"
             @mouseenter="paused = true"
             @mouseleave="paused = false">

            {{-- Gradient fade kiri --}}
            <div class="pointer-events-none absolute left-0 top-0 h-full w-20 md:w-36 z-10"
                 style="background: linear-gradient(to right, rgba(240,244,249,0.95), transparent);"></div>
            {{-- Gradient fade kanan --}}
            <div class="pointer-events-none absolute right-0 top-0 h-full w-20 md:w-36 z-10"
                 style="background: linear-gradient(to left, rgba(240,244,249,0.95), transparent);"></div>

            <div class="flex items-center py-4" style="width: max-content;"
                 :class="paused ? 'provinsi-paused' : ''"
                 id="provinsi-track">

                {{-- Set 1 --}}
                @foreach($provinsi as $p)
                <a href="{{ $p->website ?: '#' }}"
                   target="{{ $p->website ? '_blank' : '_self' }}"
                   rel="noopener noreferrer"
                   title="{{ $p->nama }}{{ $p->website ? ' — Kunjungi website resmi' : '' }}"
                   class="flex flex-col items-center justify-center mx-3 md:mx-5 shrink-0 hover:scale-110 transition-transform duration-200 cursor-pointer group"
                   style="width: 100px;">
                    <img src="{{ $p->lambang_url }}" alt="{{ $p->nama }}"
                         class="w-18 h-22 md:w-22 md:h-26 object-contain drop-shadow-[0_4px_10px_rgba(0,0,0,0.18)] group-hover:drop-shadow-[0_8px_16px_rgba(0,0,0,0.28)] transition-all duration-200"
                         loading="lazy"
                         onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                    <span class="hidden w-18 h-22 items-center justify-center">
                        <span class="material-symbols-outlined text-on-surface-variant" style="font-size:36px;">map</span>
                    </span>
                </a>
                @endforeach

                {{-- Set 2 (seamless loop) --}}
                @foreach($provinsi as $p)
                <a href="{{ $p->website ?: '#' }}"
                   target="{{ $p->website ? '_blank' : '_self' }}"
                   rel="noopener noreferrer"
                   class="flex flex-col items-center justify-center mx-3 md:mx-5 shrink-0 hover:scale-110 transition-transform duration-200 cursor-pointer group"
                   style="width: 100px;" aria-hidden="true" tabindex="-1">
                    <img src="{{ $p->lambang_url }}" alt=""
                         class="w-18 h-22 md:w-22 md:h-26 object-contain drop-shadow-[0_4px_10px_rgba(0,0,0,0.18)] group-hover:drop-shadow-[0_8px_16px_rgba(0,0,0,0.28)] transition-all duration-200"
                         loading="lazy"
                         onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                    <span class="hidden w-18 h-22 items-center justify-center" aria-hidden="true">
                        <span class="material-symbols-outlined text-on-surface-variant" style="font-size:36px;">map</span>
                    </span>
                </a>
                @endforeach

            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
    #provinsi-track {
        animation: marquee-scroll 60s linear infinite;
    }
    .provinsi-paused {
        animation-play-state: paused !important;
    }
    @keyframes marquee-scroll {
        0%   { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }
</style>
@endpush


<!-- Berita & Siaran Pers -->
<section class="py-stack-lg px-4 bg-surface-container-lowest">
    <div class="max-w-[1200px] mx-auto">
        <div class="flex justify-between items-end mb-6">
            <div>
                <h2 class="font-headline-md text-headline-md text-primary">Berita &amp; Siaran Pers</h2>
                <div class="w-12 h-1 bg-secondary mt-2"></div>
            </div>
            <a class="font-label-caps text-label-caps text-secondary underline" href="{{ route('berita') }}">LIHAT SEMUA</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($beritaTerbaru as $b)
            <a href="{{ route('artikel', $b->slug) }}" class="flex flex-col bg-surface-white border border-border-subtle rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                <img class="w-full h-48 object-cover" src="{{ $b->gambar_url }}" alt="{{ $b->judul }}">
                <div class="p-6">
                    <span class="font-label-caps text-label-caps text-on-surface-variant">{{ $b->tanggal_publikasi ? strtoupper($b->tanggal_publikasi->translatedFormat('d F Y')) : '' }}</span>
                    <h3 class="font-headline-sm text-headline-sm text-primary mt-2 mb-3">{{ $b->judul }}</h3>
                    <p class="font-body-md text-body-md text-on-surface-variant line-clamp-2">{{ $b->ringkasan ?: Str::limit(strip_tags($b->konten), 120) }}</p>
                </div>
            </a>
            @empty
            <div class="col-span-2 p-8 text-center text-on-surface-variant border border-dashed rounded-xl">
                Belum ada berita. Tambahkan melalui admin panel.
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Kegiatan APPSI dalam Video (Auto-Sync YouTube APPSI) -->
<section class="py-stack-lg px-4 max-w-[1200px] mx-auto">
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-6 gap-4">
        <div>
            <span class="font-label-caps text-label-caps text-secondary mb-1 block uppercase">Galeri Video Resmi</span>
            <h2 class="font-headline-md text-headline-md text-primary">Kegiatan APPSI dalam Video</h2>
            <div class="w-12 h-1 bg-secondary mt-2"></div>
        </div>
        <a href="{{ $pengaturanSosmed['youtube'] ?? 'https://www.youtube.com/@OfficialAPPSI' }}"
           target="_blank"
           rel="noopener noreferrer"
           class="inline-flex items-center gap-2 text-xs font-bold text-white bg-[#FF0000] hover:bg-[#CC0000] px-4 py-2.5 rounded-xl shadow-sm hover:shadow-md transition-all duration-200 w-fit">
            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
            </svg>
            <span>Kunjungi YouTube APPSI</span>
        </a>
    </div>

    {{-- Pemutar Video YouTube Auto-Sync --}}
    <div class="bg-surface-white border border-border-subtle rounded-2xl overflow-hidden shadow-lg"
         x-data="{ playing: false }">

        <div class="relative w-full aspect-video bg-black overflow-hidden">

            {{-- Thumbnail & Tombol Play --}}
            <div x-show="!playing" class="relative w-full h-full cursor-pointer group" @click="playing = true">
                <img src="{{ $videoTerbaru['thumbnail'] ?? 'https://img.youtube.com/vi/IkTBVVKkpus/sddefault.jpg' }}"
                     alt="{{ $videoTerbaru['title'] ?? 'Dokumentasi Kegiatan APPSI' }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                     onerror="this.src='https://img.youtube.com/vi/{{ $videoTerbaru['id'] ?? 'IkTBVVKkpus' }}/hqdefault.jpg'">

                <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/35 to-transparent flex items-center justify-center">

                    {{-- Tombol Play --}}
                    <div class="w-16 h-16 md:w-20 md:h-20 bg-[#FF0000] group-hover:bg-[#E60000] text-white rounded-2xl flex items-center justify-center shadow-2xl group-hover:scale-110 transition-all duration-300">
                        <svg class="w-8 h-8 md:w-10 md:h-10 fill-current ml-1" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z"/>
                        </svg>
                    </div>

                    {{-- Informasi Judul Video Terbaru --}}
                    <div class="absolute bottom-0 left-0 right-0 p-4 md:p-6 text-white flex justify-between items-end">
                        <div class="max-w-2xl">
                            <span class="inline-block bg-[#FF0000] text-white text-[10px] font-extrabold uppercase tracking-wider px-2.5 py-1 rounded-md mb-2">
                                Official APPSI Video
                            </span>
                            <h3 class="text-lg md:text-2xl font-bold leading-tight text-white drop-shadow-md">
                                {{ $videoTerbaru['title'] ?? 'Dokumentasi Kegiatan APPSI' }}
                            </h3>
                            <p class="text-xs md:text-sm text-white/80 mt-1">
                                {{ $videoTerbaru['author'] ?? 'Asosiasi Pemerintah Provinsi Seluruh Indonesia' }}
                            </p>
                        </div>
                        <span class="hidden md:inline-flex items-center gap-1.5 text-xs text-white/90 bg-black/50 px-3 py-1.5 rounded-lg backdrop-blur-sm">
                            <span class="material-symbols-outlined text-sm">play_circle</span>
                            Klik untuk memutar
                        </span>
                    </div>
                </div>
            </div>

            {{-- YouTube Embedded Iframe (Dimuat saat di-klik) --}}
            <template x-if="playing">
                <iframe class="w-full h-full"
                        src="https://www.youtube-nocookie.com/embed/{{ $videoTerbaru['id'] ?? 'IkTBVVKkpus' }}?autoplay=1&rel=0&modestbranding=1"
                        title="{{ $videoTerbaru['title'] ?? 'Dokumentasi Kegiatan APPSI' }}"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin"
                        allowfullscreen>
                </iframe>
            </template>
        </div>
    </div>
</section>

<!-- Live Instagram Feed Resmi APPSI (Otomatis & Real-Time) -->
<section class="py-stack-lg px-4 max-w-[1200px] mx-auto">
    {{-- Header Section Instagram --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-gradient-to-r from-purple-500/10 via-pink-500/10 to-amber-500/10 border border-pink-500/20 text-xs font-bold text-pink-600 mb-2">
                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                </svg>
                <span>@appsi.or.id</span>
            </div>
            <h2 class="font-headline-md text-headline-md text-primary">Aktivitas di Instagram</h2>
            <p class="font-body-lg text-body-lg text-on-surface-variant mt-1">Ikuti liputan kegiatan, siaran pers, dan dokumentasi resmi APPSI secara live</p>
            <div class="w-12 h-1 bg-secondary mt-2"></div>
        </div>

        {{-- Tombol Follow Instagram --}}
        <a href="{{ $pengaturan['instagram'] ?? 'https://www.instagram.com/appsi.or.id/' }}"
           target="_blank"
           rel="noopener noreferrer"
           class="inline-flex items-center gap-2 text-xs font-bold text-white px-5 py-2.5 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 w-fit hover:scale-105 active:scale-95"
           style="background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);">
            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
            </svg>
            <span>Follow @appsi.or.id</span>
        </a>
    </div>

    @if(!empty($pengaturan['instagram_widget_code']))
        {{-- Custom Widget Container jika diisi oleh Admin --}}
        <div class="bg-surface-white border border-border-subtle rounded-2xl p-4 shadow-sm overflow-hidden">
            <div class="w-full overflow-hidden">
                {!! $pengaturan['instagram_widget_code'] !!}
            </div>
        </div>
    @else
        {{-- Grid Frame Resmi Postingan & Reels Instagram Asli --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($igPosts as $post)
            <div class="bg-surface-white border border-border-subtle rounded-2xl p-3 shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col justify-between group">
                <div class="w-full rounded-xl overflow-hidden bg-slate-50 relative flex items-center justify-center min-h-[460px]">
                    {{-- Frame Resmi Postingan Instagram Asli --}}
                    <iframe src="{{ $post['embed_url'] }}"
                            class="w-full h-[470px] border-0 rounded-xl"
                            frameborder="0"
                            scrolling="no"
                            allowtransparency="true"
                            loading="lazy"
                            title="Instagram Post {{ $post['code'] }}">
                    </iframe>
                </div>

                {{-- Bar Tombol Buka di Instagram --}}
                <div class="pt-3 border-t border-slate-100 mt-2 flex items-center justify-between text-xs">
                    <span class="inline-flex items-center gap-1.5 font-bold text-slate-600">
                        <svg class="w-3.5 h-3.5 text-pink-500 fill-current" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069z"/>
                        </svg>
                        <span>{{ strtoupper($post['type']) == 'REEL' ? 'Instagram Reel' : 'Instagram Post' }}</span>
                    </span>
                    <a href="{{ $post['url'] }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="font-bold text-amber-600 hover:text-amber-700 inline-flex items-center gap-1 group-hover:translate-x-0.5 transition-transform">
                        <span>Buka di App</span>
                        <span class="material-symbols-outlined text-xs">open_in_new</span>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</section>
@endsection
