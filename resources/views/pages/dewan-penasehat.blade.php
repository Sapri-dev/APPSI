@extends('layouts.app')

@section('title', 'Dewan Penasehat APPSI ' . ($appsiPeriode ?? ''))

@push('styles')
<style>
    .hero-gradient { background: linear-gradient(rgba(12, 42, 107, 0.9), rgba(12, 42, 107, 0.7)); }
</style>
@endpush

@section('content')
<div class="max-w-[1200px] mx-auto px-4 md:px-8">
    <!-- Breadcrumbs -->
    <nav class="py-stack-md flex items-center gap-2 text-on-surface-variant font-label-caps text-label-caps">
        <a class="hover:text-primary transition-colors" href="{{ route('home') }}">Beranda</a>
        <span class="material-symbols-outlined text-sm">chevron_right</span>
        <span class="text-on-surface-variant">Tentang APPSI</span>
        <span class="material-symbols-outlined text-sm">chevron_right</span>
        <span class="text-primary font-bold">Dewan Penasehat</span>
    </nav>

    <!-- Hero / Introductory Section -->
    <section class="mb-stack-lg bg-surface-white rounded-xl border border-border-subtle overflow-hidden shadow-sm">
        <div class="grid md:grid-cols-2">
            <div class="p-stack-md md:p-12 flex flex-col justify-center">
                <h1 class="font-headline-lg text-headline-lg text-primary-container mb-stack-sm">
                    Dewan Penasehat APPSI
                </h1>
                <p class="font-label-caps text-label-caps text-secondary font-bold mb-stack-md tracking-widest uppercase">
                    Periode {{ $appsiPeriode }}
                </p>
                <p class="font-body-lg text-body-lg text-on-surface-variant leading-relaxed">
                    Dewan Penasihat merupakan organ strategis dalam struktur APPSI yang berfungsi memberikan arahan, kearifan kepemimpinan, dan pandangan kebijakan guna memastikan organisasi tetap selaras dengan kepentingan nasional dan daerah.
                </p>
            </div>
            <div class="relative min-h-[300px] hidden md:block">
                <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDdOXS_N46jzVcqemLPUh00Zy6bdk0T-UiJKaNpijvQy4V1OHLPOEPf4r7EGoLILSRQOLZg7wXgV-GisiaDlksmzD7FoXoeQExnXHdeaJyZLh-vvbobW-zsoIc_TlT8DE7Fp_cW2Ac-ryoDT-pp2ve3Pamuz-2PhorPgZqb-uunBke1c4lfVSO8aWF60_JzHPcc9ypMRAf3pt0psIrwKlUyO4KI-j6jaKktU_t7rU9eSqJ0-tjH_u5l7RW0agbU2Udq6tALA18yh8g')"></div>
                <div class="absolute inset-0 hero-gradient opacity-60"></div>
                <div class="absolute inset-0 flex items-center justify-center p-8">
                    <div class="border-2 border-on-primary/30 p-6 backdrop-blur-sm bg-primary/20 rounded-lg">
                        <span class="text-on-primary font-headline-sm text-headline-sm italic text-center block">"Menjaga Kesinambungan &amp; Nilai Strategis Nasional"</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Advisory Board Grid -->
    <section class="mb-stack-lg">
        <div class="flex items-center gap-4 mb-stack-md">
            <div class="h-10 w-2 bg-secondary rounded-full"></div>
            <h2 class="font-headline-md text-headline-md text-primary">Susunan Dewan Penasihat</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($anggota as $p)
            <div class="bg-surface-white border border-border-subtle rounded-2xl p-6 hover:shadow-lg hover:border-primary/20 transition-all duration-300 group">
                <div class="flex flex-col items-center text-center">
                    <div class="w-24 h-24 rounded-full bg-slate-100 mb-4 overflow-hidden border-2 border-primary/10 group-hover:border-secondary shadow-sm transition-colors flex items-center justify-center">
                        <img class="w-full h-full object-cover object-top" src="{{ $p->foto_url }}" alt="{{ $p->nama }}"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'"/>
                        <div class="hidden w-full h-full items-center justify-center bg-slate-100 text-slate-400">
                            <span class="material-symbols-outlined text-4xl">person</span>
                        </div>
                    </div>
                    <h3 class="font-headline-sm text-headline-sm text-primary mb-1">{{ $p->nama }}</h3>
                    <span class="inline-block px-3 py-1 bg-amber-50 text-secondary border border-amber-200/60 rounded-full font-label-caps text-label-caps text-xs font-bold mt-1">
                        {{ $p->provinsi ? 'Gubernur ' . $p->provinsi : $p->jabatan }}
                    </span>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center text-on-surface-variant py-12">Belum ada data Dewan Penasehat.</div>
            @endforelse
        </div>
    </section>

    <!-- Role and Function Section -->
    <section class="mb-stack-lg bg-primary-container text-on-primary rounded-xl p-8 md:p-12 relative overflow-hidden shadow-xl">
        <div class="relative z-10 grid md:grid-cols-2 gap-8 items-center">
            <div>
                <h2 class="font-headline-md text-headline-md text-secondary-fixed mb-stack-md">Peran dan Fungsi Strategis</h2>
                <p class="font-body-md text-body-md text-on-primary/80 mb-stack-md">
                    Sebagai wadah koordinasi dan sinergi, Dewan Penasehat memiliki tanggung jawab krusial dalam menavigasi arah organisasi di tengah dinamika kebijakan nasional.
                </p>
                <ul class="space-y-3.5">
                    <li class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-secondary-fixed mt-0.5">verified_user</span>
                        <span class="font-body-md text-body-md">Memberikan nasihat dan pertimbangan strategis kepada Dewan Pengurus APPSI;</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-secondary-fixed mt-0.5">insights</span>
                        <span class="font-body-md text-body-md">Memberikan pandangan terhadap arah kebijakan organisasi dan isu-isu strategis nasional;</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-secondary-fixed mt-0.5">shield</span>
                        <span class="font-body-md text-body-md">Menjaga konsistensi nilai, visi, dan misi APPSI;</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-secondary-fixed mt-0.5">account_balance</span>
                        <span class="font-body-md text-body-md">Mendukung penguatan peran pemerintah provinsi dalam sistem pemerintahan Negara Kesatuan Republik Indonesia;</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-secondary-fixed mt-0.5">gavel</span>
                        <span class="font-body-md text-body-md">Menjadi rujukan etis dan strategis dalam pengambilan keputusan organisasi.</span>
                    </li>
                </ul>
            </div>
            <div class="hidden md:block">
                <div class="bg-on-primary/5 rounded-2xl border border-on-primary/10 p-8 backdrop-blur-md">
                    <span class="material-symbols-outlined text-6xl text-secondary-fixed mb-4">policy</span>
                    <h3 class="font-headline-sm text-headline-sm text-on-primary mb-4">Visi Penguatan Daerah</h3>
                    <p class="font-body-md text-body-md text-on-primary/70 leading-relaxed italic">
                        "Mewujudkan tata kelola pemerintahan daerah yang efektif, berkeadilan, dan berkelanjutan dalam bingkai Negara Kesatuan Republik Indonesia."
                    </p>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
