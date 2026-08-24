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
            <span class="bg-amber-500 text-navy-950 font-bold px-2 py-1 rounded text-xs tracking-wider">ADMIN</span>
            <span class="font-bold text-lg">APPSI Portal</span>
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
    <aside id="sidebar" class="fixed top-0 left-0 h-screen w-64 bg-navy-900 text-slate-200 hidden md:flex flex-col z-40 border-r border-navy-800">
        <!-- Logo & Brand Header -->
        <div class="p-5 border-b border-navy-800/80 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-500 to-amber-600 flex items-center justify-center font-black text-navy-950 text-xl shadow-lg">
                    A
                </div>
                <div>
                    <h1 class="font-bold text-white leading-tight">APPSI Admin</h1>
                    <p class="text-xs text-slate-400">Control Panel</p>
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
            <div class="text-[11px] font-semibold tracking-wider text-slate-400 uppercase px-3 pt-2 pb-1">Menu Utama</div>
            
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-amber-500 text-navy-950 font-bold shadow-md' : 'text-slate-300 hover:bg-navy-800 hover:text-white' }}">
                <span class="material-symbols-outlined">dashboard</span>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.berita.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition-all {{ request()->routeIs('admin.berita.*') ? 'bg-amber-500 text-navy-950 font-bold shadow-md' : 'text-slate-300 hover:bg-navy-800 hover:text-white' }}">
                <span class="material-symbols-outlined">newspaper</span>
                <span>Berita & Artikel</span>
            </a>

            <a href="{{ route('admin.pengurus.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition-all {{ request()->routeIs('admin.pengurus.*') ? 'bg-amber-500 text-navy-950 font-bold shadow-md' : 'text-slate-300 hover:bg-navy-800 hover:text-white' }}">
                <span class="material-symbols-outlined">groups</span>
                <span>Pengurus & Organisasi</span>
            </a>

            <a href="{{ route('admin.pustaka.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition-all {{ request()->routeIs('admin.pustaka.*') ? 'bg-amber-500 text-navy-950 font-bold shadow-md' : 'text-slate-300 hover:bg-navy-800 hover:text-white' }}">
                <span class="material-symbols-outlined">folder_shared</span>
                <span>Pustaka & Dokumen</span>
            </a>

            <a href="{{ route('admin.provinsi.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition-all {{ request()->routeIs('admin.provinsi.*') ? 'bg-amber-500 text-navy-950 font-bold shadow-md' : 'text-slate-300 hover:bg-navy-800 hover:text-white' }}">
                <span class="material-symbols-outlined">map</span>
                <span>38 Provinsi</span>
            </a>

            <div class="text-[11px] font-semibold tracking-wider text-slate-400 uppercase px-3 pt-6 pb-1">Sistem</div>

            <a href="{{ route('admin.pengaturan.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition-all {{ request()->routeIs('admin.pengaturan.*') ? 'bg-amber-500 text-navy-950 font-bold shadow-md' : 'text-slate-300 hover:bg-navy-800 hover:text-white' }}">
                <span class="material-symbols-outlined">settings</span>
                <span>Pengaturan Website</span>
            </a>

            <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-slate-400 hover:bg-navy-800 hover:text-white transition-all">
                <span class="material-symbols-outlined">open_in_new</span>
                <span>Lihat Website</span>
            </a>
        </nav>

        <!-- User Profile & Logout Footer -->
        <div class="p-4 border-t border-navy-800/80 bg-navy-950/50 flex items-center justify-between">
            <div class="flex items-center gap-3 overflow-hidden">
                <div class="w-9 h-9 rounded-full bg-slate-700 text-slate-200 font-bold flex items-center justify-center text-sm shrink-0">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="truncate">
                    <div class="text-sm font-semibold text-white truncate">{{ auth()->user()->name ?? 'Administrator' }}</div>
                    <div class="text-xs text-slate-400 truncate">{{ auth()->user()->email ?? 'admin@appsi.or.id' }}</div>
                </div>
            </div>
            <form action="{{ route('admin.logout') }}" method="POST" class="shrink-0">
                @csrf
                <button type="submit" title="Logout" class="p-2 text-slate-400 hover:text-rose-400 hover:bg-navy-800 rounded-lg transition-colors">
                    <span class="material-symbols-outlined">logout</span>
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
