@extends('layouts.admin')

@section('title', 'Pengaturan Website')
@section('subtitle', 'Kelola identitas, kontak, dan integrasi media sosial APPSI')

@section('content')
<div class="w-full" x-data="{
    activeTab: 'identitas',
    previewLogo: '{{ !empty($pengaturan['logo_utama']) ? asset('storage/' . $pengaturan['logo_utama']) : asset('images/Logo-appsi.png') }}',
    previewEmblem: '{{ !empty($pengaturan['logo_emblem']) ? asset('storage/' . $pengaturan['logo_emblem']) : asset('images/Logo-appsi-emblem.png') }}',
    handleLogoSelect(e) {
        const file = e.target.files[0];
        if (file) this.previewLogo = URL.createObjectURL(file);
    },
    handleEmblemSelect(e) {
        const file = e.target.files[0];
        if (file) this.previewEmblem = URL.createObjectURL(file);
    }
}">

    <form action="{{ route('admin.pengaturan.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- --- TAB NAVIGATION ------------------------------------------- --}}
        <div class="mb-6 bg-white border border-slate-200 rounded-2xl p-1.5 flex flex-wrap gap-1 shadow-xs">
            <button type="button"
                @click="activeTab = 'identitas'"
                :class="activeTab === 'identitas'
                    ? 'bg-navy-900 text-white shadow-md'
                    : 'text-slate-500 hover:text-slate-800 hover:bg-slate-100'"
                class="flex-1 min-w-fit flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold transition-all duration-200 cursor-pointer">
                <span class="material-symbols-outlined text-sm">image</span>
                <span>Identitas Visual</span>
            </button>
            <button type="button"
                @click="activeTab = 'organisasi'"
                :class="activeTab === 'organisasi'
                    ? 'bg-navy-900 text-white shadow-md'
                    : 'text-slate-500 hover:text-slate-800 hover:bg-slate-100'"
                class="flex-1 min-w-fit flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold transition-all duration-200 cursor-pointer">
                <span class="material-symbols-outlined text-sm">domain</span>
                <span>Identitas Organisasi</span>
            </button>
            <button type="button"
                @click="activeTab = 'kontak'"
                :class="activeTab === 'kontak'
                    ? 'bg-navy-900 text-white shadow-md'
                    : 'text-slate-500 hover:text-slate-800 hover:bg-slate-100'"
                class="flex-1 min-w-fit flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold transition-all duration-200 cursor-pointer">
                <span class="material-symbols-outlined text-sm">location_on</span>
                <span>Kontak & Sekretariat</span>
            </button>
            <button type="button"
                @click="activeTab = 'sosmed'"
                :class="activeTab === 'sosmed'
                    ? 'bg-navy-900 text-white shadow-md'
                    : 'text-slate-500 hover:text-slate-800 hover:bg-slate-100'"
                class="flex-1 min-w-fit flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold transition-all duration-200 cursor-pointer">
                <span class="material-symbols-outlined text-sm">share</span>
                <span>Media Sosial</span>
            </button>
        </div>

        {{-- --- TAB: IDENTITAS VISUAL (LOGO) ----------------------------- --}}
        <div x-show="activeTab === 'identitas'" x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
                {{-- Header --}}
                <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-3 bg-amber-50/50">
                    <span class="w-9 h-9 rounded-xl bg-amber-500/15 text-amber-600 flex items-center justify-center">
                        <span class="material-symbols-outlined">image</span>
                    </span>
                    <div>
                        <h3 class="font-bold text-slate-800 text-sm">Logo & Identitas Visual</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Logo tampil di Navbar, Footer, dan seluruh halaman publik</p>
                    </div>
                    <span class="ml-auto text-[11px] font-semibold text-amber-700 bg-amber-100 px-2.5 py-1 rounded-lg">Branding</span>
                </div>

                <div class="p-6 md:p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Logo Utama --}}
                        <div class="border border-slate-200 rounded-2xl overflow-hidden">
                            <div class="bg-slate-50 px-4 py-3 border-b border-slate-200 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                <span class="text-xs font-bold text-slate-700 uppercase tracking-wider">Logo Utama (Horizontal)</span>
                            </div>
                            <div class="p-5 space-y-4">
                                {{-- Preview --}}
                                <div class="w-full h-28 rounded-xl bg-white border-2 border-dashed border-slate-200 flex items-center justify-center p-4 overflow-hidden">
                                    <img :src="previewLogo" alt="Logo Utama APPSI"
                                         class="max-h-full max-w-full object-contain"
                                         onerror="this.src='{{ asset('images/Logo-appsi.png') }}'">
                                </div>
                                {{-- Actions --}}
                                <div class="space-y-2">
                                    <label for="logo_utama"
                                        class="w-full px-4 py-2.5 bg-navy-900 hover:bg-navy-800 text-white rounded-xl text-xs font-bold cursor-pointer transition-all inline-flex items-center justify-center gap-2 shadow-sm">
                                        <span class="material-symbols-outlined text-sm">upload</span>
                                        <span>Unggah Logo Utama</span>
                                    </label>
                                    <input type="file" id="logo_utama" name="logo_utama"
                                           accept="image/png,image/jpeg,image/webp,image/svg+xml"
                                           class="hidden" @change="handleLogoSelect($event)">

                                    @if(!empty($pengaturan['logo_utama']))
                                    <label class="w-full flex items-center justify-center gap-2 text-xs text-rose-600 font-medium cursor-pointer py-1.5 border border-rose-200 rounded-xl hover:bg-rose-50 transition-colors">
                                        <input type="checkbox" name="hapus_logo_utama" value="1" class="rounded text-rose-600 focus:ring-rose-500">
                                        <span>Reset ke logo bawaan</span>
                                    </label>
                                    @endif

                                    <p class="text-[11px] text-slate-400 text-center leading-relaxed">
                                        Format PNG transparan / SVG • Maks 2 MB
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Logo Emblem --}}
                        <div class="border border-slate-200 rounded-2xl overflow-hidden">
                            <div class="bg-slate-50 px-4 py-3 border-b border-slate-200 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-navy-900"></span>
                                <span class="text-xs font-bold text-slate-700 uppercase tracking-wider">Emblem & Favicon (Kotak)</span>
                            </div>
                            <div class="p-5 space-y-4">
                                {{-- Preview --}}
                                <div class="w-full h-28 rounded-xl bg-white border-2 border-dashed border-slate-200 flex items-center justify-center p-4 overflow-hidden">
                                    <img :src="previewEmblem" alt="Emblem APPSI"
                                         class="max-h-full max-w-full object-contain"
                                         onerror="this.src='{{ asset('images/Logo-appsi-emblem.png') }}'">
                                </div>
                                {{-- Actions --}}
                                <div class="space-y-2">
                                    <label for="logo_emblem"
                                        class="w-full px-4 py-2.5 bg-navy-900 hover:bg-navy-800 text-white rounded-xl text-xs font-bold cursor-pointer transition-all inline-flex items-center justify-center gap-2 shadow-sm">
                                        <span class="material-symbols-outlined text-sm">upload</span>
                                        <span>Unggah Emblem / Favicon</span>
                                    </label>
                                    <input type="file" id="logo_emblem" name="logo_emblem"
                                           accept="image/png,image/jpeg,image/webp,image/svg+xml,image/x-icon"
                                           class="hidden" @change="handleEmblemSelect($event)">

                                    @if(!empty($pengaturan['logo_emblem']))
                                    <label class="w-full flex items-center justify-center gap-2 text-xs text-rose-600 font-medium cursor-pointer py-1.5 border border-rose-200 rounded-xl hover:bg-rose-50 transition-colors">
                                        <input type="checkbox" name="hapus_logo_emblem" value="1" class="rounded text-rose-600 focus:ring-rose-500">
                                        <span>Reset ke emblem bawaan</span>
                                    </label>
                                    @endif

                                    <p class="text-[11px] text-slate-400 text-center leading-relaxed">
                                        Rasio 1:1 • Tampil di icon tab browser & sidebar admin • Maks 2 MB
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- --- TAB: IDENTITAS ORGANISASI -------------------------------- --}}
        <div x-show="activeTab === 'organisasi'" x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-3 bg-navy-900/5">
                    <span class="w-9 h-9 rounded-xl bg-navy-900/10 text-navy-900 flex items-center justify-center">
                        <span class="material-symbols-outlined">domain</span>
                    </span>
                    <div>
                        <h3 class="font-bold text-slate-800 text-sm">Identitas Organisasi</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Nama resmi, singkatan, dan deskripsi portal</p>
                    </div>
                    <span class="ml-auto text-[11px] font-semibold text-navy-900 bg-navy-900/10 px-2.5 py-1 rounded-lg">Global Info</span>
                </div>

                <div class="p-6 md:p-8 space-y-5">
                    {{-- Nama + Singkatan --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="sm:col-span-2">
                            <label for="nama_organisasi" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">
                                Nama Resmi Organisasi
                            </label>
                            <input type="text" id="nama_organisasi" name="nama_organisasi"
                                value="{{ old('nama_organisasi', $pengaturan['nama_organisasi'] ?? '') }}"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors"
                                placeholder="Asosiasi Pemerintah Provinsi Seluruh Indonesia">
                        </div>
                        <div>
                            <label for="singkatan" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">
                                Singkatan / Akronim
                            </label>
                            <input type="text" id="singkatan" name="singkatan"
                                value="{{ old('singkatan', $pengaturan['singkatan'] ?? '') }}"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-bold text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors"
                                placeholder="APPSI">
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <label for="deskripsi" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">
                            Deskripsi Singkat Portal
                            <span class="ml-1 text-[10px] font-normal text-slate-400 normal-case tracking-normal">(tampil di Footer & SEO)</span>
                        </label>
                        <textarea id="deskripsi" name="deskripsi" rows="4"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors leading-relaxed resize-none"
                            placeholder="Uraian singkat tentang tujuan dan fungsi portal resmi APPSI...">{{ old('deskripsi', $pengaturan['deskripsi'] ?? '') }}</textarea>
                        <p class="text-[11px] text-slate-400 mt-1.5">
                            Ditampilkan pada paragraf ringkasan di footer seluruh halaman dan sebagai meta deskripsi Google.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- --- TAB: KONTAK & SEKRETARIAT -------------------------------- --}}
        <div x-show="activeTab === 'kontak'" x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-3 bg-green-50/50">
                    <span class="w-9 h-9 rounded-xl bg-green-500/10 text-green-700 flex items-center justify-center">
                        <span class="material-symbols-outlined">location_on</span>
                    </span>
                    <div>
                        <h3 class="font-bold text-slate-800 text-sm">Kontak & Sekretariat</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Email, telepon, fax, dan alamat kantor pusat APPSI</p>
                    </div>
                    <span class="ml-auto text-[11px] font-semibold text-green-800 bg-green-100 px-2.5 py-1 rounded-lg">Kantor Pusat</span>
                </div>

                <div class="p-6 md:p-8 space-y-5">
                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Email Resmi</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <span class="material-symbols-outlined text-base">mail</span>
                            </span>
                            <input type="email" id="email" name="email"
                                value="{{ old('email', $pengaturan['email'] ?? '') }}"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-sm font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors"
                                placeholder="info@appsi.or.id">
                        </div>
                    </div>

                    {{-- Telepon + Fax --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="telepon" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Nomor Telepon</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <span class="material-symbols-outlined text-base">call</span>
                                </span>
                                <input type="text" id="telepon" name="telepon"
                                    value="{{ old('telepon', $pengaturan['telepon'] ?? '') }}"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-sm font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors"
                                    placeholder="021-2168 4200">
                            </div>
                        </div>
                        <div>
                            <label for="fax" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Nomor Fax</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <span class="material-symbols-outlined text-base">fax</span>
                                </span>
                                <input type="text" id="fax" name="fax"
                                    value="{{ old('fax', $pengaturan['fax'] ?? '') }}"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-sm font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors"
                                    placeholder="021-2598 4843">
                            </div>
                        </div>
                    </div>

                    {{-- Alamat --}}
                    <div>
                        <label for="alamat" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Alamat Lengkap Sekretariat</label>
                        <div class="relative">
                            <span class="absolute top-3 left-3.5 text-slate-400 pointer-events-none">
                                <span class="material-symbols-outlined text-base">map</span>
                            </span>
                            <textarea id="alamat" name="alamat" rows="3"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-sm font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors leading-relaxed resize-none"
                                placeholder="Gedung, Jalan, Kecamatan, Kota, Kode Pos...">{{ old('alamat', $pengaturan['alamat'] ?? '') }}</textarea>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1.5">Ditampilkan pada halaman Kontak dan bagian bawah footer.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- --- TAB: MEDIA SOSIAL ---------------------------------------- --}}
        <div x-show="activeTab === 'sosmed'" x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-3 bg-blue-50/50">
                    <span class="w-9 h-9 rounded-xl bg-blue-500/10 text-blue-600 flex items-center justify-center">
                        <span class="material-symbols-outlined">share</span>
                    </span>
                    <div>
                        <h3 class="font-bold text-slate-800 text-sm">Media Sosial Resmi</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Tautan ke akun media sosial resmi APPSI</p>
                    </div>
                    <span class="ml-auto text-[11px] font-semibold text-blue-700 bg-blue-100 px-2.5 py-1 rounded-lg">Link Publik</span>
                </div>

                <div class="p-6 md:p-8">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        {{-- Facebook --}}
                        <div>
                            <label for="facebook" class="flex items-center gap-2 text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">
                                <span class="text-blue-600">
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                </span>
                                Facebook
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-blue-600">
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                </span>
                                <input type="url" id="facebook" name="facebook"
                                    value="{{ old('facebook', $pengaturan['facebook'] ?? '') }}"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-sm font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors"
                                    placeholder="https://facebook.com/...">
                            </div>
                        </div>

                        {{-- Instagram --}}
                        <div>
                            <label for="instagram" class="flex items-center gap-2 text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">
                                <span class="text-pink-600">
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                </span>
                                Instagram
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-pink-600">
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                </span>
                                <input type="url" id="instagram" name="instagram"
                                    value="{{ old('instagram', $pengaturan['instagram'] ?? '') }}"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-sm font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-pink-500 focus:ring-1 focus:ring-pink-500 transition-colors"
                                    placeholder="https://instagram.com/appsi.or.id/">
                            </div>
                        </div>

                        {{-- YouTube --}}
                        <div>
                            <label for="youtube" class="flex items-center gap-2 text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">
                                <span class="text-red-600">
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                </span>
                                YouTube Channel
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-red-600">
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                </span>
                                <input type="url" id="youtube" name="youtube"
                                    value="{{ old('youtube', $pengaturan['youtube'] ?? '') }}"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-sm font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition-colors"
                                    placeholder="https://youtube.com/@OfficialAPPSI">
                            </div>
                        </div>

                        {{-- X / Twitter --}}
                        <div>
                            <label for="twitter" class="flex items-center gap-2 text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">
                                <span class="text-slate-900">
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                </span>
                                X (Twitter)
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-800">
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                </span>
                                <input type="url" id="twitter" name="twitter"
                                    value="{{ old('twitter', $pengaturan['twitter'] ?? '') }}"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-sm font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-slate-700 focus:ring-1 focus:ring-slate-700 transition-colors"
                                    placeholder="https://x.com/appsi_id">
                            </div>
                        </div>
                    </div>

                    {{-- Info note --}}
                    <div class="mt-5 flex items-start gap-2.5 p-4 bg-blue-50 border border-blue-100 rounded-xl">
                        <span class="material-symbols-outlined text-blue-500 text-base shrink-0 mt-0.5">info</span>
                        <p class="text-xs text-blue-700">
                            Tautan media sosial ditampilkan di bagian footer dan navbar halaman publik. Kosongkan jika akun belum tersedia.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- --- STICKY SAVE BAR ------------------------------------------ --}}
        <div class="mt-5 bg-white p-4 rounded-2xl border border-slate-200 shadow-md flex flex-col sm:flex-row sm:items-center justify-between gap-3 sticky bottom-4 z-20">
            <div class="flex items-center gap-2.5 text-xs text-slate-500">
                <span class="material-symbols-outlined text-amber-500 text-base">verified</span>
                <span>Perubahan berlaku langsung di seluruh halaman setelah disimpan.</span>
            </div>
            <button type="submit"
                class="px-6 py-2.5 bg-amber-500 hover:bg-amber-400 active:bg-amber-600 text-navy-950 font-bold text-xs rounded-xl shadow transition-all inline-flex items-center justify-center gap-2 shrink-0 cursor-pointer">
                <span class="material-symbols-outlined text-sm">save</span>
                <span>Simpan Pengaturan</span>
            </button>
        </div>
    </form>
</div>
@endsection
