<footer class="bg-tertiary text-on-tertiary px-4 md:px-8 pt-12 pb-28 md:pb-24 flex flex-col gap-10">
    <div class="max-w-[1200px] mx-auto w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <div class="flex flex-col gap-5 lg:col-span-2">
            <div class="flex items-center gap-6">
                {{-- Logo bulat besar --}}
                <a href="{{ route('home') }}" class="shrink-0">
                    <img src="{{ asset('images/Logo-appsi.png') }}"
                         alt="APPSI"
                         style="width: 110px; height: 110px; border-radius: 50%; object-fit: cover; object-position: left center;
                                box-shadow: 0 0 0 4px rgba(255,255,255,0.18), 0 0 0 8px rgba(255,255,255,0.07);
                                background: white; display: block;">
                </a>
                {{-- Teks di samping logo --}}
                <p class="font-body-lg text-body-lg text-on-tertiary/80 leading-relaxed">
                    Asosiasi Pemerintah Provinsi Seluruh Indonesia (APPSI) adalah organisasi resmi yang mewadahi kolaborasi
                    strategis antar pemerintah daerah.
                </p>
            </div>
        </div>



        <div class="flex flex-col gap-4">
            <h4 class="font-headline-sm text-headline-sm text-secondary-fixed">Kontak Sekretariat</h4>
            <div class="flex flex-col gap-3 font-body-md text-body-md text-on-tertiary/80">
                <div class="flex gap-3">
                    <span class="material-symbols-outlined text-secondary-fixed text-lg mt-0.5">location_on</span>
                    <p>{{ $pengaturanSosmed['alamat'] ?? 'Gedung Nyi Ageng Serang Lt. 4, Jl. HR. Rasuna Said Kav. 22 C, Jakarta Selatan 12940' }}
                    </p>
                </div>
                <div class="flex gap-3">
                    <span class="material-symbols-outlined text-secondary-fixed text-lg mt-0.5">call</span>
                    <p class="font-bold text-on-tertiary">{{ $pengaturanSosmed['telepon'] ?? '021-2168 4200' }}</p>
                </div>
                <div class="flex gap-3">
                    <span class="material-symbols-outlined text-secondary-fixed text-lg mt-0.5">mail</span>
                    <p class="underline">{{ $pengaturanSosmed['email'] ?? 'info@appsi.or.id' }}</p>
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-4">
            <h4 class="font-headline-sm text-headline-sm text-secondary-fixed">Link Terkait</h4>
            <div class="flex flex-col gap-2 font-label-caps text-label-caps">
                <a href="https://kemendagri.go.id" target="_blank" rel="noopener"
                    class="text-on-tertiary/70 hover:text-on-tertiary transition-colors flex items-center gap-1.5">
                    <span>Kementerian Dalam Negeri</span>
                    <span class="material-symbols-outlined text-xs">open_in_new</span>
                </a>
                <a href="https://bappenas.go.id" target="_blank" rel="noopener"
                    class="text-on-tertiary/70 hover:text-on-tertiary transition-colors flex items-center gap-1.5">
                    <span>Bappenas RI</span>
                    <span class="material-symbols-outlined text-xs">open_in_new</span>
                </a>
                <a href="https://bps.go.id" target="_blank" rel="noopener"
                    class="text-on-tertiary/70 hover:text-on-tertiary transition-colors flex items-center gap-1.5">
                    <span>Badan Pusat Statistik (BPS)</span>
                    <span class="material-symbols-outlined text-xs">open_in_new</span>
                </a>
                <a href="https://apkasi.org" target="_blank" rel="noopener"
                    class="text-on-tertiary/70 hover:text-on-tertiary transition-colors flex items-center gap-1.5">
                    <span>APKASI</span>
                    <span class="material-symbols-outlined text-xs">open_in_new</span>
                </a>
                <a href="https://apeksi.id" target="_blank" rel="noopener"
                    class="text-on-tertiary/70 hover:text-on-tertiary transition-colors flex items-center gap-1.5">
                    <span>APEKSI</span>
                    <span class="material-symbols-outlined text-xs">open_in_new</span>
                </a>
            </div>
        </div>
    </div>

    <div
        class="max-w-[1200px] mx-auto w-full pt-8 border-t border-on-tertiary/20 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">
        <p class="font-label-caps text-label-caps text-on-tertiary/60 text-center sm:text-left">
            © {{ date('Y') }} APPSI. Seluruh Hak Cipta Dilindungi.
        </p>
        <p class="font-label-caps text-label-caps text-on-tertiary/40 text-center sm:text-right text-[11px]">
            Asosiasi Pemerintah Provinsi Seluruh Indonesia
        </p>
    </div>
</footer>