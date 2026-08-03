@extends('layouts.app')

@section('title', 'Beranda - APPSI')

@section('content')
<!-- Hero Slider (Mobile Optimized) -->
<section class="relative w-full px-4 mt-4 max-w-[1200px] mx-auto">
    <div class="relative w-full rounded-2xl overflow-hidden shadow-xl" style="aspect-ratio: 16/9; min-height: 180px;">
        <!-- Slider Container -->
        <div class="absolute inset-0 flex transition-transform duration-500">
            <!-- Slide 1 -->
            <div class="relative min-w-full h-full">
                <img alt="Aerial view of Indonesian city" class="absolute inset-0 w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBKN6XRe6dFjEBfPyUa68Lh9xfD3hPZQjyu6bB-yvMcVe_FmbyG-TNhwNFbcbuZ-RVbU7l0rZN0PO7tDYaklP67e3FV3bV4D49A7L1DosqL52GU37_r9AP21inDyRYdqoTHAtcjb6Z3I_SG-Hni81PyfErYrmQsV4VWW_KBjFDgPjLrFN6cXw7wcvVk4hXxCo8Im5riWzJQLL21_QaDdKVl3EdkLl-G5Cz4Ic8W_J0HhZoYqZcARj5qoQHD-Mw3MUoC9tS2oI4mL6A">
            </div>
            <!-- Slide 2 -->
            <div class="relative min-w-full h-full">
                <img alt="Meeting of Indonesian governors" class="absolute inset-0 w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBKN6XRe6dFjEBfPyUa68Lh9xfD3hPZQjyu6bB-yvMcVe_FmbyG-TNhwNFbcbuZ-RVbU7l0rZN0PO7tDYaklP67e3FV3bV4D49A7L1DosqL52GU37_r9AP21inDyRYdqoTHAtcjb6Z3I_SG-Hni81PyfErYrmQsV4VWW_KBjFDgPjLrFN6cXw7wcvVk4hXxCo8Im5riWzJQLL21_QaDdKVl3EdkLl-G5Cz4Ic8W_J0HhZoYqZcARj5qoQHD-Mw3MUoC9tS2oI4mL6A">
            </div>
            <div class="relative min-w-full h-full">
                <img alt="APPSI Activity" class="absolute inset-0 w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBKN6XRe6dFjEBfPyUa68Lh9xfD3hPZQjyu6bB-yvMcVe_FmbyG-TNhwNFbcbuZ-RVbU7l0rZN0PO7tDYaklP67e3FV3bV4D49A7L1DosqL52GU37_r9AP21inDyRYdqoTHAtcjb6Z3I_SG-Hni81PyfErYrmQsV4VWW_KBjFDgPjLrFN6cXw7wcvVk4hXxCo8Im5riWzJQLL21_QaDdKVl3EdkLl-G5Cz4Ic8W_J0HhZoYqZcARj5qoQHD-Mw3MUoC9tS2oI4mL6A">
            </div>
        </div>
        <!-- Slider Navigation Dots -->
        <div class="absolute bottom-6 left-0 right-0 flex justify-center gap-2 z-10">
            <div class="w-2 h-2 rounded-full bg-on-primary"></div>
            <div class="w-2 h-2 rounded-full bg-on-primary/40"></div>
        </div>
        <!-- Slider Arrows (Visual Only) -->
        <div class="absolute inset-y-0 left-4 flex items-center">
            <button class="w-10 h-10 rounded-full bg-surface-white/10 text-on-primary flex items-center justify-center hover:bg-surface-white/20 transition-colors">
                <span class="material-symbols-outlined">chevron_left</span>
            </button>
        </div>
        <div class="absolute inset-y-0 right-4 flex items-center">
            <button class="w-10 h-10 rounded-full bg-surface-white/10 text-on-primary flex items-center justify-center hover:bg-surface-white/20 transition-colors">
                <span class="material-symbols-outlined">chevron_right</span>
            </button>
        </div>
    </div>
</section>

