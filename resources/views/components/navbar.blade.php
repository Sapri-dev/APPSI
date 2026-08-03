<header class="fixed top-0 w-full z-50 flex justify-between items-center px-4 md:px-8 h-16 bg-primary text-on-primary transition-all duration-300" id="main-header">
    <div class="flex items-center gap-4">
        <button class="flex items-center justify-center w-10 h-10 hover:bg-white/10 transition-all rounded-full">
            <span class="material-symbols-outlined">menu</span>
        </button>
        <a href="{{ route('home') }}" class="flex items-center gap-2">
            <span class="font-headline-md text-headline-md font-bold text-on-primary tracking-tight">APPSI</span>
        </a>
    </div>

    <!-- Desktop Navigation Links -->
    <nav class="hidden md:flex items-center gap-6">
        <a href="{{ route('home') }}" class="font-label-caps text-label-caps {{ request()->routeIs('home') ? 'text-secondary-fixed font-bold' : 'text-on-primary/80 hover:text-on-primary' }} transition-colors">BERANDA</a>
        
        <!-- Dropdown Tentang APPSI -->
        <div class="relative group">
            <button class="font-label-caps text-label-caps {{ request()->routeIs('sekretariat', 'dewan-penasehat', 'dewan-pengurus') ? 'text-secondary-fixed font-bold' : 'text-on-primary/80 hover:text-on-primary' }} flex items-center gap-1 py-2 transition-colors">
                TENTANG APPSI <span class="material-symbols-outlined text-sm">expand_more</span>
            </button>
            <div class="absolute left-0 top-full hidden group-hover:block bg-surface-white text-on-surface rounded-xl shadow-lg border border-border-subtle py-2 w-48 z-50">
                <a href="{{ route('sekretariat') }}" class="block px-4 py-2 text-sm hover:bg-surface-container transition-colors">Sekretariat</a>
                <a href="{{ route('dewan-penasehat') }}" class="block px-4 py-2 text-sm hover:bg-surface-container transition-colors">Dewan Penasehat</a>
                <a href="{{ route('dewan-pengurus') }}" class="block px-4 py-2 text-sm hover:bg-surface-container transition-colors">Dewan Pengurus</a>
            </div>
        </div>

        <a href="{{ route('berita') }}" class="font-label-caps text-label-caps {{ request()->routeIs('berita', 'artikel') ? 'text-secondary-fixed font-bold' : 'text-on-primary/80 hover:text-on-primary' }} transition-colors">BERITA</a>
        <a href="{{ route('hubungi') }}" class="font-label-caps text-label-caps {{ request()->routeIs('hubungi') ? 'text-secondary-fixed font-bold' : 'text-on-primary/80 hover:text-on-primary' }} transition-colors">HUBUNGI KAMI</a>
    </nav>

    <div class="flex items-center gap-4">
        <a class="hidden lg:flex flex-col items-end" href="tel:+62211234567">
            <span class="font-label-caps text-label-caps text-on-primary/70">Sekretariat</span>
            <span class="font-body-md text-body-md font-bold text-on-primary">(021) 123 4567</span>
        </a>
        <button class="flex items-center justify-center w-10 h-10 hover:bg-white/10 transition-all rounded-full">
            <span class="material-symbols-outlined">search</span>
        </button>
    </div>
</header>
