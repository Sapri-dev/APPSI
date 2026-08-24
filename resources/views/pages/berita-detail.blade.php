@extends('layouts.app')

@section('title', $artikel->judul . ' - APPSI')

@section('content')
<section class="py-12 px-4 max-w-[1000px] mx-auto space-y-8">

    <!-- Breadcrumb & Category -->
    <div class="flex items-center gap-2 text-xs text-slate-500">
        <a href="{{ route('home') }}" class="hover:text-primary">Beranda</a>
        <span>/</span>
        <a href="{{ route('berita') }}" class="hover:text-primary">Berita</a>
        <span>/</span>
        <span class="text-slate-800 font-semibold truncate max-w-xs">{{ $artikel->judul }}</span>
    </div>

    <!-- Article Header -->
    <div class="space-y-4">
        <span class="px-3 py-1 bg-secondary text-primary font-bold text-xs rounded-full inline-block uppercase">
            {{ $artikel->kategori }}
        </span>
        <h1 class="text-3xl md:text-4xl font-extrabold text-primary leading-tight">
            {{ $artikel->judul }}
        </h1>
        <div class="flex items-center gap-4 text-xs text-slate-500 border-b border-slate-200 pb-4">
            <span class="flex items-center gap-1">
                <span class="material-symbols-outlined text-sm">calendar_today</span>
                {{ $artikel->tanggal_publikasi ? $artikel->tanggal_publikasi->format('d MMMM Y') : '-' }}
            </span>
            <span class="flex items-center gap-1">
                <span class="material-symbols-outlined text-sm">visibility</span>
                {{ number_format($artikel->views) }} kali dibaca
            </span>
        </div>
    </div>

    <!-- Featured Image -->
    @if($artikel->gambar)
        <div class="rounded-2xl overflow-hidden shadow-lg border border-slate-200">
            <img src="{{ $artikel->gambar_url }}" alt="{{ $artikel->judul }}" class="w-full max-h-[480px] object-cover">
        </div>
    @endif

    <!-- Article Content -->
    <div class="prose prose-slate max-w-none text-slate-800 leading-relaxed space-y-4 font-body-lg">
        {!! $artikel->konten !!}
    </div>

    <!-- Related Articles -->
    @if($terkait->count() > 0)
        <div class="pt-10 border-t border-slate-200 space-y-6">
            <h3 class="text-xl font-bold text-primary">Berita Terkait Lainnya</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($terkait as $t)
                    <a href="{{ route('artikel', $t->slug) }}" class="bg-white border border-slate-200 p-4 rounded-xl shadow-2xs hover:shadow-md transition-shadow group">
                        <span class="text-[10px] font-bold text-secondary uppercase">{{ $t->kategori }}</span>
                        <h4 class="font-bold text-sm text-primary group-hover:text-amber-600 transition-colors line-clamp-2 mt-1">
                            {{ $t->judul }}
                        </h4>
                        <span class="text-[11px] text-slate-400 mt-2 block">
                            {{ $t->tanggal_publikasi ? $t->tanggal_publikasi->format('d M Y') : '' }}
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

</section>
@endsection
