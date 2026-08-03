@extends('layouts.app')

@section('title', 'Berita & Siaran Pers - APPSI')

@section('content')
<div class="max-w-[1200px] mx-auto px-margin-page">
    <!-- Featured News Hero -->
    <section class="mt-stack-lg">
        <div class="relative group overflow-hidden rounded-xl bg-surface-white border border-border-subtle shadow-sm transition-transform duration-300 hover:shadow-md">
            <div class="grid md:grid-cols-12 gap-0 overflow-hidden">
                <div class="md:col-span-7 h-[300px] md:h-[450px] relative">
                    <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBjD_Tdu2tWikk2u9WQCBXA3NShJQ-QDlQjiJATChaYzMJ4pxGs8pZzb0ucEobqEDHKKsFo9v1h2i-2qOxUlagL77wSLNOCE-wTNbmJ7htx2ka9E_kSPhbhDpurjzcT1k44EupoLJcPKK8_0V5i_rQ2Dewairc886wX96Z07H6y2XQCcYvSdmZp2XnVMaDxl1mp7ToXtrvbApGOAl6zZZyoGcvWbgiMjs9zKK6XolBISYS0e6rqwh5BoWaHN4WYICBWlQIgNbYOrsQ"/>
                    <div class="absolute top-4 left-4">
                        <span class="bg-secondary text-on-secondary px-3 py-1 rounded-full text-label-caps font-label-caps">SOROTAN UTAMA</span>
                    </div>
                </div>
                <div class="md:col-span-5 p-stack-md md:p-stack-lg flex flex-col justify-center bg-surface-white">
                    <span class="text-on-surface-variant font-label-caps text-label-caps mb-2">28 MEI 2024 • SIARAN PERS</span>
                    <h1 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-primary mb-4 leading-tight">
                        Gubernur Se-Indonesia Bahas Strategi Ketahanan Pangan Nasional
                    </h1>
                    <p class="text-on-surface-variant font-body-md text-body-md mb-6 line-clamp-3">
                        Pertemuan strategis ini merumuskan sinergi antar pemerintah provinsi dalam menghadapi tantangan logistik dan produksi pangan guna menjaga stabilitas harga di seluruh wilayah Indonesia.
                    </p>
                    <a href="{{ route('artikel') }}" class="w-fit bg-secondary-container text-on-secondary-container px-6 py-3 rounded-xl font-button text-button hover:opacity-90 transition-opacity flex items-center gap-2">
                        Baca Selengkapnya
                        <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Category Filter -->
    <section class="mt-stack-md mb-stack-md">
        <div class="flex items-center gap-4 overflow-x-auto hide-scrollbar py-2">
            <button class="filter-btn whitespace-nowrap px-6 py-2 rounded-full bg-primary text-on-primary font-label-caps text-label-caps shadow-sm">Semua</button>
            <button class="filter-btn whitespace-nowrap px-6 py-2 rounded-full bg-surface-white border border-border-subtle text-on-surface-variant hover:bg-surface-container-high transition-colors font-label-caps text-label-caps">Siaran Pers</button>
            <button class="filter-btn whitespace-nowrap px-6 py-2 rounded-full bg-surface-white border border-border-subtle text-on-surface-variant hover:bg-surface-container-high transition-colors font-label-caps text-label-caps">Berita Provinsi</button>
            <button class="filter-btn whitespace-nowrap px-6 py-2 rounded-full bg-surface-white border border-border-subtle text-on-surface-variant hover:bg-surface-container-high transition-colors font-label-caps text-label-caps">Kegiatan Sekretariat</button>
            <button class="filter-btn whitespace-nowrap px-6 py-2 rounded-full bg-surface-white border border-border-subtle text-on-surface-variant hover:bg-surface-container-high transition-colors font-label-caps text-label-caps">Opini & Artikel</button>
        </div>
    </section>

    <!-- News List -->
    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- News Card 1 -->
        <a href="{{ route('artikel') }}" class="bg-surface-white border border-border-subtle rounded-xl overflow-hidden flex flex-col hover:shadow-lg transition-all group">
            <div class="h-48 overflow-hidden relative">
                <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA1mt7R8sXAezg9unOfMZjlucQ9hEtOf1VMQLeDGw4c3KJ2vryW4aHEAMqdNw9Wwh_2OGIrLauODB4cvQxe7kyQP_T2gENnsE0tT2QmUGgV05mskY0A2pBMfD7YcAPZ6P2ziRaTHGqj4zwJ9idIdCHQilzvdQEyCIWiD9nb-83WpmiqsdOHaD-ZNER_Z5iaMbxCBKAaMdJHCNdXG7HMlDCWC4SSoi2t0pTYiq6VkPnk4fnlREzCQkjf6NSJymFMrkufaGBRXJUOf-I"/>
                <span class="absolute top-3 left-3 bg-secondary-container/90 text-on-secondary-container text-[11px] font-bold px-2 py-1 rounded">PROVINSI</span>
            </div>
            <div class="p-5 flex flex-col flex-grow">
                <span class="text-on-surface-variant font-label-caps text-label-caps mb-2 text-[12px]">24 MEI 2024</span>
                <h3 class="font-headline-sm text-headline-sm text-primary mb-3 line-clamp-2 group-hover:text-secondary transition-colors">Penyempurnaan Platform Digital untuk Pemerintah Daerah</h3>
                <p class="text-on-surface-variant font-body-md text-body-md line-clamp-2 mb-4">Sekretariat APPSI meluncurkan pembaruan portal koordinasi digital antar provinsi untuk mempercepat pelaporan pembangunan.</p>
                <div class="mt-auto pt-4 border-t border-border-subtle flex justify-between items-center">
                    <span class="text-primary font-bold text-label-caps">BACA</span>
                    <span class="material-symbols-outlined text-primary text-xl">trending_flat</span>
                </div>
            </div>
        </a>

        <!-- News Card 2 -->
        <a href="{{ route('artikel') }}" class="bg-surface-white border border-border-subtle rounded-xl overflow-hidden flex flex-col hover:shadow-lg transition-all group">
            <div class="h-48 overflow-hidden relative">
                <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBw3VHHO4uzPQA6m6rkDGWUrt-jnLbR2cZs2fu7_vFzeFJw9PhrSXdR3EpLVpjdb8hgy0jE8ZTccyA6BjBDWjDEzXPXTMo6ImAibnDNegQm6WgdscW06tmHUkqrNqvj5RCGwW6MPei20EsmFWeJgDxDtNFZxrApmR4PSoZqEFCDIM2aSpPGbIYSnPWktZFqBbe_eA55KJZ5VPApQkvQ5ghYLfaXW2R8TkHZ9zJgj43_a8BpuIpDNFhI6bVCLr7-qLCDysxiJ3_yuQE"/>
                <span class="absolute top-3 left-3 bg-tertiary-container/90 text-on-tertiary-container text-[11px] font-bold px-2 py-1 rounded">SIARAN PERS</span>
            </div>
            <div class="p-5 flex flex-col flex-grow">
                <span class="text-on-surface-variant font-label-caps text-label-caps mb-2 text-[12px]">22 MEI 2024</span>
                <h3 class="font-headline-sm text-headline-sm text-primary mb-3 line-clamp-2 group-hover:text-secondary transition-colors">Sinergi Kebijakan Antar Provinsi di Era Baru</h3>
                <p class="text-on-surface-variant font-body-md text-body-md line-clamp-2 mb-4">Forum komunikasi gubernur menekankan pentingnya standarisasi pelayanan publik berbasis teknologi di seluruh wilayah.</p>
                <div class="mt-auto pt-4 border-t border-border-subtle flex justify-between items-center">
                    <span class="text-primary font-bold text-label-caps">BACA</span>
                    <span class="material-symbols-outlined text-primary text-xl">trending_flat</span>
                </div>
            </div>
        </a>

        <!-- News Card 3 -->
        <a href="{{ route('artikel') }}" class="bg-surface-white border border-border-subtle rounded-xl overflow-hidden flex flex-col hover:shadow-lg transition-all group">
            <div class="h-48 overflow-hidden relative">
                <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA8n41gZVfeE_ziBsiOPbpO0rdpxETfYPZ7wHFpj6fNASpfn6yJMjZxzlLdN74AKVUHW59Pn_t3XuMzQwwKoZq0ByfetElPBBsS-09J8_EhvmplQr9SM2EvstHyh-8nivV27nH-_7GOAsRC4fzo-nOSynnAF0tdXxNxhlk0oP7UuNEggsnRxQQpnPKD4TeFx_i2F0Exler9JBaLCaKOegAsEeQmvisBHw4DdjRn1VoHWzVF3tUNipHezkPxn2tdkw2rn6d6tTvq3MM"/>
                <span class="absolute top-3 left-3 bg-secondary-container/90 text-on-secondary-container text-[11px] font-bold px-2 py-1 rounded">KEGIATAN</span>
            </div>
            <div class="p-5 flex flex-col flex-grow">
                <span class="text-on-surface-variant font-label-caps text-label-caps mb-2 text-[12px]">20 MEI 2024</span>
                <h3 class="font-headline-sm text-headline-sm text-primary mb-3 line-clamp-2 group-hover:text-secondary transition-colors">Rapat Kerja Nasional APPSI Evaluasi Capaian Semester I</h3>
                <p class="text-on-surface-variant font-body-md text-body-md line-clamp-2 mb-4">Sekretariat APPSI memaparkan laporan efektivitas kolaborasi regional dalam mendukung pemulihan ekonomi nasional.</p>
                <div class="mt-auto pt-4 border-t border-border-subtle flex justify-between items-center">
                    <span class="text-primary font-bold text-label-caps">BACA</span>
                    <span class="material-symbols-outlined text-primary text-xl">trending_flat</span>
                </div>
            </div>
        </a>
    </section>

    <!-- Pagination -->
    <div class="mt-stack-lg flex justify-center">
        <button class="flex items-center gap-3 px-8 py-4 bg-surface-white border border-border-subtle rounded-full text-primary font-button text-button hover:bg-surface-container-low active:scale-95 transition-all shadow-sm">
            Muat Lebih Banyak
            <span class="material-symbols-outlined">expand_more</span>
        </button>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const filterButtons = document.querySelectorAll('.filter-btn');
    filterButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            filterButtons.forEach(b => {
                b.classList.remove('bg-primary', 'text-on-primary');
                b.classList.add('bg-surface-white', 'border', 'border-border-subtle', 'text-on-surface-variant');
            });
            btn.classList.add('bg-primary', 'text-on-primary');
            btn.classList.remove('bg-surface-white', 'border', 'border-border-subtle', 'text-on-surface-variant');
        });
    });
</script>
@endpush