<!-- Quick Stats -->
<section class="px-4 mt-6 max-w-[1200px] mx-auto">
    <div class="bg-surface-container-low border-l-4 border-secondary p-8 rounded-xl shadow-sm">
        <div class="flex flex-col gap-4">
            <span class="material-symbols-outlined text-secondary/40 text-4xl">format_quote</span>
            <p class="font-headline-sm text-headline-sm text-primary italic leading-relaxed">
                "Amanah ini bukan sekadar kehormatan, tetapi juga tanggung jawab besar untuk memajukan daerah-daerah di seluruh Indonesia,"
            </p>
            <div class="flex items-center gap-3 mt-2">
                <div class="w-8 h-px bg-outline-variant"></div>
                <p class="font-label-caps text-label-caps text-on-surface-variant font-bold uppercase tracking-wider">
                    H Rudy Mas’ud
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Tentang APPSI -->
<section class="py-stack-lg px-4 max-w-[1200px] mx-auto flex flex-col gap-6">
    <div class="flex flex-col gap-4">
        <h2 class="font-headline-md text-headline-md text-primary">Mengenal APPSI</h2>
        <div class="w-16 h-1 bg-secondary"></div>
    </div>
    <div class="flex flex-col gap-4 mb-6">
        <div class="relative rounded-2xl overflow-hidden shadow-lg border border-border-subtle">
            <img alt="Ketua Umum APPSI" class="w-full h-64 object-cover object-top" src="https://lh3.googleusercontent.com/aida/AP1WRLuM4vvmjuvwv9tx1H9SkUwNSv-CAQsApQ--MbsZVWb250BVjZp8YXyh7Mx816Ccy8iyr_tu1FdY6A8K8Z69p3UJbnVW2tNMYWPzHg0ewSx9UBd4EYMrYe9ZPC1fr3TuR8Di2_qSwBlL6eAMSzsvIm_9ImdcXFuPJPDeU7C4iiIsKZASlAuHQ0u381wWU_p1xq7KFbR9b59hKmgZXbVoXy3ZVflMDDjrazddYX4vXnR_V4xriJwBJNx1Fr4">
            <div class="absolute bottom-0 left-0 right-0 bg-primary-container/80 p-4 text-on-primary">
                <p class="font-label-caps text-label-caps text-secondary mb-1">KETUA UMUM APPSI</p>
                <p class="font-headline-sm text-headline-sm">Prof. Dr. H. Al Muktabar, M.Sc.</p>
            </div>
        </div>
    </div>
    <div class="flex flex-col gap-4">
        <p class="font-body-lg text-body-lg text-on-surface">Asosiasi Pemerintah Provinsi Seluruh Indonesia (APPSI) merupakan wadah kerjasama antar Pemerintah Provinsi dan sarana komunikasi Pemerintah Provinsi dengan Pemerintah Pusat.</p>
        <p class="font-body-lg text-body-lg text-on-surface">APPSI berkomitmen untuk terus mendorong percepatan pembangunan di daerah melalui koordinasi yang solid dan pertukaran kebijakan yang inovatif antar Gubernur se-Indonesia.</p>
    </div>
</section>

<!-- Visi & Misi -->
<section class="bg-surface-container-low py-stack-lg px-4">
    <div class="max-w-[1200px] mx-auto">
        <div class="bg-secondary-fixed/30 p-8 rounded-2xl border border-secondary/20 mb-8">
            <span class="font-label-caps text-label-caps text-secondary mb-2 block uppercase">Visi APPSI</span>
            <p class="font-headline-md text-headline-md text-primary leading-tight">Mewujudkan Pemerintahan Provinsi yang Handal dan Sejahtera dalam Bingkai NKRI.</p>
        </div>
        <h3 class="font-headline-sm text-headline-sm text-primary mb-4">Misi Utama</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-surface-white border border-border-subtle p-6 rounded-xl">
                <span class="material-symbols-outlined text-primary mb-3">handshake</span>
                <p class="font-body-md text-body-md font-bold text-primary mb-1">Penguatan Koordinasi</p>
                <p class="font-body-md text-body-md text-on-surface-variant">Meningkatkan kerjasama strategis antar pemerintah provinsi di seluruh wilayah Indonesia.</p>
            </div>
            <div class="bg-surface-white border border-border-subtle p-6 rounded-xl">
                <span class="material-symbols-outlined text-primary mb-3">policy</span>
                <p class="font-body-md text-body-md font-bold text-primary mb-1">Advokasi Kebijakan</p>
                <p class="font-body-md text-body-md text-on-surface-variant">Menjadi jembatan aspirasi daerah dalam perumusan kebijakan nasional yang berkeadilan.</p>
            </div>
            <div class="bg-surface-white border border-border-subtle p-6 rounded-xl">
                <span class="material-symbols-outlined text-primary mb-3">trending_up</span>
                <p class="font-body-md text-body-md font-bold text-primary mb-1">Inovasi Daerah</p>
                <p class="font-body-md text-body-md text-on-surface-variant">Mendorong replikasi praktik terbaik tata kelola pemerintahan yang inovatif dan efisien.</p>
            </div>
            <div class="bg-surface-white border border-border-subtle p-6 rounded-xl">
                <span class="material-symbols-outlined text-primary mb-3">groups</span>
                <p class="font-body-md text-body-md font-bold text-primary mb-1">Kesejahteraan Rakyat</p>
                <p class="font-body-md text-body-md text-on-surface-variant">Fokus pada peningkatan kualitas pelayanan publik dan kemakmuran masyarakat di daerah.</p>
            </div>
        </div>
    </div>
</section>

