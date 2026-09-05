@extends('layouts.admin')

@section('title', 'Pengaturan Khusus Beranda')
@section('subtitle', 'Kelola semua teks, foto ketua umum, visi misi, kutipan, dan kartu fitur di halaman depan')

@section('content')
<div class="w-full" x-data="{
    tab: 'visi-misi',
    previewUrl: '{{ !empty($pengaturan['beranda_foto_ketua']) ? asset('storage/' . $pengaturan['beranda_foto_ketua']) : asset('storage/pengurus/kaltim.jpg') }}',
    handleFileSelect(event) {
        const file = event.target.files[0];
        if (file) {
            this.previewUrl = URL.createObjectURL(file);
        }
    }
}">

    @if($errors->any())
    <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-2xl shadow-xs">
        <div class="flex items-center gap-2 mb-1">
            <span class="material-symbols-outlined text-rose-600">error</span>
            <span class="text-xs font-bold">Terjadi kesalahan pengisian:</span>
        </div>
        <ul class="list-disc list-inside text-xs space-y-0.5 text-rose-700 pl-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.pengaturan.beranda.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- Navigasi Tab Horizontal --}}
        <div class="bg-white p-2 rounded-2xl border border-slate-200 shadow-xs flex flex-wrap gap-1.5">
            <button type="button" @click="tab = 'visi-misi'"
                :class="tab === 'visi-misi' ? 'bg-navy-900 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100'"
                class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2 cursor-pointer">
                <span class="material-symbols-outlined text-[18px]">flag</span>
                <span>Visi &amp; Misi</span>
            </button>

            <button type="button" @click="tab = 'sambutan'"
                :class="tab === 'sambutan' ? 'bg-navy-900 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100'"
                class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2 cursor-pointer">
                <span class="material-symbols-outlined text-[18px]">person</span>
                <span>Sambutan &amp; Ketua Umum</span>
            </button>

            <button type="button" @click="tab = 'quote'"
                :class="tab === 'quote' ? 'bg-navy-900 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100'"
                class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2 cursor-pointer">
                <span class="material-symbols-outlined text-[18px]">format_quote</span>
                <span>Kutipan Tokoh</span>
            </button>

            <button type="button" @click="tab = 'peran'"
                :class="tab === 'peran' ? 'bg-navy-900 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100'"
                class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2 cursor-pointer">
                <span class="material-symbols-outlined text-[18px]">hub</span>
                <span>Peran &amp; Fungsi</span>
            </button>

            <button type="button" @click="tab = 'program'"
                :class="tab === 'program' ? 'bg-navy-900 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100'"
                class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2 cursor-pointer">
                <span class="material-symbols-outlined text-[18px]">workspace_premium</span>
                <span>Program Utama</span>
            </button>

            <button type="button" @click="tab = 'media'"
                :class="tab === 'media' ? 'bg-navy-900 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100'"
                class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2 cursor-pointer">
                <span class="material-symbols-outlined text-[18px]">play_circle</span>
                <span>Video &amp; Media</span>
            </button>

            <button type="button" @click="tab = 'instagram'"
                :class="tab === 'instagram' ? 'bg-pink-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100'"
                class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2 cursor-pointer">
                <span class="material-symbols-outlined text-[18px]">photo_camera</span>
                <span>Instagram Feed</span>
            </button>
        </div>

        {{-- KONTEN TAB 1: VISI & MISI --}}
        <div x-show="tab === 'visi-misi'" x-cloak class="space-y-6">
            <div class="bg-white p-6 md:p-8 rounded-2xl border border-slate-200 shadow-xs space-y-6">
                <div class="border-b border-slate-100 pb-4">
                    <h3 class="font-bold text-slate-800 text-base flex items-center gap-2">
                        <span class="material-symbols-outlined text-amber-500">flag</span>
                        <span>Visi &amp; Misi Utama Beranda</span>
                    </h3>
                    <p class="text-xs text-slate-500 mt-1">
                        Teks ini langsung tampil di blok Visi &amp; Misi halaman depan serta digunakan sebagai rujukan di seluruh portal.
                    </p>
                </div>

                <div>
                    <label for="visi" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Visi Utama APPSI
                    </label>
                    <textarea id="visi" name="visi" rows="3"
                        class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors"
                        placeholder="Masukkan visi utama...">{{ old('visi', $pengaturan['visi'] ?? '') }}</textarea>
                    <p class="text-[11px] text-slate-400 mt-1">Akan ditampilkan pada banner utama blok Visi dengan gaya highlight.</p>
                </div>

                <div>
                    <label for="misi" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Misi Utama (Satu Baris Per Poin)
                    </label>
                    <textarea id="misi" name="misi" rows="6"
                        class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors"
                        placeholder="Poin Misi 1&#10;Poin Misi 2&#10;Poin Misi 3&#10;Poin Misi 4...">{{ old('misi', $pengaturan['misi'] ?? '') }}</textarea>
                    <p class="text-[11px] text-slate-400 mt-1">
                        💡 Pisahkan setiap misi dengan menekan <span class="font-bold">Enter (baris baru)</span>. Sistem akan otomatis memecahnya menjadi kartu misi di halaman beranda.
                    </p>
                </div>
            </div>
        </div>

        {{-- KONTEN TAB 2: SAMBUTAN & KETUA UMUM --}}
        <div x-show="tab === 'sambutan'" x-cloak class="space-y-6">
            <div class="bg-white p-6 md:p-8 rounded-2xl border border-slate-200 shadow-xs space-y-6">
                <div class="border-b border-slate-100 pb-4">
                    <h3 class="font-bold text-slate-800 text-base flex items-center gap-2">
                        <span class="material-symbols-outlined text-amber-500">person</span>
                        <span>Mengenal APPSI &amp; Profil Ketua Umum</span>
                    </h3>
                    <p class="text-xs text-slate-500 mt-1">
                        Atur foto resmi, nama, jabatan, serta narasi sambutan di blok "Mengenal APPSI".
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                    {{-- Preview & Upload Foto Ketua Umum --}}
                    <div class="lg:col-span-4 bg-slate-50 border border-slate-200 rounded-2xl p-5 flex flex-col items-center text-center space-y-4">
                        <span class="text-xs font-bold text-slate-700 uppercase tracking-wider">Foto Resmi Ketua Umum</span>

                        <div class="relative w-48 aspect-[3/4] rounded-2xl overflow-hidden shadow-md border-2 border-slate-200 bg-slate-200 group">
                            <img :src="previewUrl" alt="Foto Ketua Umum"
                                 class="w-full h-full object-cover object-top"
                                 onerror="this.src='{{ asset('storage/pengurus/kaltim.jpg') }}'">
                        </div>

                        <div class="w-full space-y-2">
                            <label for="beranda_foto_ketua" class="w-full px-4 py-2.5 bg-navy-900 hover:bg-navy-800 text-white rounded-xl text-xs font-bold cursor-pointer transition-all inline-flex items-center justify-center gap-2 shadow-sm">
                                <span class="material-symbols-outlined text-sm">upload_file</span>
                                <span>Ganti Foto</span>
                            </label>
                            <input type="file" id="beranda_foto_ketua" name="beranda_foto_ketua" accept="image/*" class="hidden" @change="handleFileSelect($event)">

                            @if(!empty($pengaturan['beranda_foto_ketua']))
                            <label class="inline-flex items-center gap-2 text-xs text-rose-600 font-medium cursor-pointer pt-1">
                                <input type="checkbox" name="hapus_foto_ketua" value="1" class="rounded text-rose-600 focus:ring-rose-500">
                                <span>Reset ke foto default</span>
                            </label>
                            @endif

                            <p class="text-[11px] text-slate-400">Rekomendasi rasio 3:4, format JPG/PNG, maks. 3 MB.</p>
                        </div>
                    </div>

                    {{-- Data Teks Sambutan & Identitas --}}
                    <div class="lg:col-span-8 space-y-5">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="ketua_umum" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    Nama Lengkap &amp; Gelar Ketua Umum
                                </label>
                                <input type="text" id="ketua_umum" name="ketua_umum"
                                    value="{{ old('ketua_umum', $pengaturan['ketua_umum'] ?? '') }}"
                                    class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors">
                            </div>

                            <div>
                                <label for="ketua_umum_provinsi" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    Jabatan Kepala Daerah
                                </label>
                                <input type="text" id="ketua_umum_provinsi" name="ketua_umum_provinsi"
                                    value="{{ old('ketua_umum_provinsi', $pengaturan['ketua_umum_provinsi'] ?? '') }}"
                                    class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="periode" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    Periode Kepengurusan
                                </label>
                                <input type="text" id="periode" name="periode"
                                    value="{{ old('periode', $pengaturan['periode'] ?? '') }}"
                                    class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors"
                                    placeholder="2025–2029">
                            </div>

                            <div>
                                <label for="beranda_sambutan_badge" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    Label / Badge Atas
                                </label>
                                <input type="text" id="beranda_sambutan_badge" name="beranda_sambutan_badge"
                                    value="{{ old('beranda_sambutan_badge', $pengaturan['beranda_sambutan_badge'] ?? '') }}"
                                    class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors">
                            </div>
                        </div>

                        <div>
                            <label for="beranda_sambutan_judul" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Judul Pengantar / Headline Mengenal APPSI
                            </label>
                            <input type="text" id="beranda_sambutan_judul" name="beranda_sambutan_judul"
                                value="{{ old('beranda_sambutan_judul', $pengaturan['beranda_sambutan_judul'] ?? '') }}"
                                class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-bold text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors">
                        </div>

                        <div>
                            <label for="beranda_sambutan_teks" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Teks Narasi / Sambutan Mengenal APPSI
                            </label>
                            <textarea id="beranda_sambutan_teks" name="beranda_sambutan_teks" rows="6"
                                class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-normal text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors leading-relaxed">{{ old('beranda_sambutan_teks', $pengaturan['beranda_sambutan_teks'] ?? '') }}</textarea>
                            <p class="text-[11px] text-slate-400 mt-1">Gunakan enter untuk memisahkan paragraf baru.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- KONTEN TAB 3: KUTIPAN TOKOH (QUOTE) --}}
        <div x-show="tab === 'quote'" x-cloak class="space-y-6">
            <div class="bg-white p-6 md:p-8 rounded-2xl border border-slate-200 shadow-xs space-y-6">
                <div class="border-b border-slate-100 pb-4">
                    <h3 class="font-bold text-slate-800 text-base flex items-center gap-2">
                        <span class="material-symbols-outlined text-amber-500">format_quote</span>
                        <span>Kutipan Tokoh (Inspirational Quote)</span>
                    </h3>
                    <p class="text-xs text-slate-500 mt-1">
                        Blok kutipan yang tampil tepat di bawah Hero Slider pada halaman utama.
                    </p>
                </div>

                <div>
                    <label for="beranda_quote_teks" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Isi Kutipan
                    </label>
                    <textarea id="beranda_quote_teks" name="beranda_quote_teks" rows="3"
                        class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm italic font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors"
                        placeholder="Tuliskan pesan kutipan...">{{ old('beranda_quote_teks', $pengaturan['beranda_quote_teks'] ?? '') }}</textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="beranda_quote_tokoh" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Nama Tokoh
                        </label>
                        <input type="text" id="beranda_quote_tokoh" name="beranda_quote_tokoh"
                            value="{{ old('beranda_quote_tokoh', $pengaturan['beranda_quote_tokoh'] ?? '') }}"
                            class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors"
                            placeholder="Contoh: H Rudy Mas’ud">
                    </div>

                    <div>
                        <label for="beranda_quote_sub" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Keterangan / Jabatan (Opsional)
                        </label>
                        <input type="text" id="beranda_quote_sub" name="beranda_quote_sub"
                            value="{{ old('beranda_quote_sub', $pengaturan['beranda_quote_sub'] ?? '') }}"
                            class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors"
                            placeholder="Contoh: Ketua Umum APPSI">
                    </div>
                </div>
            </div>
        </div>

        {{-- KONTEN TAB 4: PERAN & FUNGSI (4 PILAR) --}}
        <div x-show="tab === 'peran'" x-cloak class="space-y-6">
            <div class="bg-white p-6 md:p-8 rounded-2xl border border-slate-200 shadow-xs space-y-6">
                <div class="border-b border-slate-100 pb-4">
                    <h3 class="font-bold text-slate-800 text-base flex items-center gap-2">
                        <span class="material-symbols-outlined text-amber-500">hub</span>
                        <span>Peran &amp; Fungsi APPSI (4 Pilar Utama)</span>
                    </h3>
                    <p class="text-xs text-slate-500 mt-1">
                        Sesuaikan judul dan uraian singkat untuk 4 kartu pilar peran kontribusi APPSI.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Pilar 1 --}}
                    <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl space-y-3">
                        <div class="flex items-center gap-2 text-navy-900 font-bold text-xs">
                            <span class="w-6 h-6 rounded-full bg-amber-500 text-navy-950 flex items-center justify-center font-bold text-xs">1</span>
                            <span>Pilar 1 (Ikon: Koordinasi)</span>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Judul Pilar 1</label>
                            <input type="text" name="beranda_peran_1_judul"
                                value="{{ old('beranda_peran_1_judul', $pengaturan['beranda_peran_1_judul'] ?? '') }}"
                                class="w-full bg-white border border-slate-300 rounded-xl px-3.5 py-2 text-xs font-bold text-slate-800 focus:border-navy-900 focus:ring-1 focus:ring-navy-900">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Deskripsi Singkat</label>
                            <textarea name="beranda_peran_1_deskripsi" rows="3"
                                class="w-full bg-white border border-slate-300 rounded-xl px-3.5 py-2 text-xs font-medium text-slate-700 focus:border-navy-900 focus:ring-1 focus:ring-navy-900">{{ old('beranda_peran_1_deskripsi', $pengaturan['beranda_peran_1_deskripsi'] ?? '') }}</textarea>
                        </div>
                    </div>

                    {{-- Pilar 2 --}}
                    <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl space-y-3">
                        <div class="flex items-center gap-2 text-navy-900 font-bold text-xs">
                            <span class="w-6 h-6 rounded-full bg-amber-500 text-navy-950 flex items-center justify-center font-bold text-xs">2</span>
                            <span>Pilar 2 (Ikon: Kebijakan)</span>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Judul Pilar 2</label>
                            <input type="text" name="beranda_peran_2_judul"
                                value="{{ old('beranda_peran_2_judul', $pengaturan['beranda_peran_2_judul'] ?? '') }}"
                                class="w-full bg-white border border-slate-300 rounded-xl px-3.5 py-2 text-xs font-bold text-slate-800 focus:border-navy-900 focus:ring-1 focus:ring-navy-900">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Deskripsi Singkat</label>
                            <textarea name="beranda_peran_2_deskripsi" rows="3"
                                class="w-full bg-white border border-slate-300 rounded-xl px-3.5 py-2 text-xs font-medium text-slate-700 focus:border-navy-900 focus:ring-1 focus:ring-navy-900">{{ old('beranda_peran_2_deskripsi', $pengaturan['beranda_peran_2_deskripsi'] ?? '') }}</textarea>
                        </div>
                    </div>

                    {{-- Pilar 3 --}}
                    <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl space-y-3">
                        <div class="flex items-center gap-2 text-navy-900 font-bold text-xs">
                            <span class="w-6 h-6 rounded-full bg-amber-500 text-navy-950 flex items-center justify-center font-bold text-xs">3</span>
                            <span>Pilar 3 (Ikon: Kapasitas)</span>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Judul Pilar 3</label>
                            <input type="text" name="beranda_peran_3_judul"
                                value="{{ old('beranda_peran_3_judul', $pengaturan['beranda_peran_3_judul'] ?? '') }}"
                                class="w-full bg-white border border-slate-300 rounded-xl px-3.5 py-2 text-xs font-bold text-slate-800 focus:border-navy-900 focus:ring-1 focus:ring-navy-900">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Deskripsi Singkat</label>
                            <textarea name="beranda_peran_3_deskripsi" rows="3"
                                class="w-full bg-white border border-slate-300 rounded-xl px-3.5 py-2 text-xs font-medium text-slate-700 focus:border-navy-900 focus:ring-1 focus:ring-navy-900">{{ old('beranda_peran_3_deskripsi', $pengaturan['beranda_peran_3_deskripsi'] ?? '') }}</textarea>
                        </div>
                    </div>

                    {{-- Pilar 4 --}}
                    <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl space-y-3">
                        <div class="flex items-center gap-2 text-navy-900 font-bold text-xs">
                            <span class="w-6 h-6 rounded-full bg-amber-500 text-navy-950 flex items-center justify-center font-bold text-xs">4</span>
                            <span>Pilar 4 (Ikon: Sinergi)</span>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Judul Pilar 4</label>
                            <input type="text" name="beranda_peran_4_judul"
                                value="{{ old('beranda_peran_4_judul', $pengaturan['beranda_peran_4_judul'] ?? '') }}"
                                class="w-full bg-white border border-slate-300 rounded-xl px-3.5 py-2 text-xs font-bold text-slate-800 focus:border-navy-900 focus:ring-1 focus:ring-navy-900">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Deskripsi Singkat</label>
                            <textarea name="beranda_peran_4_deskripsi" rows="3"
                                class="w-full bg-white border border-slate-300 rounded-xl px-3.5 py-2 text-xs font-medium text-slate-700 focus:border-navy-900 focus:ring-1 focus:ring-navy-900">{{ old('beranda_peran_4_deskripsi', $pengaturan['beranda_peran_4_deskripsi'] ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- KONTEN TAB 5: PROGRAM UTAMA (3 INISIATIF) --}}
        <div x-show="tab === 'program'" x-cloak class="space-y-6">
            <div class="bg-white p-6 md:p-8 rounded-2xl border border-slate-200 shadow-xs space-y-6">
                <div class="border-b border-slate-100 pb-4">
                    <h3 class="font-bold text-slate-800 text-base flex items-center gap-2">
                        <span class="material-symbols-outlined text-amber-500">workspace_premium</span>
                        <span>Program Utama APPSI (3 Inisiatif Strategis)</span>
                    </h3>
                    <p class="text-xs text-slate-500 mt-1">
                        Sesuaikan nama inisiatif dan penjelasan program kerja unggulan pada beranda.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    {{-- Program 1 --}}
                    <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl space-y-3">
                        <div class="flex items-center gap-2 text-navy-900 font-bold text-xs">
                            <span class="w-6 h-6 rounded-full bg-amber-500 text-navy-950 flex items-center justify-center font-bold text-xs">1</span>
                            <span>Program 1 (Rakornas)</span>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Program 1</label>
                            <input type="text" name="beranda_program_1_judul"
                                value="{{ old('beranda_program_1_judul', $pengaturan['beranda_program_1_judul'] ?? '') }}"
                                class="w-full bg-white border border-slate-300 rounded-xl px-3.5 py-2 text-xs font-bold text-slate-800 focus:border-navy-900 focus:ring-1 focus:ring-navy-900">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Deskripsi Singkat</label>
                            <textarea name="beranda_program_1_deskripsi" rows="3"
                                class="w-full bg-white border border-slate-300 rounded-xl px-3.5 py-2 text-xs font-medium text-slate-700 focus:border-navy-900 focus:ring-1 focus:ring-navy-900">{{ old('beranda_program_1_deskripsi', $pengaturan['beranda_program_1_deskripsi'] ?? '') }}</textarea>
                        </div>
                    </div>

                    {{-- Program 2 --}}
                    <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl space-y-3">
                        <div class="flex items-center gap-2 text-navy-900 font-bold text-xs">
                            <span class="w-6 h-6 rounded-full bg-amber-500 text-navy-950 flex items-center justify-center font-bold text-xs">2</span>
                            <span>Program 2 (Best Practice)</span>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Program 2</label>
                            <input type="text" name="beranda_program_2_judul"
                                value="{{ old('beranda_program_2_judul', $pengaturan['beranda_program_2_judul'] ?? '') }}"
                                class="w-full bg-white border border-slate-300 rounded-xl px-3.5 py-2 text-xs font-bold text-slate-800 focus:border-navy-900 focus:ring-1 focus:ring-navy-900">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Deskripsi Singkat</label>
                            <textarea name="beranda_program_2_deskripsi" rows="3"
                                class="w-full bg-white border border-slate-300 rounded-xl px-3.5 py-2 text-xs font-medium text-slate-700 focus:border-navy-900 focus:ring-1 focus:ring-navy-900">{{ old('beranda_program_2_deskripsi', $pengaturan['beranda_program_2_deskripsi'] ?? '') }}</textarea>
                        </div>
                    </div>

                    {{-- Program 3 --}}
                    <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl space-y-3">
                        <div class="flex items-center gap-2 text-navy-900 font-bold text-xs">
                            <span class="w-6 h-6 rounded-full bg-amber-500 text-navy-950 flex items-center justify-center font-bold text-xs">3</span>
                            <span>Program 3 (Kajian)</span>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Program 3</label>
                            <input type="text" name="beranda_program_3_judul"
                                value="{{ old('beranda_program_3_judul', $pengaturan['beranda_program_3_judul'] ?? '') }}"
                                class="w-full bg-white border border-slate-300 rounded-xl px-3.5 py-2 text-xs font-bold text-slate-800 focus:border-navy-900 focus:ring-1 focus:ring-navy-900">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Deskripsi Singkat</label>
                            <textarea name="beranda_program_3_deskripsi" rows="3"
                                class="w-full bg-white border border-slate-300 rounded-xl px-3.5 py-2 text-xs font-medium text-slate-700 focus:border-navy-900 focus:ring-1 focus:ring-navy-900">{{ old('beranda_program_3_deskripsi', $pengaturan['beranda_program_3_deskripsi'] ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- KONTEN TAB 6: VIDEO & MEDIA BERANDA --}}
        <div x-show="tab === 'media'" x-cloak class="space-y-6">
            <div class="bg-white p-6 md:p-8 rounded-2xl border border-slate-200 shadow-xs space-y-6">
                <div class="border-b border-slate-100 pb-4">
                    <h3 class="font-bold text-slate-800 text-base flex items-center gap-2">
                        <span class="material-symbols-outlined text-amber-500">play_circle</span>
                        <span>Video Galeri Beranda</span>
                    </h3>
                    <p class="text-xs text-slate-500 mt-1">
                        Secara otomatis sistem menyinkronkan video terbaru dari kanal YouTube resmi APPSI. Anda dapat memasukkan Video ID YouTube khusus jika ingin menyematkan video tertentu secara permanen.
                    </p>
                </div>

                <div>
                    <label for="beranda_youtube_video_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Custom YouTube Video ID (Opsional)
                    </label>
                    <input type="text" id="beranda_youtube_video_id" name="beranda_youtube_video_id"
                        value="{{ old('beranda_youtube_video_id', $pengaturan['beranda_youtube_video_id'] ?? '') }}"
                        class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-mono text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors"
                        placeholder="Contoh: IkTBVVKkpus (kosongkan untuk auto-sync video terbaru)">
                    <p class="text-[11px] text-slate-400 mt-1">
                        Masukkan hanya ID video (kode 11 karakter di akhir link youtube.com/watch?v=<strong>IkTBVVKkpus</strong>). Jika dikosongkan, website otomatis menampilkan video terbaru dari channel resmi.
                    </p>
                </div>
            </div>
        </div>

        {{-- KONTEN TAB 7: INSTAGRAM FEED --}}
        <div x-show="tab === 'instagram'" x-cloak class="space-y-6">
            <div class="bg-white p-6 md:p-8 rounded-2xl border border-slate-200 shadow-xs space-y-6">
                <div class="border-b border-slate-100 pb-4">
                    <h3 class="font-bold text-slate-800 text-base flex items-center gap-2">
                        <span class="material-symbols-outlined text-pink-500">photo_camera</span>
                        <span>Feed Aktivitas Instagram</span>
                    </h3>
                    <p class="text-xs text-slate-500 mt-1">
                        Postingan Instagram APPSI otomatis diperbarui setiap 6 jam melalui sistem terjadwal.
                        Gunakan tombol di bawah untuk memperbarui secara manual kapan pun diperlukan.
                    </p>
                </div>

                {{-- Info Status Cache --}}
                <div class="bg-gradient-to-r from-pink-50 to-purple-50 border border-pink-200/60 rounded-xl px-5 py-4 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 fill-white" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-700">@appsi.or.id — Feed Resmi</p>
                            <p class="text-[11px] text-slate-500 mt-0.5">
                                Cache diperbarui setiap 6 jam otomatis.
                                Jadwal berikutnya: <strong class="text-pink-600">setiap 6 jam sekali</strong>.
                            </p>
                        </div>
                    </div>

                    {{-- Tombol Refresh Manual --}}
                    <button type="button"
                        onclick="if(confirm('Jalankan scraper Instagram sekarang? Proses ini membutuhkan ~15 detik.')) { this.disabled=true; this.innerHTML='<span class=\'material-symbols-outlined text-sm animate-spin\'>sync</span> Memperbarui...'; document.getElementById('instagramRefreshForm').submit(); }"
                        class="inline-flex items-center gap-2 px-5 py-2.5 text-xs font-bold text-white rounded-xl transition-all hover:scale-105 active:scale-95 shadow-md cursor-pointer"
                        style="background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);">
                        <span class="material-symbols-outlined text-sm">refresh</span>
                        <span>Refresh Feed Sekarang</span>
                    </button>
                </div>

                {{-- Preview Postingan yang Tersimpan di Cache --}}
                <div>
                    <p class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-3">Postingan yang Kini Ditampilkan di Beranda</p>
                    @php
                        $cachedPosts = Cache::get('appsi_instagram_latest_posts_auto', []);
                        $displayPosts = array_slice($cachedPosts, 0, 3);
                    @endphp

                    @if(!empty($displayPosts))
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            @foreach($displayPosts as $idx => $post)
                            <div class="border border-slate-200 rounded-xl p-3 bg-slate-50 flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 {{ strtolower($post['type']) === 'reel' ? 'bg-purple-100' : 'bg-pink-100' }}">
                                    <span class="material-symbols-outlined text-sm {{ strtolower($post['type']) === 'reel' ? 'text-purple-500' : 'text-pink-500' }}">{{ strtolower($post['type']) === 'reel' ? 'movie' : 'image' }}</span>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-[11px] font-bold text-slate-700 uppercase">{{ strtoupper($post['type']) }}</p>
                                    <a href="{{ $post['url'] }}" target="_blank" class="text-[11px] text-pink-600 hover:underline font-mono truncate block">{{ $post['code'] }}</a>
                                </div>
                                <span class="ml-auto text-[10px] bg-slate-200 text-slate-500 rounded-full px-2 py-0.5 font-bold">#{{ $idx + 1 }}</span>
                            </div>
                            @endforeach
                        </div>
                        <p class="text-[11px] text-slate-400 mt-2">Menampilkan {{ count($cachedPosts) }} postingan tersimpan di cache. Hanya 3 pertama yang ditampilkan di beranda.</p>
                    @else
                        <div class="border border-dashed border-slate-300 rounded-xl py-8 text-center text-slate-400 text-xs">
                            <span class="material-symbols-outlined text-3xl block mb-2">cloud_off</span>
                            Cache kosong. Klik "Refresh Feed Sekarang" untuk mengisi.
                        </div>
                    @endif
                </div>

                {{-- Opsi Kode Embed Widget Pihak Ketiga --}}
                <div class="border-t border-slate-100 pt-5 space-y-3">
                    <div class="flex items-center justify-between">
                        <label for="instagram_widget_code" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                            Kode Embed Widget Instagram Pihak Ketiga (Opsional)
                        </label>
                        <span class="text-[10px] bg-slate-100 text-slate-500 font-semibold px-2 py-0.5 rounded-md">Opsional Override</span>
                    </div>
                    <textarea id="instagram_widget_code" name="instagram_widget_code" rows="3"
                        class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-xs font-mono text-slate-800 focus:bg-white focus:outline-none focus:border-pink-500 focus:ring-1 focus:ring-pink-500 transition-colors"
                        placeholder="Contoh: <iframe src='https://snapwidget.com/embed/...' ...></iframe>">{{ old('instagram_widget_code', $pengaturan['instagram_widget_code'] ?? '') }}</textarea>
                    <div class="bg-amber-50/80 border border-amber-200/60 rounded-xl px-3.5 py-2.5 flex items-start gap-2">
                        <span class="material-symbols-outlined text-amber-500 text-sm mt-0.5 shrink-0">lightbulb</span>
                        <p class="text-[11px] text-slate-600 leading-relaxed">
                            <strong>Cara kerja:</strong> Jika kolom ini diisi kode embed (misal dari <a href="https://snapwidget.com" target="_blank" class="text-amber-700 hover:underline font-semibold">SnapWidget</a>, <a href="https://behold.so" target="_blank" class="text-amber-700 hover:underline font-semibold">Behold.so</a>, atau Elfsight), maka widget tersebut yang akan ditampilkan di beranda. Jika dikosongkan, beranda otomatis menggunakan feed resmi @appsi.or.id yang disinkronkan berkala.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Action Bar / Submit Bar --}}
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4 sticky bottom-4 z-20">
            <div class="flex items-center gap-2 text-xs text-slate-500">
                <span class="material-symbols-outlined text-amber-500 text-base">info</span>
                <span>Perubahan langsung tersinkronisasi ke seluruh pengunjung website.</span>
            </div>
            <div class="flex items-center gap-3">
                <div x-show="tab === 'instagram'" class="text-xs text-pink-600 font-semibold items-center gap-1.5 hidden sm:flex">
                    <span class="material-symbols-outlined text-sm">schedule</span>
                    <span>Auto-sync 6 jam</span>
                </div>
                <button type="submit" class="px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-navy-950 font-bold text-xs rounded-xl shadow-md transition-all inline-flex items-center justify-center gap-2 shrink-0 cursor-pointer">
                    <span class="material-symbols-outlined text-sm">save</span>
                    <span>Simpan Pengaturan Beranda</span>
                </button>
            </div>
        </div>

    </form>
    
    {{-- Form Refresh Instagram (ditempatkan di luar form utama agar tidak terjadi nested form) --}}
    <form id="instagramRefreshForm" method="POST" action="{{ route('admin.instagram.refresh') }}" class="hidden">
        @csrf
    </form>
</div>
@endsection
