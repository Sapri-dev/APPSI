@extends('layouts.admin')

@section('title', 'Kelola Pustaka & Dokumen')
@section('subtitle', 'Daftar dokumen resmi (UU, AD/ART, SK, Rekomendasi, Data BPS)')

@section('content')
<div class="space-y-5">

    <!-- Header Action Bar -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h3 class="text-lg font-bold text-slate-800">Perpustakaan & Regulasi</h3>
            <p class="text-xs text-slate-500">Total {{ $pustaka->total() }} berkas dokumen tersimpan</p>
        </div>
        <a href="{{ route('admin.pustaka.create') }}" class="px-4 py-2.5 bg-amber-500 hover:bg-amber-600 text-navy-950 font-bold text-xs rounded-xl shadow-xs transition-all inline-flex items-center gap-2">
            <span class="material-symbols-outlined text-sm">upload_file</span>
            <span>Upload Dokumen Baru</span>
        </a>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 uppercase font-semibold border-b border-slate-200">
                    <tr>
                        <th class="px-5 py-3.5 w-12">#</th>
                        <th class="px-5 py-3.5">Judul Dokumen</th>
                        <th class="px-5 py-3.5">Kategori</th>
                        <th class="px-5 py-3.5">Tahun</th>
                        <th class="px-5 py-3.5">Unduhan</th>
                        <th class="px-5 py-3.5">Status</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pustaka as $index => $doc)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-5 py-3.5 text-slate-400 font-medium">
                                {{ $pustaka->firstItem() + $index }}
                            </td>
                            <td class="px-5 py-3.5">
                                <div class="font-bold text-slate-900">{{ $doc->judul }}</div>
                                @if($doc->deskripsi)
                                    <div class="text-[11px] text-slate-400 mt-0.5 line-clamp-1">{{ $doc->deskripsi }}</div>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 whitespace-nowrap">
                                <span class="px-2.5 py-1 rounded-md text-[10px] font-bold bg-slate-100 text-slate-700">
                                    {{ $doc->label_kategori }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-slate-600 font-mono">
                                {{ $doc->tahun ?: '-' }}
                            </td>
                            <td class="px-5 py-3.5 text-slate-600 font-mono">
                                {{ number_format($doc->unduhan) }}x
                            </td>
                            <td class="px-5 py-3.5 whitespace-nowrap">
                                @if($doc->is_published)
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">Aktif</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600">Draft</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-right space-x-1 whitespace-nowrap">
                                @if($doc->file_download_url)
                                    <a href="{{ $doc->file_download_url }}" target="_blank" title="Unduh Berkas" class="p-1.5 text-emerald-600 hover:text-emerald-800 font-semibold inline-block">
                                        <span class="material-symbols-outlined text-base">download</span>
                                    </a>
                                @endif
                                <a href="{{ route('admin.pustaka.edit', $doc->id) }}" title="Edit Dokumen" class="p-1.5 text-indigo-600 hover:text-indigo-800 font-semibold inline-block">
                                    <span class="material-symbols-outlined text-base">edit</span>
                                </a>
                                <form action="{{ route('admin.pustaka.destroy', $doc->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumen ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Hapus Dokumen" class="p-1.5 text-rose-500 hover:text-rose-700 font-semibold cursor-pointer">
                                        <span class="material-symbols-outlined text-base">delete</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-12 text-center text-slate-400">
                                <span class="material-symbols-outlined text-4xl mb-2 block text-slate-300">folder_off</span>
                                Belum ada dokumen pustaka tersimpan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pustaka->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $pustaka->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