<!-- Provinsi Anggota -->
<section class="py-stack-lg px-4 max-w-[1200px] mx-auto">
    <h2 class="font-headline-md text-headline-md text-primary mb-6">Provinsi Anggota</h2>
    <div class="mb-6 relative">
        <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline">search</span>
        <input class="w-full h-14 pl-12 pr-4 bg-surface-white border border-border-subtle rounded-xl focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" placeholder="Cari Provinsi..." type="text">
    </div>
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3">
        <div class="bg-surface-white border border-border-subtle p-4 rounded-xl flex flex-col items-center gap-3 text-center active:bg-surface-container transition-colors cursor-pointer">
            <img class="w-16 h-16 object-contain" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCl6DE8B_v80UbSAQP-HdyqjF4Th6OpVea7kp9g226RTXLWPPjI5NGfgF8q-sEoMwZ8RETDJgCxZjbcrNLDv7DFJIV_U9ZOVFJ9R9Gkkj9n3Tft-PoW9Osr9R8Xl96Kv5t-Gj44lD75ie_NHBLljk0SwQXaY2X2BitTV2yAoGJc2yxpPv42QF4YOIxmKutyRSUEKfXE4c45A29HuKg5pVy1thfctyG1LziXenvsFQ0ZPwP2wRuGhE0NoeV1eAxWNmSoA9ktogV3bYc">
            <span class="font-label-caps text-label-caps text-primary">DKI Jakarta</span>
        </div>
        <div class="bg-surface-white border border-border-subtle p-4 rounded-xl flex flex-col items-center gap-3 text-center active:bg-surface-container transition-colors cursor-pointer">
            <img class="w-16 h-16 object-contain" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAJDXkXu_iEf6R39iaLYFdVdRXn114pxYI-TpgYp7pFdRP_SZLZMmqfJpzw2LGY2KUMCLPsLSf3nxDz-ki3wc2mdzRo4lVnYIarniLPhmmIpZ2zFM_-GxyKI4BFcvapoPMQs1hya0hZdR9idOpsVCeL2cTwowvzcr_Ae_e0xGP8y8RHBGvaWfB5_VyA-AjfT3N1iarKv8MIl_aScRzNZCMAvzV1AEHBkOJ6b-JjH_L82w3Op10J5wiR_a8Q4cAa3fG8r1N63ks4isQ">
            <span class="font-label-caps text-label-caps text-primary">Jawa Barat</span>
        </div>
        <div class="bg-surface-white border border-border-subtle p-4 rounded-xl flex flex-col items-center gap-3 text-center active:bg-surface-container transition-colors cursor-pointer">
            <img class="w-16 h-16 object-contain" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAMdj7PGjA1IZ6vCQVvBqjCI6i8PdjES4K02BLumAxSnuZqCWU-yWdqoe5XwbSR8vD5tuF0gCe3AZqQbHv550ZofNPcxzx3T-x2QEmWush7bVhEtzPzhUEf_MFerh607IB9bA_W4UuUVO_CXtIjqmC0DBDpkdcQtk42YmKGska-BqBH4EGrIZNSUphJ1SgcBiJmbeIC3M5bXCzRB6GKjiTnSWrortdyaQCMtDqYADeIQlA7_BFr8_TvwBw3FR8GpclxHzAtWoik8N0">
            <span class="font-label-caps text-label-caps text-primary">Bali</span>
        </div>
        <div class="bg-surface-white border border-border-subtle p-4 rounded-xl flex flex-col items-center gap-3 text-center active:bg-surface-container transition-colors cursor-pointer">
            <img class="w-16 h-16 object-contain" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDFcgByOOIkWoPGeCwWvqOqp5oACKvl3K_4g1-XUJf6tlwjx2zwzXq7XzyoPEeWhperXiT1sD0AbKNJkanQ1tQ5ZN62U6uZ6NcaNBTD3wyN_Cq-_4YY2VyoWr6OouCWCRHtES84wT863rzN8YaD2ITYD6PLQx7nmAAZsZcWuFLhar5PIHuaVbJqTq1UaSBuYu9021Eowak2_i97FkERbQWVtpYy0d6FRXnEXONruvWFeqMzQiTln7eRvX7M9MfSG_NXP2FPk9yJAf8">
            <span class="font-label-caps text-label-caps text-primary">Papua</span>
        </div>
    </div>
    <button class="w-full mt-6 py-4 font-button text-button text-primary bg-surface-container-high rounded-xl">Lihat Seluruh 38 Provinsi</button>
</section>

