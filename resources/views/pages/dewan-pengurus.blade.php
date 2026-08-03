@extends('layouts.app')

@section('title', 'Dewan Pengurus - APPSI')

@section('content')
<div class="max-w-max-width-content mx-auto">
    <!-- Header & Breadcrumb -->
    <section class="px-margin-page py-stack-md bg-surface-white border-b border-border-subtle">
        <nav class="flex items-center gap-2 mb-2 font-label-caps text-label-caps text-on-surface-variant">
            <a href="{{ route('home') }}" class="hover:text-primary">Beranda</a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span>Tentang APPSI</span>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-primary font-bold">Dewan Pengurus</span>
        </nav>
        <h2 class="font-headline-lg-mobile text-headline-lg-mobile text-primary-container">Dewan Pengurus</h2>
    </section>

    <!-- Intro Text -->
    <section class="px-margin-page py-stack-md bg-surface">
        <div class="p-6 bg-surface-white border border-border-subtle rounded-lg">
            <p class="font-body-md text-body-md text-on-surface-variant">
                Sesuai dengan hasil Musyawarah Nasional APPSI VII, telah ditetapkan susunan Dewan Pengurus Asosiasi Pemerintah Provinsi Seluruh Indonesia (APPSI) Masa Bakti 2025-2029. Struktur ini dirancang untuk memperkuat sinergi antar pemerintah provinsi dalam mewujudkan tata kelola pemerintahan yang responsif, inovatif, dan berintegritas demi kemajuan Indonesia.
            </p>
        </div>
    </section>

    <!-- Leadership Section: Primary -->
    <section class="px-margin-page py-stack-md space-y-gutter">
        <div class="flex items-center gap-2 mb-4">
            <div class="h-8 w-1.5 bg-secondary-container rounded-full"></div>
            <h3 class="font-headline-sm text-headline-sm text-primary">Pimpinan Utama</h3>
        </div>
        
        <!-- Ketua Umum -->
        <div class="relative group overflow-hidden rounded-xl bg-primary-container text-on-primary shadow-lg">
            <div class="flex flex-col md:flex-row h-full">
                <div class="w-full md:w-5/12 h-80 md:h-auto overflow-hidden">
                    <img alt="Dr. H. Rudy Mas’ud" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="https://lh3.googleusercontent.com/aida/AP1WRLsFNNIP_FapvNrZS9QEoil7W_GSudyCn7kv3NHI2Lt5s5wgGIiOyxYI1AlzhHgi-0cWN4LYPghq7dlMPAaO7JDViNsakO4yPm0myxLSoaiQTAXpqyBzcooqsKrqVXkgTAwKb8tBUWihV2GUIBFMK7QrlfgXIA3WJyw-XN1Ej3dTTeCthCpuBt7-XV9HxsdzLBHh_MJO-C_UmMV2xiIi_HnAQgis3DPftUk4MIB4WHDFZYLq4dBJA_BEcQ"/>
                </div>
                <div class="w-full md:w-7/12 p-8 flex flex-col justify-center gap-4">
                    <div>
                        <span class="font-label-caps text-label-caps text-secondary-container uppercase tracking-widest mb-2 block">Ketua Umum</span>
                        <h4 class="font-headline-md text-headline-md font-bold mb-1">Dr. H. Rudy Mas’ud</h4>
                        <p class="font-body-md text-body-md opacity-80">Gubernur Kalimantan Timur</p>
                    </div>
                    <p class="font-body-md text-body-md italic border-l-2 border-secondary-container pl-4">
                        "Membangun kolaborasi strategis antar provinsi untuk kemandirian ekonomi daerah yang berkelanjutan."
                    </p>
                </div>
            </div>
        </div>

        <!-- Wakil & Sekjen -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-gutter">
            <!-- Wakil Ketua Umum -->
            <div class="bg-surface-white border border-border-subtle rounded-xl overflow-hidden hover:shadow-md transition-shadow">
                <div class="aspect-[0.79] w-full bg-surface-container-high overflow-hidden">
                    <img alt="Hj. Khofifah Indar Parawansa" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida/AP1WRLtk_1MKwjU9Li4VCdplKr3-qSPn0isGlO-GXWKapciJOjKYY3z8UicrTZGoUITwGBqjcXM5o4wDm9YkJvh1m58O_VnnBJKSUcyl0FSVo9mqbAZOK2_6MkWf1qhnOgTDrDKJ3X2unVV1ECGDtq2mN9Hj7Z6a6Y9RRovmu0Sgb-YR8JiPIw0akmh_dTfRxS8ulZ99EVh7jnrL3WdRZ9DmE49-eHTLKgu5Q10Btlgd_hbi1sd-zb8BbBbkTA"/>
                </div>
                <div class="p-6">
                    <span class="font-label-caps text-label-caps text-primary uppercase mb-1 block">Wakil Ketua Umum</span>
                    <h5 class="font-headline-sm text-headline-sm font-bold text-text-main">Hj. Khofifah Indar Parawansa</h5>
                    <p class="font-body-md text-body-md text-on-surface-variant">Gubernur Jawa Timur</p>
                </div>
            </div>
            <!-- Sekjen -->
            <div class="bg-surface-white border border-border-subtle rounded-xl overflow-hidden hover:shadow-md transition-shadow">
                <div class="aspect-[0.79] w-full bg-surface-container-high overflow-hidden">
                    <img alt="Hendrik Lewerissa" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida/AP1WRLsmTFbUnLPHthRbdLZFWDKH5XRHqLWwOGCAWtpWQkMK8zFKbVrPmR990cJldjY0GcELmEw0ayJoJj5j6Yr0d-8yphCwtxSYQOynUUguEDQekTb0sTE3oz6VLn5f5MEWzAL88-rrasa2Py8BiJMq3PuTQ3G52wRbyhLMPtgBGYqQmGwPP82ywgjgQah_CSyidQoqSaMU4Nnqn4vx4jIUrJuCMCv_i67E6awSypq-bvMZ-taIHaojWZfEKWI"/>
                </div>
                <div class="p-6">
                    <span class="font-label-caps text-label-caps text-primary uppercase mb-1 block">Sekretaris Jenderal</span>
                    <h5 class="font-headline-sm text-headline-sm font-bold text-text-main">Hendrik Lewerissa</h5>
                    <p class="font-body-md text-body-md text-on-surface-variant">Gubernur Maluku</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Board Members Section -->
    <section class="px-margin-page py-stack-md">
        <div class="flex items-center gap-2 mb-8">
            <div class="h-8 w-1.5 bg-secondary-container rounded-full"></div>
            <h3 class="font-headline-sm text-headline-sm text-primary">Jajaran Pengurus</h3>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
            <div class="bg-surface-white border border-border-subtle p-3 rounded-lg flex flex-col gap-3 group">
                <div class="aspect-[0.79] rounded-md overflow-hidden bg-surface-container">
                    <img alt="Mayjen TNI (Purn) Yulius Selvanus" class="w-full h-full object-cover group-hover:scale-105 transition-transform" src="https://lh3.googleusercontent.com/aida/AP1WRLt_EHDkR9bcHMxaA5tM4AlpVQzNgoWFMNuceHzVkD1rcTEpYZ_VP3DC-rH2a5eQz7hGUhTYPBYfmSRXOa1x9jcjxlmuWslVXmtM6x8mxa19LrEBCxksjOBMYn1u-H4siS2bLf24aOSkvCwyiQN_udGuYL1yS-tLb9VNMoeRGPfzbyWhkOoi0gptGZL-tHOBqT5w9qgU3YJYVC44XtnrcCpRVK7rLPW_P87Q1xpVwc_v2tC1YuwuM8iLiA"/>
                </div>
                <div>
                    <span class="text-[11px] font-bold text-secondary uppercase block mb-1">Ketua I</span>
                    <h6 class="text-[14px] font-bold text-primary-container leading-tight">Yulius Selvanus</h6>
                    <p class="text-[12px] text-on-surface-variant">Sulawesi Utara</p>
                </div>
            </div>
            <div class="bg-surface-white border border-border-subtle p-3 rounded-lg flex flex-col gap-3 group">
                <div class="aspect-[0.79] rounded-md overflow-hidden bg-surface-container">
                    <img alt="Rahmat Mirzani Djausal" class="w-full h-full object-cover group-hover:scale-105 transition-transform" src="https://lh3.googleusercontent.com/aida/AP1WRLtHlYdKND9hLWP4LM-22Im11zpDDrKTtkUPCQOerwbGf6iBvWnXYFExBUD6NTLuy3AWSQaVYXWP6bUIPr_K_M_7ebv8-7NvIv2hYAEvV2q9-MprzKwr2DSHSGbTRnwAn58O3yei2i8QJ3_XhUGM-RWvKRItskcUZfvuA2twSehsDOKWFhbD1H2dzWTmTlcnHDXJFBKIQznVEcpTDn-lhNaRAyUgByh1DKKfH5jWvHdnMmguDzfIx3DCDEc"/>
                </div>
                <div>
                    <span class="text-[11px] font-bold text-secondary uppercase block mb-1">Ketua II</span>
                    <h6 class="text-[14px] font-bold text-primary-container leading-tight">Rahmat Mirzani D.</h6>
                    <p class="text-[12px] text-on-surface-variant">Lampung</p>
                </div>
            </div>
            <div class="bg-surface-white border border-border-subtle p-3 rounded-lg flex flex-col gap-3 group">
                <div class="aspect-[0.79] rounded-md overflow-hidden bg-surface-container">
                    <img alt="H. Ansar Ahmad" class="w-full h-full object-cover group-hover:scale-105 transition-transform" src="https://lh3.googleusercontent.com/aida/AP1WRLs36LTiRvBRoD6prxz_bOjtSAxZ-3necZAfzBRTY-qZ5YDijPiPtx21_rA_-rW1o7BeJDGTA8a7HUEXUta6ydEAMI651nEbbDrSH-e1G3txln35ci-u8BmUM-xHTWqlw7EPMmskGjrqtw1P_PpMMLViOAUojO727OGqoFB4c5BlaGldbe7WV8TNFh9qf_zWaDeNMeansHfA0gItj2i-HiYERi_XCNWaMnavCjW3d02gJOir4-Eqhmv0l8Q"/>
                </div>
                <div>
                    <span class="text-[11px] font-bold text-secondary uppercase block mb-1">Ketua III</span>
                    <h6 class="text-[14px] font-bold text-primary-container leading-tight">H. Ansar Ahmad</h6>
                    <p class="text-[12px] text-on-surface-variant">Kepulauan Riau</p>
                </div>
            </div>
            <div class="bg-surface-white border border-border-subtle p-3 rounded-lg flex flex-col gap-3 group">
                <div class="aspect-[0.79] rounded-md overflow-hidden bg-surface-container">
                    <img alt="Sherly Tjoanda" class="w-full h-full object-cover group-hover:scale-105 transition-transform" src="https://lh3.googleusercontent.com/aida/AP1WRLvccLu4uFOWC8tHfPxwM2AcFlo0FrCazpd0UY3_k0L7rZhgdOmuH5iYLWWHx89HRAYoqw0L1YK6a-wXyDjROsG5CjsLJMAZU6VV2gI8GuWM4PuL3Ttt3B49PUh_V53hMthJ6q_3wPEyDgQRDtVBjKJM9sXkx6XdlAU6xZy3VKsumQXlEK1fXrzg3GDeoqP1bZKFTqZ47YH6z0QEw-svQGeTVsQBlIANckVtsH3TX1pr3FoV5FdOwPGyiw"/>
                </div>
                <div>
                    <span class="text-[11px] font-bold text-secondary uppercase block mb-1">Bendahara</span>
                    <h6 class="text-[14px] font-bold text-primary-container leading-tight">Sherly Tjoanda</h6>
                    <p class="text-[12px] text-on-surface-variant">Maluku Utara</p>
                </div>
            </div>
            <div class="bg-surface-white border border-border-subtle p-3 rounded-lg flex flex-col gap-3 group">
                <div class="aspect-[0.79] rounded-md overflow-hidden bg-surface-container">
                    <img alt="H. Ria Norsan" class="w-full h-full object-cover group-hover:scale-105 transition-transform" src="https://lh3.googleusercontent.com/aida/AP1WRLuVdaNzcqK3CHseWfJ-_zmauIGEvVlG5kwRXgTYFwSb-rMVPVsTJfezTcTUCBhnFCB7W2rdi2p5wSuXycaNajpjsDjfS2Db7GbYXwTu_aftCGi1lDy0Z6N9dpLcjNxEjHjM-wN7nVr9-5_tAu2A_T_VHUpumLI3OQ-t3pPhS90H97RgLyzO0K5XJnQ-VOBUnkEF50kTgovHjNUwnYy7prOAdXJYkQP4W5fWY5_5BjjsL2W_2qWxi_ATw2E"/>
                </div>
                <div>
                    <span class="text-[11px] font-bold text-secondary uppercase block mb-1">Wk. Bendahara</span>
                    <h6 class="text-[14px] font-bold text-primary-container leading-tight">H. Ria Norsan</h6>
                    <p class="text-[12px] text-on-surface-variant">Kalimantan Barat</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Regional Coordinators -->
    <section class="px-margin-page py-stack-lg bg-surface-container-low mb-8">
        <div class="flex items-center gap-2 mb-8">
            <div class="h-8 w-1.5 bg-primary rounded-full"></div>
            <h3 class="font-headline-sm text-headline-sm text-primary">Koordinator Wilayah</h3>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-surface-white p-5 rounded-xl border border-border-subtle flex items-start gap-4">
                <div class="w-20 h-24 flex-shrink-0 overflow-hidden rounded-lg bg-surface-container">
                    <img alt="Dr. H. Herman Deru" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida/AP1WRLuE8bnM8uE0Q-PkW11HJi214rl3iLoUKYUHkbRzSLJuk1V_f48hq6IyIVGkL7ogUOOpyRTeF-wGWX0t7FZnpSHKzXSgLCerFs3UUlDGNXnpR-eYaFNpbkHhTpJwr-4AaPL9wMyYegtxA3Tonn7Iw7lnWsNIYsqo7Hlw1qqioSolLFGFUEly9RN42MtBNkPUmpGwPxKYqr1a4KCVklbn9JeB-9mcTtC0p7exM-yeI9EqQdL--c5O2Iesr0M"/>
                </div>
                <div>
                    <span class="text-[10px] font-extrabold text-on-surface-variant tracking-wider uppercase opacity-60">Wilayah Sumatera</span>
                    <h6 class="font-bold text-primary-container leading-tight mb-1">Dr. H. Herman Deru</h6>
                    <p class="text-[12px] text-on-surface-variant">Gubernur Sumatera Selatan</p>
                </div>
            </div>
            <div class="bg-surface-white p-5 rounded-xl border border-border-subtle flex items-start gap-4">
                <div class="w-20 h-24 flex-shrink-0 overflow-hidden rounded-lg bg-surface-container">
                    <img alt="H. Dedi Mulyadi" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida/AP1WRLuwSHssvBR21OyAJEnR5-CT7NiYr0t_CNH7DLe2UsbyeU_cV6_a31Fq_aGzKg4e5PpIes7UKW5ReocYnhZ59lmgv1n1zXGyfZJBVkOSiMKmkAUx0x4r6r0bR4cwsM-VfW8HyZ0iXnoNk4emfvATOpPMgUgUqETqoo6xy32dZlewyfEa1ZKveiwf8mgx8yJdp2NWWvS7acKA2NDJZIwLCjLajnqxAMNwfybShBvD6Gkb_B01yTjfQhoJ8k8"/>
                </div>
                <div>
                    <span class="text-[10px] font-extrabold text-on-surface-variant tracking-wider uppercase opacity-60">Wilayah Jawa</span>
                    <h6 class="font-bold text-primary-container leading-tight mb-1">H. Dedi Mulyadi</h6>
                    <p class="text-[12px] text-on-surface-variant">Gubernur Jawa Barat</p>
                </div>
            </div>
            <div class="bg-surface-white p-5 rounded-xl border border-border-subtle flex items-start gap-4">
                <div class="w-20 h-24 flex-shrink-0 overflow-hidden rounded-lg bg-surface-container">
                    <img alt="Dr. H. Lalu Muhamad Iqbal" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida/AP1WRLsYkFKYpTIfLN759lJzLIjBrVgHjHYSiGLK39kMDgS8mfmA0FWQ3kAzjEE2l7xW4BREFedGpdcIYpbN8h3yfTbc8jwQsznuFPcZMMzyYruL9v4F5ccBAB9d6OdhgycsECdDxZ9g7JomfTVKxbOwRsDwLCm4zBPM0yqJnxWj2y_ifU81Hcd6nZTog42urQ4AIkEgPqqJB6gHKCdNr4HEwWX_w5LC6uOWb63M7yUOENmdcogmgIrRnUDXoCs"/>
                </div>
                <div>
                    <span class="text-[10px] font-extrabold text-on-surface-variant tracking-wider uppercase opacity-60">Bali &amp; Nusa Tenggara</span>
                    <h6 class="font-bold text-primary-container leading-tight mb-1">Dr. H. Lalu Muhamad Iqbal</h6>
                    <p class="text-[12px] text-on-surface-variant">Gubernur Nusa Tenggara Barat</p>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
