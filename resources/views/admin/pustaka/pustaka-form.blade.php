@extends('layouts.admin')

@section('title', $pustaka ? 'Edit Dokumen' : 'Upload Dokumen Baru')
@section('subtitle', $pustaka ? 'Perbarui berkas atau data dokumen' : 'Tambah dokumen regulasi, UU, AD/ART, SK, atau data BPS baru')

@section('content')
<div class="w-full space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('admin.pustaka.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-slate-800 transition-colors">
            <span class="material-symbols-outlined text-base">arrow_back</span>
            <span>Kembali ke Daftar Pustaka</span>
        </a>
    </div>

    <form action="{{ $pustaka ? route('admin.pustaka.update', $pustaka->id) : route('admin.pustaka.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($pustaka)
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            {{-- Kolom Kiri: Informasi Dokumen (8 Kolom) --}}
            <div class="lg:col-span-8 space-y-6">
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-5">
                    <h3 class="font-bold text-slate-800 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
                        <span class="material-symbols-outlined text-amber-500">article</span>
                        <span>Informasi Dokumen</span>
                    </h3>

                    <!-- Judul -->
                    <div>
                        <label for="judul" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Judul Dokumen <span class="text-rose-500">*</span></label>
                        <input type="text" id="judul" name="judul" value="{{ old('judul', $pustaka->judul ?? '') }}" required
                            class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-base font-bold text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors"
                            placeholder="Contoh: AD/ART Asosiasi Pemerintah Provinsi Seluruh Indonesia Tahun 2025">
                        @error('judul')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kategori & Tahun -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            @php
                                $selectedKategori = old('kategori', $pustaka->kategori ?? 'uu');
                                $isCustom = !in_array($selectedKategori, $daftarKategori ?? []) && !empty($selectedKategori) && $selectedKategori !== '__baru__';
                            @endphp

                            <label for="kategori" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kategori Dokumen <span class="text-rose-500">*</span></label>
                            <select id="kategori" name="kategori" required
                                class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors">
                                @foreach($daftarKategori ?? ['uu', 'adart', 'rekomendasi', 'sk', 'berita_acara', 'data_bps'] as $kat)
                                    @php
                                        $lbl = match($kat) {
                                            'uu'          => 'Undang-Undang (UU)',
                                            'adart'       => 'AD / ART',
                                            'rekomendasi' => 'Rekomendasi',
                                            'sk'          => 'Surat Keputusan (SK)',
                                            'berita_acara'=> 'Berita Acara',
                                            'data_bps'    => 'Data BPS',
                                            default       => $kat,
                                        };
                                    @endphp
                                    <option value="{{ $kat }}" {{ $selectedKategori == $kat ? 'selected' : '' }}>{{ $lbl }}</option>
                                @endforeach
                                @if($isCustom)
                                    <option value="{{ $selectedKategori }}" selected>{{ $selectedKategori }} (Kustom)</option>
                                @endif
                                <option value="__baru__" {{ old('kategori') == '__baru__' ? 'selected' : '' }}>+ Tambah Kategori Baru...</option>
                            </select>

                            <!-- Input Teks Kategori Baru -->
                            <div id="kategori_baru_wrap" class="{{ old('kategori') == '__baru__' || old('kategori_baru') ? '' : 'hidden' }} pt-2 space-y-1.5">
                                <div class="flex items-center justify-between">
                                    <label for="kategori_baru" class="block text-xs font-bold text-amber-700 uppercase tracking-wider">
                                        Tulis Nama Kategori Pustaka Baru
                                    </label>
                                    <button type="button" id="btn_cancel_kategori_baru" class="text-[11px] text-slate-400 hover:text-rose-500 transition-colors font-medium">
                                        Batal
                                    </button>
                                </div>
                                <input type="text" id="kategori_baru" name="kategori_baru" value="{{ old('kategori_baru') }}"
                                    class="w-full bg-amber-50/60 border border-amber-300 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-colors"
                                    placeholder="Ketik nama kategori baru (contoh: Laporan Keuangan, Panduan)...">
                                <p class="text-[11px] text-slate-500 leading-normal">
                                    Kategori baru akan otomatis tersimpan dan tersedia untuk dokumen pustaka selanjutnya.
                                </p>
                            </div>
                        </div>

                        <div>
                            <label for="tahun" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tahun Penerbitan</label>
                            <input type="number" id="tahun" name="tahun" value="{{ old('tahun', $pustaka->tahun ?? date('Y')) }}" placeholder="2025" min="1990" max="2099"
                                class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors">
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label for="deskripsi" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Deskripsi / Keterangan Dokumen</label>
                        <textarea id="deskripsi" name="deskripsi" rows="5"
                            class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors"
                            placeholder="Ringkasan atau poin-poin utama isi dokumen...">{{ old('deskripsi', $pustaka->deskripsi ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Berkas, Status & Aksi (4 Kolom) --}}
            <div class="lg:col-span-4 space-y-6">
                <!-- Card Unggah Berkas -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-5">
                    <h3 class="font-bold text-slate-800 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
                        <span class="material-symbols-outlined text-amber-500">folder_zip</span>
                        <span>Berkas Dokumen</span>
                    </h3>

                    <!-- File Upload Lokal -->
                    <div>
                        <label for="file" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Unggah Berkas PDF / DOC</label>
                        @if(isset($pustaka) && $pustaka->file)
                            <div class="mb-3 flex items-center gap-3 p-3 bg-slate-50 rounded-xl border border-slate-200 text-xs text-slate-600">
                                <span class="material-symbols-outlined text-emerald-600">check_circle</span>
                                <div class="truncate">
                                    <p class="font-semibold text-slate-700">Berkas lokal tersimpan</p>
                                    <p class="text-[11px] text-slate-400">Pilih berkas baru jika ingin mengganti</p>
                                </div>
                            </div>
                        @endif
                        <input type="file" id="file" name="file" accept=".pdf,.doc,.docx"
                            class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 py-1 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-navy-900 file:text-white hover:file:bg-navy-800 transition-colors">
                        <p class="text-[11px] text-slate-400 mt-1">Maksimal 15 MB per file.</p>
                    </div>

                    <!-- Fallback External Link -->
                    <div>
                        <label for="file_url" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Atau URL Eksternal</label>
                        <input type="url" id="file_url" name="file_url" value="{{ old('file_url', $pustaka->file_url ?? '') }}"
                            class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors"
                            placeholder="https://...">
                    </div>
                </div>

                <!-- Card Status & Aksi -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-5">
                    <h3 class="font-bold text-slate-800 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
                        <span class="material-symbols-outlined text-amber-500">visibility</span>
                        <span>Visibilitas &amp; Simpan</span>
                    </h3>

                    <!-- Status Terbit -->
                    <div>
                        <label class="flex items-start gap-3 cursor-pointer">
                            <input type="checkbox" name="is_published" value="1" {{ old('is_published', $pustaka->is_published ?? true) ? 'checked' : '' }}
                                class="w-4 h-4 mt-0.5 rounded border-slate-300 text-amber-500 focus:ring-amber-500">
                            <div>
                                <span class="text-xs font-bold text-slate-800">Tampilkan untuk Publik</span>
                                <p class="text-[11px] text-slate-500 mt-0.5">Dokumen akan dapat diakses dan dibaca di halaman Pustaka.</p>
                            </div>
                        </label>
                    </div>

                    <!-- Tombol Simpan -->
                    <div class="pt-3 border-t border-slate-100 flex items-center gap-3">
                        <a href="{{ route('admin.pustaka.index') }}" class="flex-1 text-center py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs rounded-xl transition-colors">
                            Batal
                        </a>
                        <button type="submit" class="flex-1 py-2.5 bg-amber-500 hover:bg-amber-600 text-navy-950 font-bold text-xs rounded-xl shadow-md transition-all inline-flex items-center justify-center gap-1.5">
                            <span class="material-symbols-outlined text-sm">save</span>
                            <span>{{ $pustaka ? 'Simpan' : 'Unggah' }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectKat = document.getElementById('kategori');
        const wrapBaru  = document.getElementById('kategori_baru_wrap');
        const inputBaru = document.getElementById('kategori_baru');
        const btnCancel = document.getElementById('btn_cancel_kategori_baru');
        let prevVal     = selectKat ? selectKat.value : '';

        if (!selectKat || !wrapBaru) return;

        selectKat.addEventListener('change', function() {
            if (this.value === '__baru__') {
                wrapBaru.classList.remove('hidden');
                if (inputBaru) inputBaru.focus();
            } else {
                wrapBaru.classList.add('hidden');
                if (inputBaru) inputBaru.value = '';
                prevVal = this.value;
            }
        });

        if (btnCancel) {
            btnCancel.addEventListener('click', function() {
                wrapBaru.classList.add('hidden');
                if (inputBaru) inputBaru.value = '';
                selectKat.value = prevVal !== '__baru__' ? prevVal : (selectKat.options[0] ? selectKat.options[0].value : '');
            });
        }
    });
</script>
@endpush
@endsection
