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
            <span class="inline-block px-4 py-1 bg-secondary-container text-on-secondary-container font-label-caps text-label-caps rounded-full">Operasional &amp; Administrasi</span>
            <h2 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-white">Sekretariat APPSI</h2>
            <p class="font-body-lg text-body-lg text-white/80 leading-relaxed">
                Sekretariat merupakan lengan operasional APPSI yang bertugas memberikan dukungan teknis dan administrasi kepada Dewan Pengurus guna memastikan kelancaran program kerja antar provinsi di seluruh Indonesia. Berpusat di jantung Ibu Kota Jakarta, kami menjadi jembatan koordinasi strategis bagi seluruh pemerintah daerah.
            </p>
            <div class="flex flex-wrap gap-4 pt-4">
                <a href="#kontak" class="h-[56px] px-8 bg-secondary text-white font-button text-button rounded-xl hover:bg-secondary/90 transition-all flex items-center gap-2 shadow-lg active:scale-95">
                    <span class="material-symbols-outlined">location_on</span>
                    Lokasi Kantor
                </a>
            </div>
        </div>
        <div class="hidden md:block relative">
            <div class="aspect-square bg-white/5 rounded-full border border-white/10 absolute -inset-10 animate-pulse"></div>
            <div class="aspect-video w-full rounded-2xl bg-cover bg-center shadow-2xl border-4 border-white/10 relative z-10 overflow-hidden" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuA3G2X1e7PMHr6Dv2qZsAXiB0JpAAFz34ruWyO7rEemLiVU5xTJPaP3MFxR0zymSCibLviYFuVS3oDL_W-xHfnM_pk_8tv-QinclOtTA3DPovDOZuAM_iVZ05z4e5XJrl0cdFhNE0paXjqwRGZ78mPLgMVI2Qha3mU-v-Fwxiw_C3oMWrIYhSN7ysHPh3cGrA-XQxUQ16dKkF_0Q7uPjn4-8pOxSZFTY-TmSSDfM6vcs3JzfyQqat65foZIxermS1JZbrRMwnAcmGM')"></div>
        </div>
    </div>
</section>

<!-- Leadership Section -->
<section class="py-stack-lg px-margin-page bg-surface">
    <div class="max-w-max-width-content mx-auto">
        <div class="text-center mb-12 space-y-2">
            <h3 class="font-headline-md text-headline-md text-primary">Kepemimpinan Sekretariat</h3>
            <div class="w-16 h-1 bg-secondary mx-auto"></div>
        </div>
        <div class="max-w-3xl mx-auto flex flex-col md:flex-row items-center gap-8 p-8 glass-card rounded-2xl shadow-sm border border-border-subtle">
            <div class="w-48 h-64 shrink-0 rounded-xl overflow-hidden shadow-lg border-4 border-white">
                <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida/AP1WRLsgqd-HnBMu4cOBIjeT3ys5vSE_rphl68WdUScy2NeZ73LPqWrd6MHe7TrUlhN4qzKslkZ_huNFYIIQOj7auVVCUYfdIu7MpAL-r_hc3J3g1NNakGN8LYh352971GppM2iBecnqPiRf5qcmVBNHJfnYNM-TyBI-xa76vbp6D_JMDESJv2zrozBs-_hynJam5xXT4JVKxzf1omTneRP44p-FeawNWFP3rnrBghAa7W1rzlb1q8FgchqtxhQ"/>
            </div>
            <div class="space-y-4 text-center md:text-left">
                <div class="space-y-1">
                    <h4 class="font-headline-sm text-headline-sm text-primary">Drs. H. Megandi Permana, M.Si</h4>
                    <p class="font-label-caps text-label-caps text-secondary font-bold">DIREKTUR EKSEKUTIF SEKRETARIAT</p>
                </div>
                <p class="font-body-md text-body-md text-on-surface-variant italic">
                    "Membangun sinergi administrasi yang kokoh adalah fondasi bagi koordinasi antar provinsi yang efektif. Kami berkomitmen memberikan layanan terbaik bagi kemajuan otonomi daerah di Indonesia."
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Strategic Roles - Bento Grid Style -->
<section class="py-stack-lg px-margin-page max-w-max-width-content mx-auto">
    <div class="mb-12">
        <h3 class="font-headline-md text-headline-md text-primary">Peran Strategis Sekretariat</h3>
        <p class="font-body-md text-body-md text-on-surface-variant">Empat pilar utama dalam mendukung visi besar Asosiasi Pemerintah Provinsi.</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
        <!-- Role 1 -->
        <div class="md:col-span-8 p-8 bg-primary text-white rounded-2xl flex flex-col justify-between group overflow-hidden relative border border-border-subtle">
            <div class="space-y-4 relative z-10">
                <span class="material-symbols-outlined text-secondary text-[48px]">policy</span>
                <h5 class="font-headline-sm text-headline-sm">Policy Coordination</h5>
                <p class="font-body-md text-body-md text-white/80 max-w-lg">Mengkoordinasikan perumusan kebijakan strategis antar provinsi dan menjadi penghubung antara pemerintah daerah dengan pemerintah pusat.</p>
            </div>
        </div>
        <!-- Role 2 -->
        <div class="md:col-span-4 p-8 bg-white border border-border-subtle rounded-2xl hover:shadow-md transition-shadow">
            <div class="space-y-4">
                <span class="material-symbols-outlined text-primary text-[48px]">event_available</span>
                <h5 class="font-headline-sm text-headline-sm text-primary">Event Management</h5>
                <p class="font-body-md text-body-md text-on-surface-variant">Penyelenggaraan agenda nasional seperti Munas, Rakernas, dan rapat koordinasi gubernur seluruh Indonesia secara berkala.</p>
            </div>
        </div>
        <!-- Role 3 -->
        <div class="md:col-span-4 p-8 bg-white border border-border-subtle rounded-2xl hover:shadow-md transition-shadow">
            <div class="space-y-4">
                <span class="material-symbols-outlined text-primary text-[48px]">support_agent</span>
                <h5 class="font-headline-sm text-headline-sm text-primary">Administrative Support</h5>
                <p class="font-body-md text-body-md text-on-surface-variant">Pengelolaan tata usaha, kepegawaian, dan dukungan logistik bagi seluruh operasional organisasi APPSI di tingkat pusat.</p>
            </div>
        </div>
        <!-- Role 4 -->
        <div class="md:col-span-8 p-8 bg-secondary-fixed text-on-secondary-fixed rounded-2xl border border-border-subtle flex flex-col md:flex-row items-center gap-8">
            <div class="space-y-4 flex-1">
                <span class="material-symbols-outlined text-secondary text-[48px]">hub</span>
                <h5 class="font-headline-sm text-headline-sm">Inter-provincial Communication</h5>
                <p class="font-body-md text-body-md opacity-80">Membangun kanal komunikasi yang lancar dan cepat antar sekretaris daerah serta dinas terkait di 38 provinsi di seluruh Nusantara.</p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Information Section -->
