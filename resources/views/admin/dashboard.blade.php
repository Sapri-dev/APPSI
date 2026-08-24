@extends('layouts.admin')

@section('title', 'Dashboard Overview')
@section('subtitle', 'Ringkasan data dan aktivitas portal APPSI')

@section('content')
<div class="space-y-6">

    <!-- Stat Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <!-- Berita & Artikel Stat -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Berita</p>
                <h3 class="text-3xl font-extrabold text-slate-800 mt-1">{{ $stats['berita'] }}</h3>
                <a href="{{ route('admin.berita.index') }}" class="text-xs font-medium text-amber-600 hover:text-amber-700 inline-flex items-center gap-1 mt-2">
                    Kelola berita &rarr;
                </a>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-2xl">newspaper</span>
            </div>
        </div>

        <!-- Pengurus & Organisasi Stat -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Pengurus</p>
                <h3 class="text-3xl font-extrabold text-slate-800 mt-1">{{ $stats['pengurus'] }}</h3>
                <a href="{{ route('admin.pengurus.index') }}" class="text-xs font-medium text-indigo-600 hover:text-indigo-700 inline-flex items-center gap-1 mt-2">
                    Kelola pengurus &rarr;
                </a>
            </div>
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-2xl">groups</span>
            </div>
        </div>

        <!-- Dokumen Pustaka Stat -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Dokumen Pustaka</p>
                <h3 class="text-3xl font-extrabold text-slate-800 mt-1">{{ $stats['pustaka'] }}</h3>
                <a href="{{ route('admin.pustaka.index') }}" class="text-xs font-medium text-emerald-600 hover:text-emerald-700 inline-flex items-center gap-1 mt-2">
                    Kelola pustaka &rarr;
                </a>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-2xl">folder_shared</span>
            </div>
        </div>

        <!-- Provinsi Stat -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Provinsi Anggota</p>
                <h3 class="text-3xl font-extrabold text-slate-800 mt-1">{{ $stats['provinsi'] }}</h3>
                <a href="{{ route('admin.provinsi.index') }}" class="text-xs font-medium text-sky-600 hover:text-sky-700 inline-flex items-center gap-1 mt-2">
                    Daftar provinsi &rarr;
                </a>
            </div>
            <div class="w-12 h-12 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-2xl">map</span>
            </div>
        </div>

    </div>

    <!-- Quick Action Banner -->
    <div class="bg-gradient-to-r from-navy-900 via-navy-800 to-navy-950 p-6 rounded-2xl shadow-md text-white flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <h3 class="text-lg font-bold">Akses Cepat Pengelolaan</h3>
            <p class="text-xs text-slate-300 mt-1">Tambah berita baru, perbarui susunan pengurus, atau ganti data website.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.berita.create') }}" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-navy-950 font-bold text-xs rounded-xl shadow-xs transition-colors inline-flex items-center gap-1.5">
                <span class="material-symbols-outlined text-sm">add</span>
                <span>Tulis Berita</span>
            </a>
            <a href="{{ route('admin.pengurus.create') }}" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-white font-semibold text-xs rounded-xl border border-slate-700 transition-colors inline-flex items-center gap-1.5">
                <span class="material-symbols-outlined text-sm">person_add</span>
                <span>Tambah Pengurus</span>
            </a>
            <a href="{{ route('admin.pustaka.create') }}" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-white font-semibold text-xs rounded-xl border border-slate-700 transition-colors inline-flex items-center gap-1.5">
                <span class="material-symbols-outlined text-sm">upload_file</span>
                <span>Upload Dokumen</span>
            </a>
        </div>
    </div>

    <!-- Recent News Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <h4 class="font-bold text-slate-800 text-sm">Berita Terakhir Ditambahkan</h4>
            <a href="{{ route('admin.berita.index') }}" class="text-xs font-semibold text-navy-700 hover:text-navy-900">Lihat Semua</a>
        </div>

        @if($beritaTerbaru->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-500 uppercase font-semibold border-b border-slate-100">
                        <tr>
                            <th class="px-5 py-3">Judul Berita</th>
                            <th class="px-5 py-3">Kategori</th>
                            <th class="px-5 py-3">Tanggal</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($beritaTerbaru as $b)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="px-5 py-3.5 font-medium text-slate-900 max-w-xs truncate">
                                    {{ $b->judul }}
                                </td>
                                <td class="px-5 py-3.5 text-slate-600 capitalize">
                                    {{ $b->kategori }}
                                </td>
                                <td class="px-5 py-3.5 text-slate-500">
                                    {{ $b->tanggal_publikasi ? $b->tanggal_publikasi->format('d M Y') : '-' }}
                                </td>
                                <td class="px-5 py-3.5">
                                    @if($b->is_published)
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">Dipublikasi</span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600">Draft</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 text-right space-x-2">
                                    <a href="{{ route('admin.berita.edit', $b->id) }}" class="text-slate-600 hover:text-indigo-600 font-semibold">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-8 text-center text-slate-500 text-xs">
                Belum ada berita yang diterbitkan.
            </div>
        @endif
    </div>

</div>
@endsection
