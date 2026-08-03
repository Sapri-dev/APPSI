@extends('layouts.app')

@section('title', 'Berita APPSI - Buka Puasa Bersama APKASI')

@push('styles')
<style>
    .article-content p {
        margin-bottom: 1.25rem;
    }
    .quote-border {
        border-left: 4px solid #E8A33D;
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="relative w-full h-[240px] md:h-[400px]">
    <img alt="Suasana Buka Puasa Bersama" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuApRNY8uiBLQb_1-bfWFLfG-2_XkBhLyeEKwG_VCeXqj19CWFKp-PxUZy5DQh_SRRRxENi3Ox7KEX875J0GjRLGxLdKwRyjLjrSigPFbQsDtZRSf_unQ62JV5iYPuHeLYB4-pUeHG9pkxul2VSp0g2V7NP4c4rowJt1zaKIxrN1IizrmgSDy-dode9jZ7uIC64qGX0oeIOq4gLGseVU9EfQZDvp9g1Ij-G6S7Royytmy-pify1u-sGOqFWABZUbfE9_PqrhtHQKQ5Y"/>
    <div class="absolute bottom-4 left-4 bg-primary px-3 py-1 text-on-primary rounded-sm shadow-md">
        <span class="font-label-caps text-label-caps tracking-widest">BERITA</span>
    </div>
</section>

<!-- Article Header -->
<article class="px-margin-page py-8 max-w-2xl mx-auto">
    <header class="mb-8">
        <h2 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-primary leading-tight mb-4">
            Ketua Umum APPSI menghadiri undangan Buka Puasa Bersama yang diselenggarakan oleh Asosiasi Pemerintah Kabupaten Seluruh Indonesia (APKASI)
        </h2>
        <div class="flex items-center gap-4 text-on-surface-variant font-label-caps text-label-caps">
            <div class="flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[18px]">person</span>
                <span>Admin</span>
            </div>
            <div class="flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[18px]">calendar_today</span>
                <span>5 March 2026</span>
            </div>
        </div>
    </header>

    <!-- Article Body -->
    <div class="article-content font-body-lg text-body-lg text-on-surface">
        <p>
            Ketua Umum Asosiasi Pemerintah Provinsi Seluruh Indonesia (APPSI) secara resmi memenuhi undangan silaturahmi dalam acara Buka Puasa Bersama yang diselenggarakan oleh Asosiasi Pemerintah Kabupaten Seluruh Indonesia (APKASI). Pertemuan ini menjadi momentum penting dalam memperkuat sinergi antara pemerintah tingkat provinsi dan kabupaten guna menyelaraskan program-program pembangunan daerah yang berkelanjutan.
        </p>
        <div class="my-10 px-6 py-4 bg-surface-container-low border-l-4 border-secondary-fixed-dim italic quote-border">
            <p class="font-body-lg text-primary font-semibold mb-0">
                "Sinergi antara provinsi dan kabupaten adalah kunci utama dalam mewujudkan tata kelola pemerintahan yang efektif. Melalui silaturahmi seperti ini, kita dapat membangun komunikasi yang lebih erat untuk menyelesaikan berbagai tantangan pembangunan di daerah secara kolektif."
            </p>
            <cite class="block mt-2 font-label-caps text-label-caps text-on-surface-variant not-italic">— Ketua Umum APPSI</cite>
        </div>
        <p>
            Acara yang berlangsung dalam suasana kekeluargaan ini dihadiri oleh jajaran pengurus pusat APKASI serta beberapa perwakilan kepala daerah dari berbagai penjuru Indonesia. Dalam sambutannya, perwakilan APKASI menyampaikan apresiasi atas kehadiran APPSI, yang menunjukkan komitmen kuat dalam menjaga harmoni antar-lembaga pemerintahan.
        </p>
        <p>
            Diskusi santai yang menyertai jamuan buka puasa tersebut mencakup berbagai isu strategis, mulai dari optimalisasi pendapatan asli daerah hingga koordinasi penanganan isu-isu sosial di tingkat akar rumput. Diharapkan, hasil dari pertemuan informal ini dapat ditindaklanjuti dalam bentuk kerja sama formal yang lebih nyata di masa mendatang.
        </p>
    </div>

    <!-- Metadata / Tags -->
    <section class="mt-12 flex flex-wrap gap-2">
        <span class="px-4 py-1.5 bg-surface-container-high text-on-surface-variant font-label-caps text-[12px] rounded-full uppercase tracking-wider">#Berita</span>
        <span class="px-4 py-1.5 bg-surface-container-high text-on-surface-variant font-label-caps text-[12px] rounded-full uppercase tracking-wider">#Silaturahmi</span>
        <span class="px-4 py-1.5 bg-surface-container-high text-on-surface-variant font-label-caps text-[12px] rounded-full uppercase tracking-wider">#Sinergi</span>
    </section>
</article>
@endsection
