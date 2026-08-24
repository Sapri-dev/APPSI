@extends('layouts.admin')

@section('title', $berita ? 'Edit Berita' : 'Tambah Berita Baru')
@section('subtitle', $berita ? 'Perbarui informasi berita/artikel' : 'Tulis artikel atau siaran pers baru')

@section('content')
<div class="w-full space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('admin.berita.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-slate-800 transition-colors">
            <span class="material-symbols-outlined text-base">arrow_back</span>
            <span>Kembali ke Daftar Berita</span>
        </a>
    </div>

    <form action="{{ $berita ? route('admin.berita.update', $berita->id) : route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($berita)
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            {{-- Kolom Kiri: Konten Utama Editor (8 Kolom) --}}
            <div class="lg:col-span-8 space-y-6">
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-5">
                    <!-- Judul -->
                    <div>
                        <label for="judul" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Judul Berita <span class="text-rose-500">*</span></label>
                        <input type="text" id="judul" name="judul" value="{{ old('judul', $berita->judul ?? '') }}" required
                            class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-base font-bold text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors"
                            placeholder="Masukkan judul berita lengkap...">
                        @error('judul')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Ringkasan -->
                    <div>
                        <label for="ringkasan" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Ringkasan / Abstrak</label>
                        <textarea id="ringkasan" name="ringkasan" rows="3"
                            class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors"
                            placeholder="Ringkasan singkat 1-2 kalimat untuk kartu berita...">{{ old('ringkasan', $berita->ringkasan ?? '') }}</textarea>
                    </div>

                    <!-- Konten Lengkap (TinyMCE Rich Text) -->
                    <div>
                        <label for="konten" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Isi Artikel Lengkap <span class="text-rose-500">*</span></label>
                        <textarea id="konten" name="konten" rows="18"
                            class="tinymce-editor w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm">{{ old('konten', $berita->konten ?? '') }}</textarea>
                        @error('konten')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Pengaturan Publikasi, Kategori & Gambar (4 Kolom) --}}
            <div class="lg:col-span-4 space-y-6">
                <!-- Card Status Publikasi & Aksi -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-5">
                    <h3 class="font-bold text-slate-800 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
                        <span class="material-symbols-outlined text-amber-500">publish</span>
                        <span>Status Publikasi</span>
                    </h3>

                    <!-- Tanggal Publikasi -->
                    <div>
                        <label for="tanggal_publikasi" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tanggal Terbit <span class="text-rose-500">*</span></label>
                        <input type="date" id="tanggal_publikasi" name="tanggal_publikasi" value="{{ old('tanggal_publikasi', isset($berita->tanggal_publikasi) ? $berita->tanggal_publikasi->format('Y-m-d') : date('Y-m-d')) }}" required
                            class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors">
                    </div>

                    <!-- Checkbox Status -->
                    <div class="pt-2 border-t border-slate-100">
                        <label class="flex items-start gap-3 cursor-pointer">
                            <input type="checkbox" name="is_published" value="1" {{ old('is_published', $berita->is_published ?? true) ? 'checked' : '' }}
                                class="w-4 h-4 mt-0.5 rounded border-slate-300 text-amber-500 focus:ring-amber-500">
                            <div>
                                <span class="text-xs font-bold text-slate-800">Publikasikan Langsung</span>
                                <p class="text-[11px] text-slate-500 mt-0.5">Artikel akan langsung tayang di portal publik.</p>
                            </div>
                        </label>
                    </div>

                    <!-- Tombol Simpan -->
                    <div class="pt-3 border-t border-slate-100 flex items-center gap-3">
                        <a href="{{ route('admin.berita.index') }}" class="flex-1 text-center py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs rounded-xl transition-colors">
                            Batal
                        </a>
                        <button type="submit" class="flex-1 py-2.5 bg-amber-500 hover:bg-amber-600 text-navy-950 font-bold text-xs rounded-xl shadow-md transition-all inline-flex items-center justify-center gap-1.5">
                            <span class="material-symbols-outlined text-sm">save</span>
                            <span>{{ $berita ? 'Simpan' : 'Terbitkan' }}</span>
                        </button>
                    </div>
                </div>

                <!-- Card Kategori Berita -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-4">
                    <h3 class="font-bold text-slate-800 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
                        <span class="material-symbols-outlined text-amber-500">category</span>
                        <span>Kategori Berita</span>
                    </h3>

                    <div>
                        <select id="kategori" name="kategori" required
                            class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors">
                            <option value="Berita" {{ old('kategori', $berita->kategori ?? '') == 'Berita' ? 'selected' : '' }}>Berita</option>
                            <option value="Munas" {{ old('kategori', $berita->kategori ?? '') == 'Munas' ? 'selected' : '' }}>Munas</option>
                            <option value="Rapat Kerja Nasional" {{ old('kategori', $berita->kategori ?? '') == 'Rapat Kerja Nasional' ? 'selected' : '' }}>Rapat Kerja Nasional</option>
                            <option value="Seminar Nasional" {{ old('kategori', $berita->kategori ?? '') == 'Seminar Nasional' ? 'selected' : '' }}>Seminar Nasional</option>
                            <option value="Umum" {{ old('kategori', $berita->kategori ?? '') == 'Umum' ? 'selected' : '' }}>Umum</option>
                        </select>
                    </div>
                </div>

                <!-- Card Gambar Utama / Header -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-4">
                    <h3 class="font-bold text-slate-800 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
                        <span class="material-symbols-outlined text-amber-500">image</span>
                        <span>Gambar Utama</span>
                    </h3>

                    @if(isset($berita) && $berita->gambar)
                        <div class="relative rounded-xl overflow-hidden border border-slate-200 aspect-video bg-slate-900">
                            <img src="{{ $berita->gambar_url }}" alt="Preview" class="w-full h-full object-cover">
                        </div>
                    @endif

                    <div>
                        <label for="gambar" class="block text-xs font-semibold text-slate-600 mb-1.5">{{ isset($berita) && $berita->gambar ? 'Ganti Berkas Gambar' : 'Pilih Berkas Gambar' }}</label>
                        <input type="file" id="gambar" name="gambar" accept="image/*"
                            class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 py-1 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-navy-900 file:text-white hover:file:bg-navy-800 transition-colors">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        if (typeof tinymce !== 'undefined') {
            tinymce.init({
                selector: '.tinymce-editor',
                height: 480,
                menubar: false,
                plugins: [
                    'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                    'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                    'insertdatetime', 'media', 'table', 'code', 'help', 'wordcount'
                ],
                toolbar: 'undo redo | blocks | ' +
                    'bold italic backcolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat | link table code fullscreen',
                content_style: 'body { font-family: Plus Jakarta Sans, sans-serif; font-size:14px }'
            });
        }
    });
</script>
@endpush
