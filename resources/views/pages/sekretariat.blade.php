@extends('layouts.app')

@section('title', 'Sekretariat APPSI - Asosiasi Pemerintah Provinsi Seluruh Indonesia')

@push('styles')
    <style>
        .bento-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 1.5rem;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid #DDE1E6;
        }

        .hero-clip {
            clip-path: polygon(0 0, 100% 0, 100% 85%, 0% 100%);
        }
    </style>
@endpush

@section('content')
    <!-- Hero Section / Introduction -->
    <section class="relative bg-primary-container py-20 px-margin-page overflow-hidden hero-clip">
        <div class="max-w-max-width-content mx-auto relative z-10 grid md:grid-cols-2 gap-12 items-center">
            <div class="space-y-6 pt-8">
                <span
                    class="inline-block px-4 py-1 bg-secondary-container text-on-secondary-container font-label-caps text-label-caps rounded-full">Operasional
                    &amp; Administrasi</span>
                <h2 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-white">Sekretariat APPSI</h2>
                <p class="font-body-lg text-body-lg text-white/80 leading-relaxed">
                    Sekretariat merupakan lengan operasional APPSI yang bertugas memberikan dukungan teknis dan administrasi
                    kepada Dewan Pengurus guna memastikan kelancaran program kerja antar provinsi di seluruh Indonesia.
                    Berpusat di jantung Ibu Kota Jakarta, kami menjadi jembatan koordinasi strategis bagi seluruh pemerintah
                    daerah.
                </p>
                <div class="flex flex-wrap gap-4 pt-4">
                    <a href="{{ route('hubungi') }}"
                        class="h-[56px] px-8 bg-secondary text-white font-button text-button rounded-xl hover:bg-secondary/90 transition-all flex items-center gap-2 shadow-lg active:scale-95">
                        <span class="material-symbols-outlined">call</span>
                        Hubungi Sekretariat
                    </a>
                </div>
            </div>
            <div class="hidden md:block relative">
                <div class="aspect-square bg-white/5 rounded-full border border-white/10 absolute -inset-10 animate-pulse">
                </div>
                <div class="aspect-video w-full rounded-2xl bg-cover bg-center shadow-2xl border-4 border-white/10 relative z-10 overflow-hidden"
                    style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuA3G2X1e7PMHr6Dv2qZsAXiB0JpAAFz34ruWyO7rEemLiVU5xTJPaP3MFxR0zymSCibLviYFuVS3oDL_W-xHfnM_pk_8tv-QinclOtTA3DPovDOZuAM_iVZ05z4e5XJrl0cdFhNE0paXjqwRGZ78mPLgMVI2Qha3mU-v-Fwxiw_C3oMWrIYhSN7ysHPh3cGrA-XQxUQ16dKkF_0Q7uPjn4-8pOxSZFTY-TmSSDfM6vcs3JzfyQqat65foZIxermS1JZbrRMwnAcmGM')">
                </div>
            </div>
        </div>
    </section>

    <!-- Leadership & Staff Section -->
    <section class="py-stack-lg px-margin-page bg-surface">
        <div class="max-w-max-width-content mx-auto space-y-12">
            <div class="text-center space-y-2">
                <h3 class="font-headline-md text-headline-md text-primary">Struktur Kesekretariatan APPSI</h3>
                <div class="w-16 h-1 bg-secondary mx-auto"></div>
            </div>

            @if($anggota->isNotEmpty())
                @php
                    $direktur = $anggota->where('jabatan', 'Direktur Eksekutif')->first() ?: $anggota->first();
                    $staf = $anggota->filter(function ($i) use ($direktur) {
                        return $i->id !== $direktur->id;
                    });
                @endphp

                {{-- Direktur Eksekutif Card --}}
                <div
                    class="max-w-3xl mx-auto flex flex-col md:flex-row items-center gap-8 p-8 glass-card rounded-2xl shadow-sm border border-border-subtle">
                    <div
                        class="w-48 h-60 shrink-0 rounded-xl overflow-hidden shadow-lg border-4 border-white bg-slate-100 flex items-center justify-center">
                        <img class="w-full h-full object-cover" src="{{ $direktur->foto_url }}" alt="{{ $direktur->nama }}"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'" />
                        <div class="hidden w-full h-full items-center justify-center bg-slate-100 text-slate-400">
                            <span class="material-symbols-outlined text-5xl">person</span>
                        </div>
                    </div>
                    <div class="space-y-4 text-center md:text-left flex-1">
                        <div class="space-y-1">
                            <span class="text-xs font-bold text-secondary uppercase tracking-wider block">Pimpinan
                                Sekretariat</span>
                            <h4 class="font-headline-sm text-headline-sm text-primary">{{ $direktur->nama }}</h4>
                            <p class="font-label-caps text-label-caps text-primary font-bold">
                                {{ strtoupper($direktur->jabatan) }}</p>
                        </div>
                        <p class="font-body-md text-body-md text-on-surface-variant italic">
                            "Membangun tata kelola administrasi yang tertib, adaptif, dan responsif adalah kunci keberhasilan
                            koordinasi antar pemerintah provinsi se-Indonesia."
                        </p>
                    </div>
                </div>

                {{-- Jajaran Staf Sekretariat --}}
                @if($staf->isNotEmpty())
                    <div class="space-y-6 pt-4 pb-8">
                        <h4 class="text-center font-headline-sm text-headline-sm text-primary font-bold">Jajaran Bagian &amp; Staf</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl mx-auto items-stretch">
                            @foreach($staf as $s)
                                <div class="bg-white border border-border-subtle rounded-2xl p-5 text-center shadow-xs flex flex-col items-center justify-between gap-3.5 hover:shadow-md hover:border-primary/20 transition-all duration-300">
                                    {{-- Foto Staf (Proporsional & Utuh) --}}
                                    <div class="w-24 h-28 rounded-xl overflow-hidden border border-border-subtle bg-slate-50 shadow-2xs flex items-center justify-center shrink-0">
                                        <img src="{{ $s->foto_url }}" alt="{{ $s->nama }}"
                                             class="w-full h-full object-cover object-top"
                                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                                        <div class="hidden w-full h-full items-center justify-center bg-slate-100 text-slate-400">
                                            <span class="material-symbols-outlined text-3xl text-secondary">person</span>
                                        </div>
                                    </div>
                                    <div class="flex-1 flex flex-col justify-center">
                                        <h5 class="font-bold text-sm text-primary leading-snug">{{ $s->nama }}</h5>
                                        <p class="text-[11px] text-secondary font-semibold mt-1 leading-snug">{{ $s->jabatan }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            @else
                <div class="text-center text-on-surface-variant py-8 w-full">Data sekretariat belum tersedia.</div>
            @endif
        </div>
    </section>

    <!-- Tugas Pokok & Fungsi Sekretariat -->
    <section class="py-stack-lg px-margin-page max-w-max-width-content mx-auto">
        <div class="mb-10 text-center md:text-left">
            <span class="text-xs font-bold text-secondary uppercase tracking-wider block mb-1">Operasional Organisasi</span>
            <h3 class="font-headline-md text-headline-md text-primary">Tugas Pokok &amp; Fungsi Sekretariat</h3>
            <p class="font-body-md text-body-md text-on-surface-variant mt-1">Layanan teknis dan administratif dalam
                mendukung kepengurusan APPSI.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div
                class="p-6 bg-white border border-border-subtle rounded-2xl shadow-xs hover:shadow-md transition-shadow space-y-3">
                <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-2xl">assignment</span>
                </div>
                <h5 class="font-bold text-base text-primary">Penyusunan Program &amp; Data</h5>
                <p class="text-sm text-slate-600 leading-relaxed">Menyusun rencana program kerja dan menghimpun data terkait
                    isu-isu strategis penyelenggaraan pemerintahan provinsi.</p>
            </div>
            <div
                class="p-6 bg-white border border-border-subtle rounded-2xl shadow-xs hover:shadow-md transition-shadow space-y-3">
                <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-2xl">account_balance_wallet</span>
                </div>
                <h5 class="font-bold text-base text-primary">Administrasi &amp; Keuangan</h5>
                <p class="text-sm text-slate-600 leading-relaxed">Mengelola administrasi persuratan, tata usaha, keuangan,
                    perbendaharaan, dan kepegawaian internal organisasi.</p>
            </div>
            <div
                class="p-6 bg-white border border-border-subtle rounded-2xl shadow-xs hover:shadow-md transition-shadow space-y-3">
                <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-2xl">archive</span>
                </div>
                <h5 class="font-bold text-base text-primary">Pelaporan &amp; Pengarsipan</h5>
                <p class="text-sm text-slate-600 leading-relaxed">Melaksanakan tertib administrasi pelaporan berkala,
                    dokumentasi kegiatan, dan pengarsipan resmi APPSI.</p>
            </div>
            <div
                class="p-6 bg-white border border-border-subtle rounded-2xl shadow-xs hover:shadow-md transition-shadow space-y-3">
                <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-2xl">domain</span>
                </div>
                <h5 class="font-bold text-base text-primary">Sarana &amp; Prasarana</h5>
                <p class="text-sm text-slate-600 leading-relaxed">Mengelola fasilitas fisik kantor, sarana teknologi
                    informasi, serta logistik penyelenggaraan rapat dan agenda organisasi.</p>
            </div>
            <div
                class="md:col-span-2 p-6 bg-primary text-white rounded-2xl shadow-md space-y-3 flex flex-col justify-center">
                <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center text-amber-400">
                    <span class="material-symbols-outlined text-2xl">hub</span>
                </div>
                <h5 class="font-bold text-base text-amber-400">Koordinasi Antar Lembaga &amp; Daerah</h5>
                <p class="text-sm text-white/85 leading-relaxed">Membantu koordinasi intensif antar pengurus provinsi serta
                    menjalin relasi kerja sama dengan Kementerian, Lembaga Negara, BKN, LAN, dan instansi terkait lainnya.
                </p>
            </div>
        </div>
    </section>
@endsection