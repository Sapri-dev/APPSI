@extends('layouts.admin')

@section('title', 'Kelola Berita & Artikel')
@section('subtitle', 'Daftar semua berita dan siaran pers APPSI')

@section('content')
<div class="space-y-5">

    <!-- Header Action Bar -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h3 class="text-lg font-bold text-slate-800">Manajemen Berita</h3>
            <p class="text-xs text-slate-500">Total {{ $berita->total() }} artikel tersimpan dalam database</p>
        </div>
        <a href="{{ route('admin.berita.create') }}" class="px-4 py-2.5 bg-amber-500 hover:bg-amber-600 text-navy-950 font-bold text-xs rounded-xl shadow-xs transition-all inline-flex items-center gap-2">
            <span class="material-symbols-outlined text-sm">add</span>
            <span>Tulis Berita Baru</span>
        </a>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 uppercase font-semibold border-b border-slate-200">
                    <tr>
                        <th class="px-5 py-3.5 w-12">#</th>
                        <th class="px-5 py-3.5">Gambar</th>
                        <th class="px-5 py-3.5">Judul</th>
                        <th class="px-5 py-3.5">Kategori</th>
                        <th class="px-5 py-3.5">Tanggal</th>
                        <th class="px-5 py-3.5">Status</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($berita as $index => $b)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-5 py-4 text-slate-400 font-medium">
                                {{ $berita->firstItem() + $index }}
                            </td>
                            <td class="px-5 py-4">
                                <img src="{{ $b->gambar_url }}" alt="{{ $b->judul }}" class="w-12 h-10 object-cover rounded-lg border border-slate-200 bg-slate-100">
                            </td>
                            <td class="px-5 py-4">
                                <div class="font-bold text-slate-900 line-clamp-1">{{ $b->judul }}</div>
                                <div class="text-[11px] text-slate-400 mt-0.5 line-clamp-1">{{ $b->ringkasan ?: Str::limit(strip_tags($b->konten), 80) }}</div>
                            </td>
                            <td class="px-5 py-4">
                                <span class="inline-block px-2.5 py-1 rounded-md text-[10px] font-semibold bg-slate-100 text-slate-700 uppercase">
                                    {{ $b->kategori }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-slate-600 whitespace-nowrap">
                                {{ $b->tanggal_publikasi ? $b->tanggal_publikasi->format('d M Y') : '-' }}
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap">
                                <form action="{{ route('admin.berita.toggle', $b->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-2.5 py-1 rounded-full text-[10px] font-bold transition-all cursor-pointer {{ $b->is_published ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                                        {{ $b->is_published ? 'Dipublikasi' : 'Draft' }}
                                    </button>
                                </form>
                            </td>
                            <td class="px-5 py-4 text-right space-x-1 whitespace-nowrap">
                                <a href="{{ route('artikel', $b->slug) }}" target="_blank" title="Lihat di Frontend" class="p-1.5 text-slate-400 hover:text-slate-600 inline-block">
                                    <span class="material-symbols-outlined text-base">visibility</span>
                                </a>
                                <a href="{{ route('admin.berita.edit', $b->id) }}" title="Edit Berita" class="p-1.5 text-indigo-600 hover:text-indigo-800 font-semibold inline-block">
                                    <span class="material-symbols-outlined text-base">edit</span>
                                </a>
                                <form action="{{ route('admin.berita.destroy', $b->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Hapus Berita" class="p-1.5 text-rose-500 hover:text-rose-700 font-semibold cursor-pointer">
                                        <span class="material-symbols-outlined text-base">delete</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-12 text-center text-slate-400">
                                <span class="material-symbols-outlined text-4xl mb-2 block text-slate-300">newspaper</span>
                                Belum ada berita tersimpan. <a href="{{ route('admin.berita.create') }}" class="text-amber-600 font-bold hover:underline">Tambah berita pertama</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($berita->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $berita->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
