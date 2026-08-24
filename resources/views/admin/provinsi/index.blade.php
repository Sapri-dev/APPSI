@extends('layouts.admin')

@section('title', 'Kelola 38 Provinsi')
@section('subtitle', 'Daftar provinsi anggota APPSI beserta gubernur dan lambang daerah')

@section('content')
<div class="space-y-5">

    {{-- Header + Kontrol Per-Page --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h3 class="text-lg font-bold text-slate-800">Daftar 38 Provinsi Anggota</h3>
            <p class="text-xs text-slate-500">Perbarui nama Gubernur dan lambang daerah masing-masing provinsi</p>
        </div>

        {{-- Dropdown Tampilkan Per Halaman --}}
        <form method="GET" action="{{ route('admin.provinsi.index') }}" class="flex items-center gap-2">
            <label for="perPage" class="text-xs font-semibold text-slate-500 whitespace-nowrap">Tampilkan:</label>
            <select id="perPage" name="perPage" onchange="this.form.submit()"
                    class="text-xs border border-slate-200 rounded-lg px-3 py-2 bg-white text-slate-700 font-medium shadow-xs focus:outline-none focus:ring-2 focus:ring-indigo-500 cursor-pointer">
                <option value="10"  {{ ($perPage == 10   || $perPage == '10')  ? 'selected' : '' }}>10 data</option>
                <option value="25"  {{ ($perPage == 25   || $perPage == '25')  ? 'selected' : '' }}>25 data</option>
                <option value="38"  {{ ($perPage == 38   || $perPage == '38')  ? 'selected' : '' }}>38 data</option>
                <option value="all" {{ ($perPage === 'all') ? 'selected' : '' }}>Semua data</option>
            </select>
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
                        <th class="px-5 py-3.5">Provinsi</th>
                        <th class="px-5 py-3.5">Ibu Kota</th>
                        <th class="px-5 py-3.5">Gubernur saat Ini</th>
                        <th class="px-5 py-3.5">Pulau</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($provinsi as $index => $prov)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-5 py-3.5 text-slate-400 font-mono">
                                {{ $prov->urutan }}
                            </td>
                            <td class="px-5 py-3.5">
                                <img src="{{ $prov->lambang_url }}" alt="{{ $prov->nama }}" class="w-8 h-10 object-contain">
                            </td>
                            <td class="px-5 py-3.5 font-bold text-slate-900">
                                {{ $prov->nama }}
                            </td>
                            <td class="px-5 py-3.5 text-slate-600">
                                {{ $prov->ibu_kota ?: '-' }}
                            </td>
                            <td class="px-5 py-3.5 text-slate-800 font-medium">
                                {{ $prov->gubernur ?: '-' }}
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-slate-100 text-slate-600">
                                    {{ $prov->pulau }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-right whitespace-nowrap">
                                <a href="{{ route('admin.provinsi.edit', $prov->id) }}" title="Edit Data Provinsi"
                                   class="text-indigo-600 hover:text-indigo-800 font-semibold">
                                    Edit Gubernur &amp; Lambang
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-12 text-center text-slate-400">
                                Belum ada data provinsi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Footer --}}
        @if($isPaginated && $provinsi->hasPages())
            <div class="px-5 py-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3 bg-slate-50/60">
                {{-- Info halaman --}}
                <p class="text-xs text-slate-500">
                    Halaman <span class="font-semibold text-slate-700">{{ $provinsi->currentPage() }}</span>
                    dari <span class="font-semibold text-slate-700">{{ $provinsi->lastPage() }}</span>
                </p>

                {{-- Tombol navigasi --}}
                <div class="flex items-center gap-1">
                    {{-- Prev --}}
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

                    {{-- Nomor halaman --}}
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

                    {{-- Next --}}
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
