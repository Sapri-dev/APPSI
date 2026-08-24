@extends('layouts.app')

@section('title', 'Berita & Siaran Pers - APPSI')

@section('content')
<div class="max-w-[1200px] mx-auto px-4 py-8">

    {{-- Header Judul Halaman --}}
    <div class="mb-8">
        <span class="font-label-caps text-label-caps text-secondary mb-1 block uppercase">Kabar Terkini</span>
        <h1 class="font-headline-md text-headline-md text-primary">Berita &amp; Siaran Pers</h1>
        <div class="w-12 h-1 bg-secondary mt-2"></div>
    </div>

    {{-- Sorotan Utama / Featured News (Jika tidak sedang memfilter & ada berita) --}}
    @if($sorotan && empty($kategoriAktif) && empty($cari) && $berita->currentPage() === 1)
    <section class="mb-10">
        <div class="relative group overflow-hidden rounded-2xl bg-surface-white border border-border-subtle shadow-md hover:shadow-xl transition-all duration-300">
            <div class="grid md:grid-cols-12 gap-0">
                <div class="md:col-span-7 h-[280px] md:h-[400px] relative overflow-hidden bg-slate-900">
                    <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                         src="{{ $sorotan->gambar_url }}"
                         alt="{{ $sorotan->judul }}"
                         onerror="this.src='{{ asset('images/placeholder-berita.jpg') }}'"/>
                    <div class="absolute top-4 left-4">
                        <span class="bg-secondary text-slate-950 font-extrabold px-3.5 py-1.5 rounded-full text-xs uppercase tracking-wider shadow-md flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-sm">stars</span>
                            SOROTAN UTAMA
                        </span>
                    </div>
                </div>
                <div class="md:col-span-5 p-6 md:p-8 lg:p-10 flex flex-col justify-center bg-surface-white">
                    <div class="flex items-center gap-2 mb-3 text-xs text-on-surface-variant font-medium">
                        <span class="uppercase font-bold text-secondary">{{ $sorotan->kategori ?? 'UMUM' }}</span>
                        <span>•</span>
                        <span>{{ $sorotan->tanggal_publikasi ? $sorotan->tanggal_publikasi->translatedFormat('d F Y') : '' }}</span>
                    </div>
                    <h2 class="font-headline-md text-headline-md text-primary mb-3 leading-tight group-hover:text-secondary transition-colors line-clamp-3">
                        <a href="{{ route('artikel', $sorotan->slug) }}">
                            {{ $sorotan->judul }}
                        </a>
                    </h2>
                    <p class="text-on-surface-variant font-body-md text-body-md mb-6 line-clamp-3 leading-relaxed">
                        {{ $sorotan->ringkasan ?: Str::limit(strip_tags($sorotan->konten), 160) }}
                    </p>
                    <a href="{{ route('artikel', $sorotan->slug) }}"
                       class="w-fit bg-primary hover:bg-primary/90 text-white px-6 py-2.5 rounded-xl font-bold text-xs md:text-sm flex items-center gap-2 shadow-md hover:shadow-lg transition-all active:scale-95">
                        <span>Baca Selengkapnya</span>
                        <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- Filter Kategori & Pencarian --}}
    <section class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        {{-- Kategori Tabs Dinamis --}}
        <div class="flex items-center gap-2 overflow-x-auto hide-scrollbar py-1">
            <a href="{{ route('berita', request('cari') ? ['cari' => request('cari')] : []) }}"
               class="whitespace-nowrap px-4 py-2 rounded-full text-xs font-bold transition-all {{ empty($kategoriAktif) || $kategoriAktif === 'semua' ? 'bg-primary text-white shadow-sm' : 'bg-surface-white border border-border-subtle text-on-surface-variant hover:bg-slate-100' }}">
                Semua
            </a>
            @foreach($daftarKategori as $kat)
            <a href="{{ route('berita', array_merge(request('cari') ? ['cari' => request('cari')] : [], ['kategori' => $kat])) }}"
               class="whitespace-nowrap px-4 py-2 rounded-full text-xs font-bold transition-all {{ $kategoriAktif === $kat ? 'bg-primary text-white shadow-sm' : 'bg-surface-white border border-border-subtle text-on-surface-variant hover:bg-slate-100' }}">
                {{ $kat }}
            </a>
            @endforeach
        </div>

        {{-- Form Pencarian Berita --}}
        <form action="{{ route('berita') }}" method="GET" class="relative w-full md:w-72">
            @if($kategoriAktif)
                <input type="hidden" name="kategori" value="{{ $kategoriAktif }}">
            @endif
            <input type="text"
                   name="cari"
                   value="{{ request('cari') }}"
                   placeholder="Cari berita..."
                   class="w-full pl-10 pr-4 py-2 bg-surface-white border border-border-subtle rounded-full text-xs text-on-surface focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary shadow-2xs">
            <span class="material-symbols-outlined absolute left-3 top-2.5 text-slate-400 text-[18px]">search</span>
            @if(request('cari'))
                <a href="{{ route('berita', $kategoriAktif ? ['kategori' => $kategoriAktif] : []) }}"
                   class="absolute right-3 top-2.5 text-slate-400 hover:text-slate-600">
                    <span class="material-symbols-outlined text-[18px]">close</span>
                </a>
            @endif
        </form>
    </section>

    {{-- Daftar Grid Berita --}}
    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
        @forelse($berita as $item)
        <a href="{{ route('artikel', $item->slug) }}"
           class="bg-surface-white border border-border-subtle rounded-2xl overflow-hidden flex flex-col hover:border-secondary/40 hover:shadow-lg transition-all duration-300 group">
            <div class="h-48 overflow-hidden relative bg-slate-900">
                <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                     src="{{ $item->gambar_url }}"
                     alt="{{ $item->judul }}"
                     loading="lazy"
                     onerror="this.src='{{ asset('images/placeholder-berita.jpg') }}'"/>
                <span class="absolute top-3 left-3 bg-primary/80 backdrop-blur-sm text-white text-[10px] font-bold px-2.5 py-1 rounded-md uppercase tracking-wider">
                    {{ $item->kategori ?? 'UMUM' }}
                </span>
            </div>
            <div class="p-5 flex flex-col flex-grow">
                <span class="text-on-surface-variant text-[11px] font-semibold mb-2 block">
                    {{ $item->tanggal_publikasi ? $item->tanggal_publikasi->translatedFormat('d F Y') : '' }}
                </span>
                <h3 class="font-headline-sm text-headline-sm text-primary mb-2.5 line-clamp-2 group-hover:text-secondary transition-colors leading-snug">
                    {{ $item->judul }}
                </h3>
                <p class="text-on-surface-variant font-body-md text-body-md line-clamp-2 mb-4 leading-relaxed flex-grow">
                    {{ $item->ringkasan ?: Str::limit(strip_tags($item->konten), 120) }}
                </p>
                <div class="pt-3 border-t border-border-subtle flex justify-between items-center text-xs font-bold text-primary group-hover:text-secondary transition-colors">
                    <span>BACA SELENGKAPNYA</span>
                    <span class="material-symbols-outlined text-[18px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </div>
            </div>
        </a>
        @empty
        <div class="col-span-full py-16 text-center bg-surface-white border border-dashed border-border-subtle rounded-2xl">
            <span class="material-symbols-outlined text-slate-300 text-5xl mb-2">newspaper</span>
            <p class="font-bold text-on-surface">Belum ada berita ditemukan.</p>
            <p class="text-xs text-on-surface-variant mt-1">Silakan coba kata kunci lain atau periksa kembali nanti.</p>
        </div>
        @endforelse
    </section>

    {{-- Pagination --}}
    @if($berita->hasPages())
    <div class="flex justify-center mb-12">
        {{ $berita->links() }}
    </div>
    @endif

</div>
@endsection
