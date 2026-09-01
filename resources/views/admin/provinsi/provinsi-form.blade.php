@extends('layouts.admin')

@section('title', $provinsi ? 'Edit Provinsi: ' . $provinsi->nama : 'Tambah Provinsi Baru')
@section('subtitle', $provinsi ? 'Perbarui informasi Gubernur, ibu kota, dan lambang daerah' : 'Tambah provinsi anggota APPSI baru')

@section('content')
<div class="w-full space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('admin.provinsi.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-slate-800 transition-colors">
            <span class="material-symbols-outlined text-base">arrow_back</span>
            <span>Kembali ke Daftar Provinsi</span>
        </a>
    </div>

    <form action="{{ $provinsi ? route('admin.provinsi.update', $provinsi->id) : route('admin.provinsi.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($provinsi)
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            {{-- Kolom Kiri: Informasi Daerah & Gubernur (8 Kolom) --}}
            <div class="lg:col-span-8 space-y-6">
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-5">
                    @if($provinsi)
                    <div class="flex items-center gap-4 border-b border-slate-100 pb-4">
                        <div class="w-14 h-16 shrink-0 flex items-center justify-center p-1 bg-slate-50 border border-slate-200 rounded-xl">
                            <img src="{{ $provinsi->lambang_url }}" alt="{{ $provinsi->nama }}" class="max-w-full max-h-full object-contain">
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 text-lg">Pemerintah Provinsi {{ $provinsi->nama }}</h3>
                            <p class="text-xs text-slate-500 mt-0.5">Ibu Kota: <strong class="text-slate-700">{{ $provinsi->ibu_kota ?: '-' }}</strong> &bull; Wilayah: <strong class="text-slate-700">{{ $provinsi->pulau ?: '-' }}</strong></p>
                        </div>
                    </div>
                    @endif

                    <!-- Nama Provinsi & Ibu Kota -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="nama" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Provinsi <span class="text-rose-500">*</span></label>
                            <input type="text" id="nama" name="nama" value="{{ old('nama', $provinsi->nama ?? '') }}" required
                                class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors"
                                placeholder="Contoh: Kalimantan Timur">
                        </div>

                        <div>
                            <label for="ibu_kota" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Ibu Kota Provinsi</label>
                            <input type="text" id="ibu_kota" name="ibu_kota" value="{{ old('ibu_kota', $provinsi->ibu_kota ?? '') }}"
                                class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors"
                                placeholder="Contoh: Samarinda">
                        </div>
                    </div>

                    <!-- Nama Gubernur & Wilayah Pulau -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="gubernur" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Gubernur saat Ini (Opsional)</label>
                            <input type="text" id="gubernur" name="gubernur" value="{{ old('gubernur', $provinsi->gubernur ?? '') }}"
                                class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors"
                                placeholder="Contoh: Dr. H. Rudy Mas'ud, SE., ME. (kosongkan jika transisi)">
                        </div>

                        <div>
                            <label for="pulau" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Wilayah Pulau</label>
                            <input type="text" id="pulau" name="pulau" value="{{ old('pulau', $provinsi->pulau ?? '') }}" list="list_pulau"
                                class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors"
                                placeholder="Pilih atau ketik pulau (contoh: Kalimantan)...">
                            <datalist id="list_pulau">
                                <option value="Sumatera">
                                <option value="Jawa">
                                <option value="Kalimantan">
                                <option value="Sulawesi">
                                <option value="Bali & Nusa Tenggara">
                                <option value="Maluku & Papua">
                            </datalist>
                        </div>
                    </div>

                    <!-- Website Resmi & Urutan -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="website" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Alamat Website Resmi Daerah</label>
                            <input type="url" id="website" name="website" value="{{ old('website', $provinsi->website ?? '') }}"
                                class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors"
                                placeholder="https://kaltimprov.go.id">
                        </div>

                        <div>
                            <label for="urutan" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nomor Urut Tampil</label>
                            <input type="number" id="urutan" name="urutan" value="{{ old('urutan', $provinsi->urutan ?? '') }}" placeholder="1" min="1"
                                class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Lambang Daerah & Aksi (4 Kolom) --}}
            <div class="lg:col-span-4 space-y-6">
                <!-- Card Lambang Daerah -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-4">
                    <h3 class="font-bold text-slate-800 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
                        <span class="material-symbols-outlined text-amber-500">shield</span>
                        <span>Lambang Daerah</span>
                    </h3>

                    @if($provinsi)
                    <div class="flex justify-center py-2">
                        <div class="w-24 h-28 flex items-center justify-center p-2 bg-slate-50 rounded-2xl border border-slate-200 shadow-2xs">
                            <img src="{{ $provinsi->lambang_url }}" alt="{{ $provinsi->nama }}" class="max-w-full max-h-full object-contain">
                        </div>
                    </div>
                    @endif

                    <div>
                        <label for="lambang" class="block text-xs font-semibold text-slate-600 mb-1.5">Unggah Lambang Daerah (PNG / SVG / JPG)</label>
                        <input type="file" id="lambang" name="lambang" accept="image/*"
                            class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 py-1 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-navy-900 file:text-white hover:file:bg-navy-800 transition-colors">
                    </div>
                </div>

                <!-- Form Submit Bar -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center gap-3">
                    <a href="{{ route('admin.provinsi.index') }}" class="flex-1 text-center py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs rounded-xl transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="flex-1 py-2.5 bg-amber-500 hover:bg-amber-600 text-navy-950 font-bold text-xs rounded-xl shadow-md transition-all inline-flex items-center justify-center gap-1.5">
                        <span class="material-symbols-outlined text-sm">save</span>
                        <span>{{ $provinsi ? 'Simpan' : 'Tambah' }}</span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
