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
                    {!! nl2br(e($pengaturanSosmed['alamat'] ?? "Gedung Nyi Ageng Serang Lt. 4,\nJl. HR. Rasuna Said Kav. 22 C\nJakarta Selatan, Indonesia 12940")) !!}
                </p>
            </div>
            <div class="bg-surface-white border border-border-subtle p-stack-md rounded-xl shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-secondary-container/10 flex items-center justify-center rounded-lg mb-4">
                    <span class="material-symbols-outlined text-secondary" style="font-variation-settings: 'FILL' 1;">call</span>
                </div>
                <h3 class="font-headline-sm text-headline-sm mb-2">Telepon &amp; Fax</h3>
                <div class="font-body-md text-body-md text-on-surface-variant space-y-1">
                    <p>Telp: <a href="tel:{{ preg_replace('/[^0-9]/', '', $pengaturanSosmed['telepon'] ?? '02121684200') }}" class="hover:text-primary">{{ $pengaturanSosmed['telepon'] ?? '021-2168 4200' }}</a></p>
                    @if(!empty($pengaturanSosmed['fax']))
                    <p>Fax: {{ $pengaturanSosmed['fax'] }}</p>
                    @endif
                </div>
            </div>
            <!-- Email Card -->
            <div class="bg-surface-white border border-border-subtle p-stack-md rounded-xl shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-secondary-container/10 flex items-center justify-center rounded-lg mb-4">
                    <span class="material-symbols-outlined text-secondary" style="font-variation-settings: 'FILL' 1;">mail</span>
                </div>
                <h3 class="font-headline-sm text-headline-sm mb-2">Email Resmi</h3>
                <p class="font-body-md text-body-md text-on-surface-variant">
                    <a href="mailto:{{ $pengaturanSosmed['email'] ?? 'info@appsi.or.id' }}" class="hover:text-primary">{{ $pengaturanSosmed['email'] ?? 'info@appsi.or.id' }}</a>
                </p>
            </div>

            {{-- Sosial Media --}}
            <div class="bg-surface-white border border-border-subtle p-stack-md rounded-xl shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-secondary-container/10 flex items-center justify-center rounded-lg mb-4">
                    <span class="material-symbols-outlined text-secondary" style="font-variation-settings: 'FILL' 1;">share</span>
                </div>
                <h3 class="font-headline-sm text-headline-sm mb-3">Media Sosial</h3>
                <div class="flex flex-col gap-2 text-sm">
                    <a href="{{ $pengaturanSosmed['facebook'] ?? 'https://www.facebook.com/info.appsi/' }}" target="_blank" class="flex items-center gap-2 text-on-surface-variant hover:text-[#1877F2] transition-colors">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073C24 5.405 18.627 0 12 0S0 5.405 0 12.073C0 18.1 4.388 23.094 10.125 24v-8.437H7.078v-3.49h3.047V9.41c0-3.025 1.792-4.697 4.533-4.697 1.312 0 2.686.236 2.686.236v2.97h-1.513c-1.491 0-1.956.93-1.956 1.874v2.25h3.328l-.532 3.49h-2.796V24C19.612 23.094 24 18.1 24 12.073z"/></svg>
                        <span>Facebook APPSI</span>
                    </a>
                    <a href="{{ $pengaturanSosmed['instagram'] ?? 'https://www.instagram.com/appsi.or.id/' }}" target="_blank" class="flex items-center gap-2 text-on-surface-variant hover:text-[#E1306C] transition-colors">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        <span>Instagram APPSI</span>
                    </a>
                    <a href="{{ $pengaturanSosmed['youtube'] ?? 'https://www.youtube.com/@OfficialAPPSI' }}" target="_blank" class="flex items-center gap-2 text-on-surface-variant hover:text-[#FF0000] transition-colors">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        <span>YouTube APPSI</span>
                    </a>
                    <a href="{{ $pengaturanSosmed['twitter'] ?? 'https://x.com/appsi_id' }}" target="_blank" class="flex items-center gap-2 text-on-surface-variant hover:text-black transition-colors">
                        <svg width="16" height="16" viewBox="0 0 512 512" fill="currentColor"><path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/></svg>
                        <span>X (Twitter) APPSI</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Contact Form (Right Column) -->
        <div class="lg:col-span-8">
            <div class="bg-surface-white border border-border-subtle p-stack-md md:p-stack-lg rounded-xl shadow-sm h-full">
                <h2 class="font-headline-md text-headline-md mb-stack-sm text-primary">Kirim Pesan</h2>
                <p class="font-body-md text-body-md text-on-surface-variant mb-stack-lg">
                    Silakan lengkapi formulir di bawah ini untuk pertanyaan atau aspirasi terkait program kerja APPSI.
                </p>

                {{-- Success --}}
                @if(session('success'))
                <div class="flex items-center gap-3 p-4 mb-6 bg-green-50 border border-green-200 rounded-xl text-green-800 text-sm font-medium">
                    <span class="material-symbols-outlined text-green-600">check_circle</span>
                    {{ session('success') }}
                </div>
                @endif

                {{-- Validation Errors --}}
                @if($errors->any())
                <div class="p-4 mb-6 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm">
                    <p class="font-semibold mb-1">Mohon periksa kembali isian Anda:</p>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('hubungi.kirim') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block font-label-caps text-label-caps text-on-surface-variant mb-2">NAMA LENGKAP <span class="text-red-500">*</span></label>
                            <input name="nama" value="{{ old('nama') }}"
                                class="w-full bg-surface-container-low border-none focus:ring-2 focus:ring-primary rounded-lg py-3 px-4 transition-all @error('nama') ring-2 ring-red-400 @enderror"
                                placeholder="Masukkan nama Anda" type="text"/>
                        </div>
                        <div>
                            <label class="block font-label-caps text-label-caps text-on-surface-variant mb-2">EMAIL <span class="text-red-500">*</span></label>
                            <input name="email" value="{{ old('email') }}"
                                class="w-full bg-surface-container-low border-none focus:ring-2 focus:ring-primary rounded-lg py-3 px-4 transition-all @error('email') ring-2 ring-red-400 @enderror"
                                placeholder="email@contoh.com" type="email"/>
                        </div>
                    </div>
                    <div>
                        <label class="block font-label-caps text-label-caps text-on-surface-variant mb-2">SUBJEK <span class="text-red-500">*</span></label>
                        <input name="subjek" value="{{ old('subjek') }}"
                            class="w-full bg-surface-container-low border-none focus:ring-2 focus:ring-primary rounded-lg py-3 px-4 transition-all @error('subjek') ring-2 ring-red-400 @enderror"
                            placeholder="Topik pesan Anda" type="text"/>
                    </div>
                    <div>
                        <label class="block font-label-caps text-label-caps text-on-surface-variant mb-2">PESAN <span class="text-red-500">*</span></label>
                        <textarea name="pesan" rows="5"
                            class="w-full bg-surface-container-low border-none focus:ring-2 focus:ring-primary rounded-lg py-3 px-4 transition-all @error('pesan') ring-2 ring-red-400 @enderror"
                            placeholder="Tuliskan pesan Anda di sini...">{{ old('pesan') }}</textarea>
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
<section class="max-w-[1200px] mx-auto px-margin-page mt-stack-lg mb-8">
    <div class="overflow-hidden rounded-2xl border border-border-subtle shadow-md h-[400px]">
        <iframe
            src="https://maps.google.com/maps?q=Gedung+Nyi+Ageng+Serang+Kuningan+Jakarta+Selatan&t=&z=16&ie=UTF8&iwloc=&output=embed"
            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
        </iframe>
    </div>
</section>
@endsection
