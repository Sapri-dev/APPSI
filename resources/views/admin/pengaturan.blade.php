@extends('layouts.admin')

@section('title', 'Pengaturan Website')
@section('subtitle', 'Kelola informasi umum, kontak, visi misi, dan identitas APPSI')

@section('content')
<div class="w-full">

    <form action="{{ route('admin.pengaturan.update') }}" method="POST" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            {{-- Kolom Kiri: Identitas Organisasi & Visi Misi (7 Kolom) --}}
            <div class="lg:col-span-7 space-y-6">
                <!-- Card Identitas -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-5">
                    <h3 class="font-bold text-slate-800 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
                        <span class="material-symbols-outlined text-amber-500">info</span>
                        <span>Identitas Organisasi</span>
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="nama_organisasi" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Resmi Organisasi</label>
                            <input type="text" id="nama_organisasi" name="nama_organisasi" value="{{ old('nama_organisasi', $pengaturan['nama_organisasi'] ?? '') }}"
                                class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors">
                        </div>

                        <div>
                            <label for="singkatan" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Singkatan / Akronim</label>
                            <input type="text" id="singkatan" name="singkatan" value="{{ old('singkatan', $pengaturan['singkatan'] ?? '') }}"
                                class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors">
                        </div>
                    </div>

                    <div>
                        <label for="deskripsi" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Deskripsi Singkat Portal</label>
                        <textarea id="deskripsi" name="deskripsi" rows="3"
                            class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors">{{ old('deskripsi', $pengaturan['deskripsi'] ?? '') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label for="ketua_umum" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Ketua Umum</label>
                            <input type="text" id="ketua_umum" name="ketua_umum" value="{{ old('ketua_umum', $pengaturan['ketua_umum'] ?? '') }}"
                                class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors">
                        </div>

                        <div>
                            <label for="ketua_umum_provinsi" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Jabatan Daerah</label>
                            <input type="text" id="ketua_umum_provinsi" name="ketua_umum_provinsi" value="{{ old('ketua_umum_provinsi', $pengaturan['ketua_umum_provinsi'] ?? '') }}"
                                class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors">
                        </div>

                        <div>
                            <label for="periode" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Periode Masa Bakti</label>
                            <input type="text" id="periode" name="periode" value="{{ old('periode', $pengaturan['periode'] ?? '') }}"
                                class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors">
                        </div>
                    </div>
                </div>

                <!-- Card Visi Misi -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-5">
                    <h3 class="font-bold text-slate-800 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
                        <span class="material-symbols-outlined text-amber-500">flag</span>
                        <span>Visi & Misi</span>
                    </h3>

                    <div>
                        <label for="visi" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Visi Utama APPSI</label>
                        <textarea id="visi" name="visi" rows="2"
                            class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors">{{ old('visi', $pengaturan['visi'] ?? '') }}</textarea>
                    </div>

                    <div>
                        <label for="misi" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Misi Utama (Satu Misi per Baris)</label>
                        <textarea id="misi" name="misi" rows="4"
                            class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors">{{ old('misi', $pengaturan['misi'] ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Kontak & Sekretariat, Media Sosial, Tombol Simpan (5 Kolom) --}}
            <div class="lg:col-span-5 space-y-6">
                <!-- Card Kontak & Alamat -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-5">
                    <h3 class="font-bold text-slate-800 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
                        <span class="material-symbols-outlined text-amber-500">contact_support</span>
                        <span>Kontak & Sekretariat</span>
                    </h3>

                    <div class="space-y-4">
                        <div>
                            <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Email Resmi</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $pengaturan['email'] ?? '') }}"
                                class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="telepon" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nomor Telepon</label>
                                <input type="text" id="telepon" name="telepon" value="{{ old('telepon', $pengaturan['telepon'] ?? '') }}"
                                    class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors">
                            </div>

                            <div>
                                <label for="fax" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nomor Fax</label>
                                <input type="text" id="fax" name="fax" value="{{ old('fax', $pengaturan['fax'] ?? '') }}"
                                    class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors">
                            </div>
                        </div>

                        <div>
                            <label for="alamat" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Alamat Sekretariat Lengkap</label>
                            <textarea id="alamat" name="alamat" rows="3"
                                class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors">{{ old('alamat', $pengaturan['alamat'] ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Card Social Media -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-5">
                    <h3 class="font-bold text-slate-800 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
                        <span class="material-symbols-outlined text-amber-500">share</span>
                        <span>Media Sosial Resmi</span>
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="facebook" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Facebook</label>
                            <input type="url" id="facebook" name="facebook" value="{{ old('facebook', $pengaturan['facebook'] ?? '') }}"
                                class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors" placeholder="https://facebook.com/...">
                        </div>

                        <div>
                            <label for="instagram" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Instagram</label>
                            <input type="url" id="instagram" name="instagram" value="{{ old('instagram', $pengaturan['instagram'] ?? '') }}"
                                class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors" placeholder="https://instagram.com/...">
                        </div>

                        <div>
                            <label for="youtube" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">YouTube</label>
                            <input type="url" id="youtube" name="youtube" value="{{ old('youtube', $pengaturan['youtube'] ?? '') }}"
                                class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors" placeholder="https://youtube.com/...">
                        </div>

                        <div>
                            <label for="twitter" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">X (Twitter)</label>
                            <input type="url" id="twitter" name="twitter" value="{{ old('twitter', $pengaturan['twitter'] ?? '') }}"
                                class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors" placeholder="https://x.com/...">
                        </div>

                        <div class="sm:col-span-2 pt-2 border-t border-slate-100">
                            <label for="instagram_widget_code" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Kode Widget Feed Instagram (SnapWidget / Elfsight / Iframe)
                            </label>
                            <textarea id="instagram_widget_code" name="instagram_widget_code" rows="2"
                                class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2 text-xs font-mono text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors"
                                placeholder="Contoh: <iframe src='https://snapwidget.com/embed/...' ...></iframe> atau kosongkan untuk menggunakan dokumentasi otomatis">{{ old('instagram_widget_code', $pengaturan['instagram_widget_code'] ?? '') }}</textarea>
                            <p class="text-[11px] text-slate-500 mt-1">
                                Opsional. Masukkan kode embed iframe dari SnapWidget / Elfsight jika ingin menampilkan live widget. Jika dikosongkan, website otomatis menampilkan feed dokumentasi kegiatan resmi APPSI.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Form Submit Bar -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between gap-4">
                    <p class="text-xs text-slate-500">Pastikan data sudah sesuai.</p>
                    <button type="submit" class="px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-navy-950 font-bold text-xs rounded-xl shadow-md transition-all inline-flex items-center gap-2 shrink-0">
                        <span class="material-symbols-outlined text-sm">save</span>
                        <span>Simpan Pengaturan</span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
