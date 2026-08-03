@extends('layouts.app')

@section('title', 'Dewan Penasehat APPSI 2025-2029')

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
                    Periode 2025 – 2029
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
            <!-- Member 1 -->
            <div class="bg-surface-white border border-border-subtle rounded-xl p-6 hover:shadow-lg transition-all duration-300 group">
                <div class="flex flex-col items-center text-center">
                    <div class="w-24 h-24 rounded-full bg-surface-container-low mb-4 overflow-hidden border-2 border-primary/10 group-hover:border-secondary transition-colors">
                        <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA3brFNpWf8oo7W_4nx_M2AqJBGpOsP1i1ADg36W7TQ9zH8ZgIRq9QshXkI48xEYrzeiVqy5noeUgy1q_ELAe512yWQieTLDqUCxeTPbVw6Ng9v4LgCe0ui2v1ee-1IV-GM9oZcaG4Y8QUKNJznLKYY2SWnGbiDkbSn7ToBm85n876AeOHOMc4euRCMZxbMaTmIaXJ1rovHChIQ4Fn-6wwofB2do6wgJgNRUBFxVlVY3WfW4hjzL2_vJInNvrKFLsXp_-dgtGbBZcY"/>
                    </div>
                    <h3 class="font-headline-sm text-headline-sm text-primary mb-1">Sri Sultan Hamengku Buwono X</h3>
                    <p class="font-label-caps text-label-caps text-secondary">Gubernur DIY</p>
                </div>
            </div>
            <!-- Member 2 -->
            <div class="bg-surface-white border border-border-subtle rounded-xl p-6 hover:shadow-lg transition-all duration-300 group">
                <div class="flex flex-col items-center text-center">
                    <div class="w-24 h-24 rounded-full bg-surface-container-low mb-4 overflow-hidden border-2 border-primary/10 group-hover:border-secondary transition-colors">
                        <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDBf0SaHwyYjad9JIWG3nouSPyAO5e1eUL-opKMuoQtvJbDzIRRiPmT0aV6Ln9Z1B_1_cdCYkhFLISA2IpdmjAgK_Vy6Z7gwO1vXmUtIVPoN0Qg8DZ9eNz6He2nnqd15QVRR5YrSWGkuGNl75wRpvgnU7GBaA2z7Drc1P6saaYxPqdE4Xghfun772qOReskyTqhNkziHoTMdbP6G4EqgV7bT_u6RZz7gvOBmixFYzrMXRxfGyvxkQS2--S8QzTOjBeCvyuzEhKGhKQ"/>
                    </div>
                    <h3 class="font-headline-sm text-headline-sm text-primary mb-1">Dr. Ir. Pramono Anung, MM.</h3>
                    <p class="font-label-caps text-label-caps text-secondary">Gubernur DKI Jakarta</p>
                </div>
            </div>
            <!-- Member 3 -->
            <div class="bg-surface-white border border-border-subtle rounded-xl p-6 hover:shadow-lg transition-all duration-300 group">
                <div class="flex flex-col items-center text-center">
                    <div class="w-24 h-24 rounded-full bg-surface-container-low mb-4 overflow-hidden border-2 border-primary/10 group-hover:border-secondary transition-colors">
                        <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAKo6RLW55wByeNSq1imqcZaRWaGFpW4QRTeVGRGFZN8FELDDDJ5Lgf4El2-QpPexJGU0i92ecLRuYsMfBE661JuEmLd4DthHbFivgDI9NHuhmXOOp2PD9FaYyNzhGbZJy4L2SvTLuIwqXhJdWUnvl2LpcC-JJjNPvyAB8gdPrfrrsDMFB7y43Rq22kWhi28z9Wav7clYCKb0EXUVO13T7hQjCKF4oBYLpoe_ErMAsT1LmrRmQ_Z8KBjIOuYbzveIqM2mYHGwV8fOk"/>
                    </div>
                    <h3 class="font-headline-sm text-headline-sm text-primary mb-1">H. Mahyeldi Ansharullah, S.P</h3>
                    <p class="font-label-caps text-label-caps text-secondary">Gubernur Sumatera Barat</p>
                </div>
            </div>
            <!-- Member 4 -->
            <div class="bg-surface-white border border-border-subtle rounded-xl p-6 hover:shadow-lg transition-all duration-300 group">
                <div class="flex flex-col items-center text-center">
                    <div class="w-24 h-24 rounded-full bg-surface-container-low mb-4 overflow-hidden border-2 border-primary/10 group-hover:border-secondary transition-colors">
                        <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA33sQE4LB9U83iGdndBVtEItPpzBNOd53bTWUbLIKdp9KjogHcD-Yiyins7FVKYrvor_29ybu_r633GTtHI4FPjuV9waizTYMuS8z0VSXn1-FqWCqtcLCk-FJMQZB0iWsksRW9uuM425qusuKVeBtkJYqzL8I2yaZd0w4_66zNcIiktgjTcGOPUA_Tls0puoG40rYsv0H2ogkKjsdg759T0slfAnnQ1saujbbd9dMCMqPaDpJbJO3OBbrpbSHp0-5i6M-uaq1mDWE"/>
                    </div>
                    <h3 class="font-headline-sm text-headline-sm text-primary mb-1">H. Muzakir Manaf</h3>
                    <p class="font-label-caps text-label-caps text-secondary">Gubernur Aceh</p>
                </div>
            </div>
            <!-- Member 5 -->
            <div class="bg-surface-white border border-border-subtle rounded-xl p-6 hover:shadow-lg transition-all duration-300 group">
                <div class="flex flex-col items-center text-center">
                    <div class="w-24 h-24 rounded-full bg-surface-container-low mb-4 overflow-hidden border-2 border-primary/10 group-hover:border-secondary transition-colors">
                        <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDRYCiKsrcSxRJACMUrGZ4z6Mc38gUYmAAereUcLRrc5_29j22AEgrIJZh9vhA3_dLYPAIo0C90jWb0AD41EOyP3fM_46NP2EFu-GahhzFxqvPFhVRLipzKEjQUzbmix7o8R2_ivr4-8X0XZsoRbn4XAUiX-b9LlORm0fmwGO9vwYR9iMrAY-3DxE6fcmdWcfKFZHK0rfnnQe8lgTIdQ2WBdjbtCxqjkWU9VKm-zr18OPKfcTz_40ehZ3cwKsSmDALYuGlyjM-ttoE"/>
                    </div>
                    <h3 class="font-headline-sm text-headline-sm text-primary mb-1">Dr. John Tabo, SE., MBA.</h3>
                    <p class="font-label-caps text-label-caps text-secondary">Gubernur Papua Pegunungan</p>
                </div>
            </div>
            <!-- Member 6 -->
            <div class="bg-surface-white border border-border-subtle rounded-xl p-6 hover:shadow-lg transition-all duration-300 group">
                <div class="flex flex-col items-center text-center">
                    <div class="w-24 h-24 rounded-full bg-surface-container-low mb-4 overflow-hidden border-2 border-primary/10 group-hover:border-secondary transition-colors">
                        <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDHXbEkDwP_xVefrDR4HbtZNfjFzWdfqKBEBO0LawfP7XKTLnZd_zuK_0lagd4bPPJNezXhjU0kU5jsr9ZKZkD4XVNv_56iTPPf4Wwi6bziBJ53Gw-gDtHtuW1XEoSS58zDsoLkUVFJjgAjq029sMiXWrXhCF8d763YCrn-4nqCJhIEx1L_Dy1LyOvOWpFyWQE6GAlwENY0TXYi0IlPYmE5wcjLh88ShnCEiXz7YQGaG--SiD2yfd-AbYUpRcAAYhwTYChPn4Eqoj8"/>
                    </div>
                    <h3 class="font-headline-sm text-headline-sm text-primary mb-1">E. Melkiades Laka Lena, S.Si</h3>
                    <p class="font-label-caps text-label-caps text-secondary">Gubernur NTT</p>
                </div>
            </div>
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
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-secondary-fixed mt-1">verified_user</span>
                        <span class="font-body-md text-body-md">Memberikan nasihat dan pertimbangan strategis kepada Dewan Pengurus APPSI.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-secondary-fixed mt-1">insights</span>
                        <span class="font-body-md text-body-md">Memberikan pandangan terhadap arah kebijakan organisasi dan isu-isu strategis nasional.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-secondary-fixed mt-1">shield</span>
                        <span class="font-body-md text-body-md">Menjaga konsistensi nilai, visi, dan misi APPSI.</span>
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
