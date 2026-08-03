<footer class="bg-tertiary text-on-tertiary px-4 md:px-8 py-12 flex flex-col gap-10">
    <div class="max-w-[1200px] mx-auto w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <div class="flex flex-col gap-4 lg:col-span-2">
            <span class="font-headline-md text-headline-md font-bold text-on-tertiary">APPSI</span>
            <p class="font-body-lg text-body-lg text-on-tertiary/80 leading-relaxed max-w-md">
                Asosiasi Pemerintah Provinsi Seluruh Indonesia (APPSI) adalah organisasi resmi yang mewadahi kolaborasi strategis antar pemerintah daerah.
            </p>
        </div>
        
        <div class="flex flex-col gap-4">
            <h4 class="font-headline-sm text-headline-sm text-secondary-fixed">Kontak Sekretariat</h4>
            <div class="flex flex-col gap-3 font-body-md text-body-md text-on-tertiary/80">
                <div class="flex gap-3">
                    <span class="material-symbols-outlined text-secondary-fixed">location_on</span>
                    <p>Jl. Menteng Raya No. 44, Menteng, Jakarta Pusat, 10340</p>
                </div>
                <div class="flex gap-3">
                    <span class="material-symbols-outlined text-secondary-fixed">call</span>
                    <p class="font-bold text-on-tertiary">(021) 123 4567 / 123 4568</p>
                </div>
                <div class="flex gap-3">
                    <span class="material-symbols-outlined text-secondary-fixed">mail</span>
                    <p class="underline">sekretariat@appsi.or.id</p>
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-4">
            <h4 class="font-headline-sm text-headline-sm text-secondary-fixed">Tautan Cepat</h4>
            <div class="flex flex-col gap-2 font-label-caps text-label-caps">
                <a href="{{ route('sekretariat') }}" class="text-on-tertiary/70 hover:text-on-tertiary transition-colors">Sekretariat</a>
                <a href="{{ route('dewan-penasehat') }}" class="text-on-tertiary/70 hover:text-on-tertiary transition-colors">Dewan Penasehat</a>
                <a href="{{ route('dewan-pengurus') }}" class="text-on-tertiary/70 hover:text-on-tertiary transition-colors">Dewan Pengurus</a>
                <a href="{{ route('berita') }}" class="text-on-tertiary/70 hover:text-on-tertiary transition-colors">Berita & Siaran Pers</a>
                <a href="{{ route('hubungi') }}" class="text-on-tertiary/70 hover:text-on-tertiary transition-colors">Hubungi Kami</a>
            </div>
        </div>
    </div>

    <div class="max-w-[1200px] mx-auto w-full pt-8 border-t border-on-tertiary/20 flex flex-col md:flex-row justify-between items-center gap-4 text-center">
        <p class="font-label-caps text-label-caps text-on-tertiary/60">© 2024 APPSI. Seluruh Hak Cipta Dilindungi.</p>
        <div class="flex gap-4">
            <a class="flex items-center gap-2 bg-on-tertiary/10 px-4 py-2 rounded-lg hover:bg-on-tertiary/20 transition-colors" href="https://www.facebook.com/info.appsi/">
                <span class="material-symbols-outlined">public</span>
                <span class="font-label-caps text-label-caps">Facebook</span>
            </a>
            <a class="flex items-center gap-2 bg-on-tertiary/10 px-4 py-2 rounded-lg hover:bg-on-tertiary/20 transition-colors" href="https://www.instagram.com/appsi.or.id/">
                <span class="material-symbols-outlined">camera</span>
                <span class="font-label-caps text-label-caps">Instagram</span>
            </a>
        </div>
    </div>
</footer>