<section id="kontak" class="py-stack-lg px-margin-page bg-primary-container relative text-white">
    <div class="max-w-max-width-content mx-auto grid md:grid-cols-2 gap-12 items-center relative z-10">
        <div class="space-y-8">
            <div>
                <h3 class="font-headline-md text-headline-md text-white mb-4">Hubungi Sekretariat</h3>
                <p class="font-body-md text-body-md text-white/70">Pintu kami selalu terbuka untuk koordinasi dan layanan informasi publik terkait Asosiasi Pemerintah Provinsi Seluruh Indonesia.</p>
            </div>
            <div class="space-y-6">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-secondary rounded-xl flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-white">location_on</span>
                    </div>
                    <div>
                        <h6 class="font-label-caps text-label-caps text-white/50 mb-1">ALAMAT KANTOR</h6>
                        <p class="font-body-md text-body-md text-white font-semibold leading-snug">Gedung Nyi Ageng Serang Lt. 4, Jl. HR. Rasuna Said Kav. 22 C, Jakarta Selatan.</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-secondary">call</span>
                        </div>
                        <div>
                            <h6 class="font-label-caps text-label-caps text-white/50 mb-1">TELEPON</h6>
                            <p class="font-body-md text-body-md text-white font-bold">021- 2168 4200</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-secondary">fax</span>
                        </div>
                        <div>
                            <h6 class="font-label-caps text-label-caps text-white/50 mb-1">FAX</h6>
                            <p class="font-body-md text-body-md text-white font-bold">021- 2598 4843</p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-4 p-4 bg-white/5 rounded-xl border border-white/10">
                    <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-primary">mail</span>
                    </div>
                    <div>
                        <h6 class="font-label-caps text-label-caps text-white/50 mb-1">EMAIL RESMI</h6>
                        <p class="font-body-md text-body-md text-white font-bold text-lg">info@appsi.or.id</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="rounded-3xl overflow-hidden h-96 shadow-2xl border-8 border-white/10 relative">
            <div class="w-full h-full bg-cover bg-center" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuB8llVNT9-O_E02IeI5lKA17TgZq8-nthHy7LQ705l3FAXdaqWbEIok6HHSDVChmfw6SW9iVN3r2NpMXj18OtXo4XEVdJ-ieCBVOps5DY0h9SbxvQNBmGEns6EGPGH8GnBu5fM1-MGU57wYZc0_UmfQT62SM52kUincGAfNoV4JYeROHts4BjFgffAxZBG1FBX7CAlP4WRySKEqfoyxdppSz72veEmjEkg1w_IIYLy1WL8mGYm_M57Vij7Mlit0WeNXSE088N-vWmQ')"></div>
            <div class="absolute bottom-4 left-4 right-4 bg-white p-4 rounded-xl shadow-lg flex items-center justify-between text-primary">
                <span class="font-body-md text-body-md font-bold">Lihat di Google Maps</span>
                <span class="material-symbols-outlined text-secondary">open_in_new</span>
            </div>
        </div>
    </div>
</section>
@endsection
