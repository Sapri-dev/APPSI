@extends('layouts.admin')

@section('title', 'Kelola Provinsi Anggota')
@section('subtitle', 'Daftar provinsi anggota APPSI beserta nama Gubernur dan lambang daerah')

@section('content')
<div class="space-y-5">

    {{-- Header Action Bar --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h3 class="text-lg font-bold text-slate-800">Daftar Provinsi Anggota APPSI</h3>
            <p class="text-xs text-slate-500">Kelola informasi nama Gubernur, ibu kota, dan lambang daerah</p>
        </div>

        <a href="{{ route('admin.provinsi.create') }}" class="px-4 py-2.5 bg-amber-500 hover:bg-amber-600 text-navy-950 font-bold text-xs rounded-xl shadow-xs transition-all inline-flex items-center gap-2 shrink-0">
            <span class="material-symbols-outlined text-sm">add_location_alt</span>
            <span>+ Tambah Provinsi Baru</span>
        </a>
    </div>

    {{-- Filter, Search & Kontrol Per-Page Toolbar --}}
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs">
        <form method="GET" action="{{ route('admin.provinsi.index') }}" class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3">
            <!-- Search Bar -->
            <div class="relative flex-1">
                <span class="material-symbols-outlined absolute left-3 top-2.5 text-slate-400 text-sm">search</span>
                <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari nama provinsi, gubernur, atau ibu kota..."
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-9 pr-4 py-2 text-xs font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors">
            </div>

            <div class="flex flex-wrap items-center gap-2 shrink-0">
                <!-- Filter Pulau -->
                <select name="pulau" onchange="this.form.submit()"
                    class="text-xs border border-slate-200 rounded-xl px-3 py-2 bg-slate-50 text-slate-700 font-medium focus:outline-none focus:bg-white cursor-pointer">
                    <option value="semua">Semua Pulau</option>
                    @foreach(['Sumatera', 'Jawa', 'Kalimantan', 'Sulawesi', 'Bali & Nusa Tenggara', 'Maluku & Papua'] as $p)
                        <option value="{{ $p }}" {{ request('pulau') == $p ? 'selected' : '' }}>{{ $p }}</option>
                    @endforeach
                </select>

                <!-- Dropdown Per Page -->
                <select name="perPage" onchange="this.form.submit()"
                    class="text-xs border border-slate-200 rounded-xl px-3 py-2 bg-slate-50 text-slate-700 font-medium focus:outline-none focus:bg-white cursor-pointer">
                    <option value="10"  {{ ($perPage == 10   || $perPage == '10')  ? 'selected' : '' }}>10 data</option>
                    <option value="25"  {{ ($perPage == 25   || $perPage == '25')  ? 'selected' : '' }}>25 data</option>
                    <option value="38"  {{ ($perPage == 38   || $perPage == '38')  ? 'selected' : '' }}>38 data</option>
                    <option value="all" {{ ($perPage === 'all') ? 'selected' : '' }}>Semua data</option>
                </select>

                <button type="submit" class="px-4 py-2 bg-navy-900 hover:bg-navy-800 text-white font-semibold text-xs rounded-xl transition-colors">
                    Filter
                </button>

                @if(request('cari') || (request('pulau') && request('pulau') !== 'semua'))
                    <a href="{{ route('admin.provinsi.index') }}" class="px-3 py-2 text-rose-600 hover:bg-rose-50 font-semibold text-xs rounded-xl transition-colors inline-flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">restart_alt</span>
                        <span>Reset</span>
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Info jumlah data --}}
    <div class="text-xs text-slate-400">
        @if($isPaginated)
            Menampilkan <span class="font-semibold text-slate-600">{{ $provinsi->firstItem() }}–{{ $provinsi->lastItem() }}</span>
            dari <span class="font-semibold text-slate-600">{{ $provinsi->total() }}</span> provinsi
        @else
            Menampilkan semua <span class="font-semibold text-slate-600">{{ $provinsi->count() }}</span> provinsi
        @endif
    </div>

    {{-- Data Table --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 uppercase font-semibold border-b border-slate-200">
                    <tr>
                        <th class="px-5 py-3.5 w-12">#</th>
                        <th class="px-5 py-3.5">Lambang</th>
                        <th class="px-5 py-3.5">Nama Provinsi</th>
                        <th class="px-5 py-3.5">Ibu Kota</th>
                        <th class="px-5 py-3.5">Gubernur saat Ini</th>
                        <th class="px-5 py-3.5">Wilayah Pulau</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($provinsi as $index => $prov)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-5 py-3.5 text-slate-400 font-mono">
                                #{{ $prov->urutan }}
                            </td>
                            <td class="px-5 py-3.5">
                                <img src="{{ $prov->lambang_url }}" alt="{{ $prov->nama }}" class="w-8 h-10 object-contain shadow-2xs">
                            </td>
                            <td class="px-5 py-3.5 font-bold text-slate-900 text-xs">
                                {{ $prov->nama }}
                            </td>
                            <td class="px-5 py-3.5 text-slate-600">
                                {{ $prov->ibu_kota ?: '-' }}
                            </td>
                            <td class="px-5 py-3.5 text-slate-800 font-medium">
                                {{ $prov->gubernur ?: '— (Masa Transisi / Pj)' }}
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="px-2.5 py-1 rounded-md text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                    {{ $prov->pulau ?: '—' }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-right whitespace-nowrap space-x-1">
                                <a href="{{ route('admin.provinsi.edit', $prov->id) }}" title="Edit Data Provinsi"
                                   class="p-1.5 text-indigo-600 hover:text-indigo-800 font-semibold inline-block">
                                    <span class="material-symbols-outlined text-base">edit</span>
                                </a>
                                <form action="{{ route('admin.provinsi.destroy', $prov->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data provinsi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Hapus Data" class="p-1.5 text-rose-500 hover:text-rose-700 font-semibold cursor-pointer">
                                        <span class="material-symbols-outlined text-base">delete</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-12 text-center text-slate-400">
                                <span class="material-symbols-outlined text-4xl mb-1 text-slate-300 block">location_off</span>
                                Tidak ada data provinsi ditemukan dalam pencarian ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Footer --}}
        @if($isPaginated && $provinsi->hasPages())
            <div class="px-5 py-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3 bg-slate-50/60">
                <p class="text-xs text-slate-500">
                    Halaman <span class="font-semibold text-slate-700">{{ $provinsi->currentPage() }}</span>
                    dari <span class="font-semibold text-slate-700">{{ $provinsi->lastPage() }}</span>
                </p>

                <div class="flex items-center gap-1">
                    @if($provinsi->onFirstPage())
                        <span class="px-3 py-1.5 rounded-lg text-xs font-medium bg-slate-100 text-slate-300 cursor-not-allowed select-none">
                            ← Prev
                        </span>
                    @else
                        <a href="{{ $provinsi->previousPageUrl() }}"
                           class="px-3 py-1.5 rounded-lg text-xs font-medium bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 hover:border-indigo-300 hover:text-indigo-600 transition-all shadow-xs">
                            ← Prev
                        </a>
                    @endif

                    @foreach(range(1, $provinsi->lastPage()) as $page)
                        @if($page == $provinsi->currentPage())
                            <span class="px-3 py-1.5 rounded-lg text-xs font-bold bg-indigo-600 text-white shadow-sm">
                                {{ $page }}
                            </span>
                        @elseif(abs($page - $provinsi->currentPage()) <= 2 || $page == 1 || $page == $provinsi->lastPage())
                            <a href="{{ $provinsi->url($page) }}"
                               class="px-3 py-1.5 rounded-lg text-xs font-medium bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 hover:border-indigo-300 hover:text-indigo-600 transition-all shadow-xs">
                                {{ $page }}
                            </a>
                        @elseif(abs($page - $provinsi->currentPage()) == 3)
                            <span class="px-1.5 text-xs text-slate-400">…</span>
                        @endif
                    @endforeach

                    @if($provinsi->hasMorePages())
                        <a href="{{ $provinsi->nextPageUrl() }}"
                           class="px-3 py-1.5 rounded-lg text-xs font-medium bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 hover:border-indigo-300 hover:text-indigo-600 transition-all shadow-xs">
                            Next →
                        </a>
                    @else
                        <span class="px-3 py-1.5 rounded-lg text-xs font-medium bg-slate-100 text-slate-300 cursor-not-allowed select-none">
                            Next →
                        </span>
                    @endif
                </div>
            </div>
        @endif
    </div>

</div>
@endsection
