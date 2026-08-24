@extends('layouts.admin')

@section('title', 'Kelola Pengurus & Organisasi')
@section('subtitle', 'Daftar susunan Dewan Pengurus, Penasehat, Pakar, dan Sekretariat')

@section('content')
<div class="space-y-5">

    <!-- Header Action Bar -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h3 class="text-lg font-bold text-slate-800">Susunan Pengurus & Dewan</h3>
            <p class="text-xs text-slate-500">Kelola jajaran pengurus APPSI untuk periode 2025-2029</p>
        </div>
        <a href="{{ route('admin.pengurus.create') }}" class="px-4 py-2.5 bg-amber-500 hover:bg-amber-600 text-navy-950 font-bold text-xs rounded-xl shadow-xs transition-all inline-flex items-center gap-2">
            <span class="material-symbols-outlined text-sm">person_add</span>
            <span>Tambah Pengurus Baru</span>
        </a>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 uppercase font-semibold border-b border-slate-200">
                    <tr>
                        <th class="px-5 py-3.5 w-12">#</th>
                        <th class="px-5 py-3.5">Foto</th>
                        <th class="px-5 py-3.5">Nama & Jabatan</th>
                        <th class="px-5 py-3.5">Kategori / Dewan</th>
                        <th class="px-5 py-3.5">Provinsi</th>
                        <th class="px-5 py-3.5">Urutan</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pengurus as $index => $p)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-5 py-3.5 text-slate-400 font-medium">
                                {{ $pengurus->firstItem() + $index }}
                            </td>
                            <td class="px-5 py-3.5">
                                <img src="{{ $p->foto_url }}" alt="{{ $p->nama }}" class="w-10 h-10 object-cover rounded-full border border-slate-200 bg-slate-100">
                            </td>
                            <td class="px-5 py-3.5">
                                <div class="font-bold text-slate-900">{{ $p->nama }}</div>
                                <div class="text-[11px] text-amber-600 font-semibold mt-0.5">{{ $p->jabatan }}</div>
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase
                                    @if($p->jenis == 'pengurus') bg-indigo-100 text-indigo-800
                                    @elseif($p->jenis == 'penasehat') bg-purple-100 text-purple-800
                                    @elseif($p->jenis == 'pakar') bg-sky-100 text-sky-800
                                    @else bg-emerald-100 text-emerald-800 @endif">
                                    {{ $p->label_jenis }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-slate-600">
                                {{ $p->provinsi ?: '-' }}
                            </td>
                            <td class="px-5 py-3.5 text-slate-500 font-mono">
                                {{ $p->urutan }}
                            </td>
                            <td class="px-5 py-3.5 text-right space-x-1 whitespace-nowrap">
                                <a href="{{ route('admin.pengurus.edit', $p->id) }}" title="Edit Pengurus" class="p-1.5 text-indigo-600 hover:text-indigo-800 font-semibold inline-block">
                                    <span class="material-symbols-outlined text-base">edit</span>
                                </a>
                                <form action="{{ route('admin.pengurus.destroy', $p->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengurus ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Hapus Pengurus" class="p-1.5 text-rose-500 hover:text-rose-700 font-semibold cursor-pointer">
                                        <span class="material-symbols-outlined text-base">delete</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-12 text-center text-slate-400">
                                <span class="material-symbols-outlined text-4xl mb-2 block text-slate-300">groups</span>
                                Belum ada pengurus tersimpan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pengurus->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $pengurus->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