<!-- Berita & Siaran Pers -->
<section class="py-stack-lg px-4 bg-surface-container-lowest">
    <div class="max-w-[1200px] mx-auto">
        <div class="flex justify-between items-end mb-6">
            <div>
                <h2 class="font-headline-md text-headline-md text-primary">Berita &amp; Siaran Pers</h2>
                <div class="w-12 h-1 bg-secondary mt-2"></div>
            </div>
            <a class="font-label-caps text-label-caps text-secondary underline" href="{{ route('berita') }}">LIHAT SEMUA</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- News Card 1 -->
            <a href="{{ route('artikel') }}" class="flex flex-col bg-surface-white border border-border-subtle rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                <img class="w-full h-48 object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCcCkJQ4yft6pFIjzhHHZYbw6a8UZE07bjI2pBZVKaDwQSS9SyCZpyyTBvb-jeArc2ORHTuOpUhQkoQh9pyPYuXVeoQa7FTOYMWsPYWXN5-MSWg7U6g3P3HtW4KdoOJD58ydQ26QoskH3Zvst6JQJ3iGYFPdMnPqATZ1B-4LLGqa0IIZX6KA2fzicee7Emy3gypPm0C91K-UBuT1DTMy8Oxf-Ze86pGHle1m4HqsLMo2Bx3WUZA5oGm48deiU5zQDEPIdHSz_Wiom8">
                <div class="p-6">
                    <span class="font-label-caps text-label-caps text-on-surface-variant">24 MEI 2024</span>
                    <h3 class="font-headline-sm text-headline-sm text-primary mt-2 mb-3">Gubernur Se-Indonesia Bahas Strategi Ketahanan Pangan Nasional</h3>
                    <p class="font-body-md text-body-md text-on-surface-variant line-clamp-2">Pertemuan tahunan di IKN Nusantara menekankan pentingnya sinergi logistik antar provinsi guna menjaga stabilitas harga...</p>
                </div>
            </a>
            <!-- News Card 2 -->
            <a href="{{ route('artikel') }}" class="flex flex-col bg-surface-white border border-border-subtle rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                <img class="w-full h-48 object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCr6033RFPu2azMbW5v1zUn4K0JHryc3ZW22TeJVvdI0wvyf1_TMfVYJQd43fiRvwHZcB9QNo5ffAz2eQcCZ2BU-xoQaPuE90jlQyCcLvU_aqI_3xweMO2gj95GGFxaDvh28Azx2Nrp1B_NsZD1d4nB67Em-O3Rvt7xQRnkgBunIFHJ7aR3WuX6NfJnXCy080EM3iD1GlApbR4V0O_Ras3vWGObp0c7ptn9Yhwju7ztmextlb-VIDsOa_4sfwS-lU5RdkkKTBWi6IY">
                <div class="p-6">
                    <span class="font-label-caps text-label-caps text-on-surface-variant">20 MEI 2024</span>
                    <h3 class="font-headline-sm text-headline-sm text-primary mt-2 mb-3">Sekretariat APPSI Tingkatkan Layanan Digital untuk Pemerintah Daerah</h3>
                    <p class="font-body-md text-body-md text-on-surface-variant line-clamp-2">Penyempurnaan platform pertukaran data diharapkan mampu mempercepat pengambilan keputusan di tingkat provinsi...</p>
                </div>
            </a>
        </div>
    </div>
</section>

<!-- Video Kegiatan -->
<section class="py-stack-lg px-4 max-w-[1200px] mx-auto">
    <h2 class="font-headline-md text-headline-md text-primary mb-6">Video Kegiatan</h2>
    <div class="relative rounded-2xl overflow-hidden group">
        <img alt="Video Placeholder" class="w-full h-56 md:h-96 object-cover" src="https://lh3.googleusercontent.com/aida/AP1WRLuiTUAZq5_XTwsTTySi-FAco6Nic3W-bgZ48jlhMtfKFxuVWB9soLwOyCCsl7ncj7Vw4oEviwqHHSC4wrTIC0HL3A3lD21TYoMBRWc6wrM-DCehTKqTpMYb3anTWEDqH7CdsbmmaQDDSj10IQHRbon7XNEYvmUhIm0GC15wCARdRqa5GS9SBF_1AOvhgqGqEr0qVW8q2_lZ5V9HODDlxBIvgtf9xLSeRqjrTOaW-Y0z1TxBOveHloD7GHU">
        <div class="absolute inset-0 bg-primary/40 flex items-center justify-center group-hover:bg-primary/50 transition-all">
            <div class="w-20 h-20 bg-secondary rounded-full flex items-center justify-center text-primary shadow-xl scale-100 group-active:scale-90 transition-transform">
                <span class="material-symbols-outlined text-4xl" style="font-variation-settings: 'FILL' 1;">play_arrow</span>
            </div>
        </div>
        <div class="absolute bottom-4 left-4 text-on-primary">
            <p class="font-label-caps text-label-caps opacity-80 uppercase">Highlight</p>
            <p class="font-headline-sm text-headline-sm">Dokumentasi Munas V APPSI</p>
        </div>
    </div>
</section>
@endsection
