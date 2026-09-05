{{-- Top Header — Logo + Center Menu + Social Icons --}}
<header id="main-header" class="fixed top-0 left-0 right-0 z-50 flex items-center justify-between px-4 md:px-8 h-20
               bg-white/95 backdrop-blur-xl border-b border-gray-100
               transition-all duration-300" style="box-shadow: 0 2px 16px rgba(0,22,71,0.08);">

    {{-- Kiri: Logo --}}
    <a href="{{ route('home') }}" class="flex items-center shrink-0">
        <img src="{{ $appsiLogo ?? asset('images/Logo-appsi.png') }}" alt="APPSI - Asosiasi Pemerintah Provinsi Seluruh Indonesia"
            style="height: 50px; width: auto; object-fit: contain;">
    </a>

    {{-- Kanan: Search + Sosial Media --}}
    <div class="flex items-center gap-1 shrink-0">

        {{-- Ikon Search --}}
        <button id="search-btn" onclick="document.getElementById('search-modal').classList.remove('hidden')"
            class="w-9 h-9 flex items-center justify-center rounded-full text-slate-500 hover:text-primary hover:bg-slate-100 transition-all"
            title="Cari">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8" />
                <line x1="21" y1="21" x2="16.65" y2="16.65" />
            </svg>
        </button>

        {{-- Separator --}}
        <div class="w-px h-5 bg-gray-200 mx-1"></div>

        {{-- Facebook --}}
        <a href="{{ $pengaturanSosmed['facebook'] ?? 'https://www.facebook.com/info.appsi/' }}" target="_blank"
            rel="noopener"
            class="w-9 h-9 flex items-center justify-center rounded-full text-slate-500 hover:text-[#1877F2] hover:bg-blue-50 transition-all"
            title="Facebook APPSI">
            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="currentColor">
                <path
                    d="M24 12.073C24 5.405 18.627 0 12 0S0 5.405 0 12.073C0 18.1 4.388 23.094 10.125 24v-8.437H7.078v-3.49h3.047V9.41c0-3.025 1.792-4.697 4.533-4.697 1.312 0 2.686.236 2.686.236v2.97h-1.513c-1.491 0-1.956.93-1.956 1.874v2.25h3.328l-.532 3.49h-2.796V24C19.612 23.094 24 18.1 24 12.073z" />
            </svg>
        </a>

        {{-- X (Twitter) --}}
        <a href="{{ $pengaturanSosmed['twitter'] ?? 'https://x.com/appsi_id' }}" target="_blank" rel="noopener"
            class="w-9 h-9 flex items-center justify-center rounded-full text-slate-500 hover:text-black hover:bg-slate-100 transition-all"
            title="X (Twitter) APPSI">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="currentColor">
                <path
                    d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
            </svg>
        </a>

        {{-- YouTube --}}
        <a href="{{ $pengaturanSosmed['youtube'] ?? 'https://www.youtube.com/@OfficialAPPSI' }}" target="_blank"
            rel="noopener"
            class="w-9 h-9 flex items-center justify-center rounded-full text-slate-500 hover:text-[#FF0000] hover:bg-red-50 transition-all"
            title="YouTube APPSI">
            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="currentColor">
                <path
                    d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
            </svg>
        </a>

        {{-- Instagram --}}
        <a href="{{ $pengaturanSosmed['instagram'] ?? 'https://www.instagram.com/appsi.or.id/' }}" target="_blank"
            rel="noopener"
            class="w-9 h-9 flex items-center justify-center rounded-full text-slate-500 hover:text-[#E1306C] hover:bg-pink-50 transition-all"
            title="Instagram APPSI">
            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="currentColor">
                <path
                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
            </svg>
        </a>
    </div>
</header>

{{-- Search Modal --}}
<div id="search-modal" class="fixed inset-0 z-[999] hidden flex items-start justify-center pt-24 px-4"
    style="background: rgba(0,22,71,0.45); backdrop-filter: blur(4px);"
    onclick="if(event.target===this) this.classList.add('hidden')">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-xl overflow-hidden"
        style="animation: slideDown 0.2s ease;">
        <form action="{{ route('berita') }}" method="GET" class="flex items-center gap-3 px-5 py-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="#001647" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
                <circle cx="11" cy="11" r="8" />
                <line x1="21" y1="21" x2="16.65" y2="16.65" />
            </svg>
            <input id="search-input" name="q" type="text" placeholder="Cari berita, dokumen APPSI..." autocomplete="off"
                class="flex-1 text-base text-slate-800 placeholder-slate-400 border-none outline-none bg-transparent py-1">
            <button type="button" onclick="document.getElementById('search-modal').classList.add('hidden')"
                class="text-slate-400 hover:text-slate-600 transition-colors shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                </svg>
            </button>
        </form>
        <div class="border-t border-slate-100 px-5 py-3 flex gap-2 flex-wrap">
            <span class="text-xs text-slate-400">Pencarian cepat:</span>
            <a href="{{ route('berita') }}" class="text-xs text-primary hover:underline font-medium">Berita Terbaru</a>
            <span class="text-xs text-slate-300">·</span>
            <a href="{{ route('pustaka', 'adart') }}"
                class="text-xs text-primary hover:underline font-medium">AD/ART</a>
            <span class="text-xs text-slate-300">·</span>
            <a href="{{ route('pustaka', 'uu') }}"
                class="text-xs text-primary hover:underline font-medium">Undang-Undang</a>
            <span class="text-xs text-slate-300">·</span>
            <a href="{{ route('pustaka', 'data_bps') }}" class="text-xs text-primary hover:underline font-medium">Data
                BPS</a>
            <span class="text-xs text-slate-300">·</span>
            <a href="{{ route('hubungi') }}" class="text-xs text-primary hover:underline font-medium">Kontak</a>
        </div>
    </div>
</div>

<style>
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-16px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<script>
    // Buka search dengan shortcut Ctrl+K atau /
    document.addEventListener('keydown', function (e) {
        if ((e.ctrlKey && e.key === 'k') || (e.key === '/' && document.activeElement.tagName !== 'INPUT')) {
            e.preventDefault();
            var modal = document.getElementById('search-modal');
            modal.classList.remove('hidden');
            setTimeout(function () { document.getElementById('search-input').focus(); }, 50);
        }
        if (e.key === 'Escape') {
            document.getElementById('search-modal').classList.add('hidden');
        }
    });
    document.getElementById('search-btn').addEventListener('click', function () {
        setTimeout(function () { document.getElementById('search-input').focus(); }, 50);
    });
</script>