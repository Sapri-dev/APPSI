<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - APPSI</title>
    
    <!-- Google Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: {
                            50: '#f0f4fd',
                            100: '#dbe4fa',
                            700: '#1d3575',
                            800: '#0c2256',
                            900: '#001647',
                            950: '#000c2a',
                        },
                        amber: {
                            500: '#f59e0b',
                            600: '#d97706',
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <!-- TinyMCE CDN (Free / Open source keyless) -->
    <script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js" referrerpolicy="origin"></script>
    
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            display: inline-block;
            vertical-align: middle;
        }
        [x-cloak] { display: none !important; }
    </style>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="h-full font-sans antialiased text-slate-800 bg-slate-50">

    <!-- Mobile Header -->
    <header class="md:hidden bg-navy-900 text-white p-4 flex items-center justify-between shadow-md fixed top-0 left-0 right-0 z-50">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-white/10 p-1 flex items-center justify-center shrink-0 border border-white/10">
                <img src="{{ asset('images/Logo-appsi-emblem.png') }}" alt="Logo APPSI" class="w-full h-full object-contain">
            </div>
            <span class="font-bold text-base">APPSI Admin</span>
        </div>
        <button id="mobile-menu-btn" class="p-2 rounded-lg bg-navy-800 text-slate-200">
            <span class="material-symbols-outlined">menu</span>
        </button>
    </header>
    <!-- Mobile top spacer -->
    <div class="md:hidden h-16"></div>

    <!-- Mobile Backdrop -->
    <div id="sidebar-backdrop" class="fixed inset-0 bg-black/50 z-30 hidden md:hidden"></div>

    <!-- Sidebar Navigation -->
    <aside id="sidebar" class="fixed top-0 left-0 h-screen w-64 bg-navy-950 text-slate-200 hidden md:flex flex-col z-40 border-r border-navy-900 shadow-xl">
        <!-- Logo & Brand Header -->
        <div class="p-5 border-b border-white/10 bg-navy-950">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-white p-1 flex items-center justify-center shrink-0 shadow-md">
                    <img src="{{ asset('images/Logo-appsi-emblem.png') }}" alt="Logo APPSI" class="w-full h-full object-contain">
                </div>
                <div class="min-w-0">
                    <h1 class="font-bold text-white text-sm tracking-wide leading-tight">APPSI</h1>
                    <p class="text-[11px] text-slate-400 font-medium truncate">Portal Administrator</p>
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 px-3 py-4 space-y-1.5 overflow-y-auto">
            <div class="text-[10px] font-bold tracking-widest text-slate-400/80 uppercase px-3 pt-1 pb-1.5">Menu Utama</div>
            
            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-amber-500 text-navy-950 font-bold shadow-md shadow-amber-500/20' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                <span class="material-symbols-outlined text-[19px] {{ request()->routeIs('admin.dashboard') ? 'text-navy-950' : 'text-slate-400' }}">dashboard</span>
                <span>Dashboard</span>
            </a>

            <!-- Berita & Artikel -->
            <a href="{{ route('admin.berita.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('admin.berita.*') ? 'bg-amber-500 text-navy-950 font-bold shadow-md shadow-amber-500/20' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                <span class="material-symbols-outlined text-[19px] {{ request()->routeIs('admin.berita.*') ? 'text-navy-950' : 'text-slate-400' }}">newspaper</span>
                <span>Berita &amp; Artikel</span>
            </a>

            <!-- Pengurus & Organisasi with Collapsible Tree Submenu -->
            <div x-data="{ open: {{ request()->routeIs('admin.pengurus.*') ? 'true' : 'false' }} }" class="space-y-0.5">
                <button type="button" @click="open = !open"
                    class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all cursor-pointer {{ request()->routeIs('admin.pengurus.*') ? 'bg-white/10 text-amber-400 font-bold border border-white/10 shadow-xs' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-[19px] {{ request()->routeIs('admin.pengurus.*') ? 'text-amber-400' : 'text-slate-400' }}">groups</span>
                        <span>Pengurus &amp; Dewan</span>
                    </div>
                    <span class="material-symbols-outlined text-base text-slate-400 transition-transform duration-200" :class="open ? 'rotate-180 text-amber-400' : ''">expand_more</span>
                </button>

                <!-- Submenu Tree -->
                <div x-show="open" x-cloak x-transition class="ml-4 pl-3 border-l border-slate-700/60 py-1 space-y-0.5 my-1">
                    <a href="{{ route('admin.pengurus.index', ['jenis' => 'pengurus']) }}"
                       class="block px-2.5 py-1.5 rounded-lg text-[11px] font-medium transition-all {{ request()->routeIs('admin.pengurus.*') && request('jenis') === 'pengurus' ? 'text-amber-400 font-bold bg-amber-500/10' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                        Dewan Pengurus
                    </a>
                    <a href="{{ route('admin.pengurus.index', ['jenis' => 'penasehat']) }}"
                       class="block px-2.5 py-1.5 rounded-lg text-[11px] font-medium transition-all {{ request()->routeIs('admin.pengurus.*') && request('jenis') === 'penasehat' ? 'text-amber-400 font-bold bg-amber-500/10' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                        Dewan Penasehat
                    </a>
                    <a href="{{ route('admin.pengurus.index', ['jenis' => 'pakar']) }}"
                       class="block px-2.5 py-1.5 rounded-lg text-[11px] font-medium transition-all {{ request()->routeIs('admin.pengurus.*') && request('jenis') === 'pakar' ? 'text-amber-400 font-bold bg-amber-500/10' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                        Dewan Pakar
                    </a>
                    <a href="{{ route('admin.pengurus.index', ['jenis' => 'sekretariat']) }}"
                       class="block px-2.5 py-1.5 rounded-lg text-[11px] font-medium transition-all {{ request()->routeIs('admin.pengurus.*') && request('jenis') === 'sekretariat' ? 'text-amber-400 font-bold bg-amber-500/10' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                        Sekretariat
                    </a>
                    <a href="{{ route('admin.pengurus.index') }}"
                       class="block px-2.5 py-1.5 rounded-lg text-[11px] font-medium transition-all {{ request()->routeIs('admin.pengurus.index') && !request('jenis') ? 'text-amber-400 font-bold bg-amber-500/10' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                        Semua Anggota
                    </a>
                </div>
            </div>

            <!-- Pustaka & Dokumen -->
            <a href="{{ route('admin.pustaka.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('admin.pustaka.*') ? 'bg-amber-500 text-navy-950 font-bold shadow-md shadow-amber-500/20' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                <span class="material-symbols-outlined text-[19px] {{ request()->routeIs('admin.pustaka.*') ? 'text-navy-950' : 'text-slate-400' }}">folder_shared</span>
                <span>Pustaka &amp; Dokumen</span>
            </a>

            <!-- Provinsi Anggota -->
            <a href="{{ route('admin.provinsi.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('admin.provinsi.*') ? 'bg-amber-500 text-navy-950 font-bold shadow-md shadow-amber-500/20' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                <span class="material-symbols-outlined text-[19px] {{ request()->routeIs('admin.provinsi.*') ? 'text-navy-950' : 'text-slate-400' }}">map</span>
                <span>Provinsi Anggota</span>
            </a>

            <div class="text-[10px] font-bold tracking-widest text-slate-400/80 uppercase px-3 pt-5 pb-1.5">Pengaturan &amp; Akses</div>

            <!-- Pengaturan Website -->
            <a href="{{ route('admin.pengaturan.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('admin.pengaturan.*') ? 'bg-amber-500 text-navy-950 font-bold shadow-md shadow-amber-500/20' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                <span class="material-symbols-outlined text-[19px] {{ request()->routeIs('admin.pengaturan.*') ? 'text-navy-950' : 'text-slate-400' }}">settings</span>
                <span>Pengaturan Website</span>
            </a>

            <!-- Akun Pengelola (Hanya untuk Super Administrator) -->
            @if(auth()->user()->isSuperAdmin())
            <a href="{{ route('admin.users.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('admin.users.*') ? 'bg-amber-500 text-navy-950 font-bold shadow-md shadow-amber-500/20' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                <span class="material-symbols-outlined text-[19px] {{ request()->routeIs('admin.users.*') ? 'text-navy-950' : 'text-slate-400' }}">manage_accounts</span>
                <span>Akun Pengelola</span>
            </a>
            @endif

            <!-- Lihat Website -->
            <a href="{{ route('home') }}" target="_blank"
               class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium text-slate-400 hover:bg-white/5 hover:text-white transition-all">
                <span class="material-symbols-outlined text-[19px]">open_in_new</span>
                <span>Lihat Website</span>
            </a>
        </nav>

        <!-- User Profile & Logout Footer -->
        <div class="p-3.5 border-t border-white/10 bg-black/20 flex items-center justify-between">
            <a href="{{ route('admin.profile.index') }}" title="Edit Profil & Ubah Password" class="flex items-center gap-2.5 overflow-hidden hover:opacity-80 transition-opacity">
                <div class="w-8 h-8 rounded-lg bg-amber-500 text-navy-950 font-black flex items-center justify-center text-xs shrink-0 shadow-xs">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="truncate">
                    <div class="text-xs font-bold text-white truncate flex items-center gap-1">
                        <span>{{ auth()->user()->name ?? 'Administrator' }}</span>
                        <span class="material-symbols-outlined text-[12px] text-amber-400">edit</span>
                    </div>
                    <div class="text-[10px] text-slate-400 truncate">{{ auth()->user()->email ?? 'admin@appsi.or.id' }}</div>
                </div>
            </a>
            <form action="{{ route('admin.logout') }}" method="POST" class="shrink-0">
                @csrf
                <button type="submit" title="Logout" class="p-1.5 text-slate-400 hover:text-rose-400 hover:bg-white/5 rounded-lg transition-colors cursor-pointer">
                    <span class="material-symbols-outlined text-lg">logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 min-h-screen md:ml-64">
        <!-- Topbar -->
        <header class="hidden md:flex bg-white border-b border-slate-200 px-6 py-4 items-center justify-between shadow-xs sticky top-0 z-10">
            <div>
                <h2 class="text-xl font-bold text-slate-800 tracking-tight">@yield('title', 'Dashboard')</h2>
                <p class="text-xs text-slate-500">@yield('subtitle', 'Panel Pengelolaan Website Resmi APPSI')</p>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}" target="_blank" class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors">
                    <span class="material-symbols-outlined text-sm">open_in_new</span>
                    <span>Buka Frontend</span>
                </a>
            </div>
        </header>

        <!-- Flash Alert Messages -->
        <main class="flex-1 p-4 md:p-6 space-y-6">
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3.5 rounded-xl flex items-center justify-between shadow-xs">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-emerald-600">check_circle</span>
                        <span class="text-sm font-medium">{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                        <span class="material-symbols-outlined text-sm">close</span>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3.5 rounded-xl flex items-center justify-between shadow-xs">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-rose-600">error</span>
                        <span class="text-sm font-medium">{{ session('error') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700">
                        <span class="material-symbols-outlined text-sm">close</span>
                    </button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        // Mobile sidebar toggle
        const menuBtn   = document.getElementById('mobile-menu-btn');
        const sidebar   = document.getElementById('sidebar');
        const backdrop  = document.getElementById('sidebar-backdrop');

        function openSidebar() {
            sidebar.classList.remove('hidden');
            sidebar.classList.add('flex');
            backdrop.classList.remove('hidden');
        }
        function closeSidebar() {
            sidebar.classList.add('hidden');
            sidebar.classList.remove('flex');
            backdrop.classList.add('hidden');
        }

        if (menuBtn) menuBtn.addEventListener('click', openSidebar);
        if (backdrop) backdrop.addEventListener('click', closeSidebar);
    </script>
    @stack('scripts')
</body>
</html>
