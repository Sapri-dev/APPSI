<nav class="fixed bottom-6 left-4 right-4 z-50 flex justify-around items-center px-2 py-3 bg-surface-white/95 backdrop-blur-md border border-border-subtle shadow-xl rounded-full md:hidden">
    @php
        $isHome = request()->routeIs('home');
        $isBerita = request()->routeIs('berita', 'artikel');
        $isOrg = request()->routeIs('sekretariat', 'dewan-penasehat', 'dewan-pengurus');
        $isKontak = request()->routeIs('hubungi');
    @endphp

    <a class="flex flex-col items-center justify-center {{ $isHome ? 'bg-secondary-container text-on-secondary-container rounded-full px-4 py-1 font-bold' : 'text-on-surface-variant px-2 py-1' }} transition-all duration-150 active:scale-95" href="{{ route('home') }}">
        <span class="material-symbols-outlined" @if($isHome) style="font-variation-settings: 'FILL' 1" @endif>home</span>
        <span class="font-label-caps text-[10px] mt-0.5">Beranda</span>
    </a>

    <a class="flex flex-col items-center justify-center {{ $isBerita ? 'bg-secondary-container text-on-secondary-container rounded-full px-4 py-1 font-bold' : 'text-on-surface-variant px-2 py-1' }} transition-all duration-150 active:scale-95" href="{{ route('berita') }}">
        <span class="material-symbols-outlined" @if($isBerita) style="font-variation-settings: 'FILL' 1" @endif>description</span>
        <span class="font-label-caps text-[10px] mt-0.5">Berita</span>
    </a>

    <a class="flex flex-col items-center justify-center {{ $isOrg ? 'bg-secondary-container text-on-secondary-container rounded-full px-4 py-1 font-bold' : 'text-on-surface-variant px-2 py-1' }} transition-all duration-150 active:scale-95" href="{{ route('sekretariat') }}">
        <span class="material-symbols-outlined" @if($isOrg) style="font-variation-settings: 'FILL' 1" @endif>groups</span>
        <span class="font-label-caps text-[10px] mt-0.5">Organisasi</span>
    </a>

    <a class="flex flex-col items-center justify-center {{ $isKontak ? 'bg-secondary-container text-on-secondary-container rounded-full px-4 py-1 font-bold' : 'text-on-surface-variant px-2 py-1' }} transition-all duration-150 active:scale-95" href="{{ route('hubungi') }}">
        <span class="material-symbols-outlined" @if($isKontak) style="font-variation-settings: 'FILL' 1" @endif>call</span>
        <span class="font-label-caps text-[10px] mt-0.5">Kontak</span>
    </a>
</nav>
