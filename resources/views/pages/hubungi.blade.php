@extends('layouts.app')

@section('title', 'Hubungi Kami - APPSI')

@push('styles')
<style>
    .bg-navy-overlay {
        background: linear-gradient(to right, rgba(0, 22, 71, 0.95), rgba(12, 42, 107, 0.7));
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="relative h-[280px] md:h-[350px] flex items-center overflow-hidden">
    <div class="absolute inset-0 z-0">
        <div class="w-full h-full bg-cover bg-center" style="background-image: url('https://lh3.googleusercontent.com/aida/AP1WRLsyPVqAVLr3zusD5tva2E4nAeNu061TUBRjKCQkBRLNq4TTutpbWcpP_jOGBd5AvxrQMvF4obv6ObJMfVpFf7moaTgvo21NSuc058GXU25JBuOq_YFVECLwvlnv9h2nfCDpIWpWFZ-77IOsHK0VnJj-5MdDsv6QOP7O5mBY271m9jYGd8D9kwqWm8tnzwGe8Jn54zYH-b1929KOxFwsydmMZN5G4s_CEIO4w6_USm6pc97vSvORAvnZIQ')"></div>
        <div class="absolute inset-0 bg-navy-overlay"></div>
    </div>
    <div class="relative z-10 w-full max-w-[1200px] mx-auto px-margin-page">
        <div class="max-w-2xl">
            <h1 class="font-headline-lg text-headline-lg text-on-primary mb-stack-sm md:text-headline-lg lg:text-[48px]">Hubungi Kami</h1>
            <p class="font-body-lg text-body-lg text-on-primary/90">
                Kami siap mendukung sinergi kebijakan dan aspirasi daerah untuk memperkuat tata kelola pemerintahan provinsi di seluruh Indonesia.
            </p>
            <div class="mt-stack-md w-20 h-1 bg-secondary-container"></div>
        </div>
    </div>
</section>

<!-- Content Grid -->
<section class="max-w-[1200px] mx-auto px-margin-page -mt-20 relative z-20">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter">
        <!-- Contact Info Cards (Left Column) -->
        <div class="lg:col-span-4 flex flex-col gap-gutter">
            <!-- Address Card -->
            <div class="bg-surface-white border border-border-subtle p-stack-md rounded-xl shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-secondary-container/10 flex items-center justify-center rounded-lg mb-4">
                    <span class="material-symbols-outlined text-secondary" style="font-variation-settings: 'FILL' 1;">location_on</span>
                </div>
                <h3 class="font-headline-sm text-headline-sm mb-2">Alamat Kantor</h3>
                <p class="font-body-md text-body-md text-on-surface-variant">
                    Gedung Nyi Ageng Serang Lt. 4,<br/>
                    Jl. HR. Rasuna Said Kav. 22 C<br/>
                    Jakarta Selatan, Indonesia 12940
                </p>
            </div>
            <!-- Phone Card -->
            <div class="bg-surface-white border border-border-subtle p-stack-md rounded-xl shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-secondary-container/10 flex items-center justify-center rounded-lg mb-4">
                    <span class="material-symbols-outlined text-secondary" style="font-variation-settings: 'FILL' 1;">call</span>
                </div>
                <h3 class="font-headline-sm text-headline-sm mb-2">Telepon &amp; Fax</h3>
                <div class="font-body-md text-body-md text-on-surface-variant">
                    <p>Telp: 021- 2168 4200</p>
                    <p>Fax: 021- 2598 4843</p>
                </div>
            </div>
            <!-- Email Card -->
            <div class="bg-surface-white border border-border-subtle p-stack-md rounded-xl shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-secondary-container/10 flex items-center justify-center rounded-lg mb-4">
                    <span class="material-symbols-outlined text-secondary" style="font-variation-settings: 'FILL' 1;">mail</span>
                </div>
                <h3 class="font-headline-sm text-headline-sm mb-2">Email Resmi</h3>
                <p class="font-body-md text-body-md text-on-surface-variant">
                    info@appsi.or.id
                </p>
            </div>
        </div>

        <!-- Contact Form (Right Column) -->
        <div class="lg:col-span-8">
            <div class="bg-surface-white border border-border-subtle p-stack-md md:p-stack-lg rounded-xl shadow-sm h-full">
                <h2 class="font-headline-md text-headline-md mb-stack-sm text-primary">Kirim Pesan</h2>
                <p class="font-body-md text-body-md text-on-surface-variant mb-stack-lg">
                    Silakan lengkapi formulir di bawah ini untuk pertanyaan atau aspirasi terkait program kerja APPSI.
                </p>
                <form class="space-y-6" id="contactForm">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block font-label-caps text-label-caps text-on-surface-variant mb-2">NAMA LENGKAP</label>
                            <input class="w-full bg-surface-container-low border-none focus:ring-2 focus:ring-primary rounded-lg py-3 px-4 transition-all" placeholder="Masukkan nama Anda" type="text"/>
                        </div>
                        <div>
                            <label class="block font-label-caps text-label-caps text-on-surface-variant mb-2">EMAIL</label>
                            <input class="w-full bg-surface-container-low border-none focus:ring-2 focus:ring-primary rounded-lg py-3 px-4 transition-all" placeholder="email@contoh.com" type="email"/>
                        </div>
                    </div>
                    <div>
                        <label class="block font-label-caps text-label-caps text-on-surface-variant mb-2">SUBJEK</label>
                        <input class="w-full bg-surface-container-low border-none focus:ring-2 focus:ring-primary rounded-lg py-3 px-4 transition-all" placeholder="Pilih topik pesan Anda" type="text"/>
                    </div>
                    <div>
                        <label class="block font-label-caps text-label-caps text-on-surface-variant mb-2">PESAN</label>
                        <textarea class="w-full bg-surface-container-low border-none focus:ring-2 focus:ring-primary rounded-lg py-3 px-4 transition-all" placeholder="Tuliskan pesan Anda di sini..." rows="5"></textarea>
                    </div>
                    <button class="w-full md:w-auto bg-secondary-container text-on-secondary-container font-button text-button px-stack-lg py-4 rounded-lg hover:brightness-110 active:scale-[0.98] transition-all flex items-center justify-center gap-2" type="submit">
                        Kirim Pesan
                        <span class="material-symbols-outlined">send</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Google Maps Integration -->
<section class="max-w-[1200px] mx-auto px-margin-page mt-stack-lg">
    <div class="overflow-hidden rounded-xl border border-border-subtle bg-surface-white h-[450px] relative shadow-sm">
        <div class="w-full h-full bg-surface-container-high flex flex-col items-center justify-center text-center p-stack-lg">
            <span class="material-symbols-outlined text-[64px] text-primary/20 mb-4">map</span>
            <h3 class="font-headline-sm text-headline-sm text-primary">Lokasi Sekretariat</h3>
            <p class="font-body-md text-body-md text-on-surface-variant max-w-sm mx-auto mb-6">Gedung Nyi Ageng Serang Lt. 4, Kuningan, Jakarta Selatan</p>
            <a class="font-button text-button text-primary border-2 border-primary px-6 py-2 rounded-lg hover:bg-primary hover:text-on-primary transition-all" href="#">
                Buka di Google Maps
            </a>
        </div>
        <div class="absolute inset-0 pointer-events-none opacity-20 bg-[radial-gradient(#001647_1px,transparent_1px)] [background-size:20px_20px]"></div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.getElementById('contactForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = this.querySelector('button');
        const originalText = btn.innerHTML;
        
        btn.innerHTML = 'Mengirim...';
        btn.disabled = true;
        
        setTimeout(() => {
            btn.innerHTML = '<span class="material-symbols-outlined">check_circle</span> Terkirim';
            btn.classList.replace('bg-secondary-container', 'bg-green-600');
            btn.classList.replace('text-on-secondary-container', 'text-white');
            
            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.classList.replace('bg-green-600', 'bg-secondary-container');
                btn.classList.replace('text-white', 'text-on-secondary-container');
                btn.disabled = false;
                this.reset();
            }, 3000);
        }, 1500);
    });
</script>
@endpush
