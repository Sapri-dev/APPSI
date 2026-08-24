@extends('layouts.admin')

@section('title', $pengurus ? 'Edit Pengurus' : 'Tambah Pengurus Baru')
@section('subtitle', $pengurus ? 'Perbarui data anggota pengurus/dewan' : 'Tambah anggota pengurus, penasehat, pakar, atau sekretariat')

@section('content')
<div class="w-full space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('admin.pengurus.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-slate-800 transition-colors">
            <span class="material-symbols-outlined text-base">arrow_back</span>
            <span>Kembali ke Daftar Pengurus</span>
        </a>
    </div>

    <form action="{{ $pengurus ? route('admin.pengurus.update', $pengurus->id) : route('admin.pengurus.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($pengurus)
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            {{-- Kolom Kiri: Informasi Utama (8 Kolom) --}}
            <div class="lg:col-span-8 space-y-6">
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-5">
                    <h3 class="font-bold text-slate-800 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
                        <span class="material-symbols-outlined text-amber-500">badge</span>
                        <span>Informasi Anggota</span>
                    </h3>

                    <!-- Nama -->
                    <div>
                        <label for="nama" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Lengkap &amp; Gelar <span class="text-rose-500">*</span></label>
                        <input type="text" id="nama" name="nama" value="{{ old('nama', $pengurus->nama ?? '') }}" required
                            class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors"
                            placeholder="Contoh: Dr. H. Rudy Mas'ud, SE., ME.">
                        @error('nama')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jabatan & Kategori -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="jabatan" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Jabatan di Organisasi <span class="text-rose-500">*</span></label>
                            <input type="text" id="jabatan" name="jabatan" value="{{ old('jabatan', $pengurus->jabatan ?? '') }}" required
                                class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors"
                                placeholder="Contoh: Ketua Umum / Ketua I / Koordinator Wilayah">
                        </div>

                        <div>
                            <label for="jenis" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kelompok / Dewan <span class="text-rose-500">*</span></label>
                            <select id="jenis" name="jenis" required
                                class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors">
                                <option value="pengurus" {{ old('jenis', $pengurus->jenis ?? '') == 'pengurus' ? 'selected' : '' }}>Dewan Pengurus</option>
                                <option value="penasehat" {{ old('jenis', $pengurus->jenis ?? '') == 'penasehat' ? 'selected' : '' }}>Dewan Penasehat</option>
                                <option value="pakar" {{ old('jenis', $pengurus->jenis ?? '') == 'pakar' ? 'selected' : '' }}>Dewan Pakar</option>
                                <option value="sekretariat" {{ old('jenis', $pengurus->jenis ?? '') == 'sekretariat' ? 'selected' : '' }}>Sekretariat APPSI</option>
                            </select>
                        </div>
                    </div>

                    <!-- Provinsi & Urutan -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="provinsi" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Asal Provinsi (Jika Menjabat Gubernur)</label>
                            <input type="text" id="provinsi" name="provinsi" value="{{ old('provinsi', $pengurus->provinsi ?? '') }}"
                                class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors"
                                placeholder="Contoh: Kalimantan Timur">
                        </div>

                        <div>
                            <label for="periode" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Periode Masa Bakti</label>
                            <input type="text" id="periode" name="periode" value="{{ old('periode', $pengurus->periode ?? '2025-2029') }}"
                                class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors">
                        </div>
                    </div>

                    <!-- Bio / Keterangan -->
                    <div>
                        <label for="bio" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Biodata / Catatan Singkat</label>
                        <textarea id="bio" name="bio" rows="4"
                            class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors"
                            placeholder="Riwayat singkat atau keterangan tambahan...">{{ old('bio', $pengurus->bio ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Foto Profil, Urutan, Status & Aksi (4 Kolom) --}}
            <div class="lg:col-span-4 space-y-6">
                <!-- Card Foto Profil -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-4">
                    <h3 class="font-bold text-slate-800 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
                        <span class="material-symbols-outlined text-amber-500">account_circle</span>
                        <span>Foto Profil</span>
                    </h3>

                    @if(isset($pengurus) && $pengurus->foto)
                        <div class="flex justify-center py-2">
                            <div class="w-32 h-40 rounded-2xl overflow-hidden border-2 border-slate-200 bg-slate-100 shadow-sm">
                                <img src="{{ $pengurus->foto_url }}" alt="Preview" class="w-full h-full object-cover object-top">
                            </div>
                        </div>
                    @endif

                    <div>
                        <label for="foto" class="block text-xs font-semibold text-slate-600 mb-1.5">{{ isset($pengurus) && $pengurus->foto ? 'Ganti Foto' : 'Pilih Berkas Foto' }}</label>
                        <input type="file" id="foto" name="foto" accept="image/*"
                            class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 py-1 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-navy-900 file:text-white hover:file:bg-navy-800 transition-colors">
                    </div>
                </div>

                <!-- Card Pengaturan & Aksi -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-5">
                    <h3 class="font-bold text-slate-800 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
                        <span class="material-symbols-outlined text-amber-500">tune</span>
                        <span>Pengaturan &amp; Simpan</span>
                    </h3>

                    <div>
                        <label for="urutan" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nomor Urutan Tampil</label>
                        <input type="number" id="urutan" name="urutan" value="{{ old('urutan', $pengurus->urutan ?? 0) }}"
                            class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors">
                    </div>

                    <!-- Status Aktif -->
                    <div class="pt-2 border-t border-slate-100">
                        <label class="flex items-start gap-3 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $pengurus->is_active ?? true) ? 'checked' : '' }}
                                class="w-4 h-4 mt-0.5 rounded border-slate-300 text-amber-500 focus:ring-amber-500">
                            <div>
                                <span class="text-xs font-bold text-slate-800">Status Aktif Menjabat</span>
                                <p class="text-[11px] text-slate-500 mt-0.5">Tampilkan profil di halaman publik.</p>
                            </div>
                        </label>
                    </div>

                    <!-- Tombol Simpan -->
                    <div class="pt-3 border-t border-slate-100 flex items-center gap-3">
                        <a href="{{ route('admin.pengurus.index') }}" class="flex-1 text-center py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs rounded-xl transition-colors">
                            Batal
                        </a>
                        <button type="submit" class="flex-1 py-2.5 bg-amber-500 hover:bg-amber-600 text-navy-950 font-bold text-xs rounded-xl shadow-md transition-all inline-flex items-center justify-center gap-1.5">
                            <span class="material-symbols-outlined text-sm">save</span>
                            <span>{{ $pengurus ? 'Simpan' : 'Tambah' }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
