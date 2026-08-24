<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-900">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrator - APPSI</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: {
                            50: '#f0f4fd',
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
</head>
<body class="h-full font-sans antialiased text-slate-100 flex items-center justify-center p-4 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-navy-800 via-navy-950 to-black">

    <div class="w-full max-w-md space-y-8">
        <!-- Brand Header -->
        <div class="text-center space-y-3">
            <div class="inline-flex w-16 h-16 rounded-2xl bg-gradient-to-br from-amber-500 to-amber-600 items-center justify-center font-black text-navy-950 text-3xl shadow-xl shadow-amber-500/20">
                A
            </div>
            <div>
                <h1 class="text-2xl font-bold text-white tracking-tight">Portal Admin APPSI</h1>
                <p class="text-xs text-slate-400">Asosiasi Pemerintah Provinsi Seluruh Indonesia</p>
            </div>
        </div>

        <!-- Login Card -->
        <div class="bg-navy-900/90 border border-slate-800 p-8 rounded-2xl shadow-2xl backdrop-blur-md">
            @if(session('error'))
                <div class="mb-6 bg-rose-500/10 border border-rose-500/30 text-rose-300 p-3.5 rounded-xl text-xs flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm shrink-0">error</span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 bg-rose-500/10 border border-rose-500/30 text-rose-300 p-3.5 rounded-xl text-xs space-y-1">
                    @foreach($errors->all() as $error)
                        <p class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm shrink-0">error</span>
                            <span>{{ $error }}</span>
                        </p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-300 mb-1.5 uppercase tracking-wider">Email Admin</label>
                    <div class="relative">
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                            class="w-full bg-navy-950 border border-slate-700 rounded-xl px-4 py-3 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-colors"
                            placeholder="admin@appsi.or.id">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-300 mb-1.5 uppercase tracking-wider">Password</label>
                    <div class="relative">
                        <input type="password" id="password" name="password" required
                            class="w-full bg-navy-950 border border-slate-700 rounded-xl px-4 py-3 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-colors"
                            placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center gap-2 text-slate-400 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded bg-navy-950 border-slate-700 text-amber-500 focus:ring-amber-500 focus:ring-offset-navy-900">
                        <span>Ingat saya</span>
                    </label>
                </div>

                <button type="submit" class="w-full py-3.5 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-navy-950 font-bold rounded-xl shadow-lg shadow-amber-500/20 hover:shadow-amber-500/30 transition-all flex items-center justify-center gap-2">
                    <span>Masuk ke Admin</span>
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </button>
            </form>
        </div>

        <div class="text-center text-xs text-slate-500">
            &copy; {{ date('Y') }} APPSI. All rights reserved.
        </div>
    </div>

</body>
</html>
