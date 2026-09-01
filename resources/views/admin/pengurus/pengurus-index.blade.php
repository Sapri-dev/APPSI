@extends('layouts.admin')

@section('title', 'Kelola Pengurus & Organisasi')
@section('subtitle', 'Manajemen data struktur kepengurusan dan dewan APPSI')

@section('content')
<div class="space-y-5">

    <!-- Header Section Formal -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
        <div>
            <h2 class="text-lg font-bold text-slate-900">Struktur Kepengurusan & Organisasi</h2>
            <p class="text-xs text-slate-500 mt-0.5">Total {{ $counts['semua'] }} anggota terdaftar dalam seluruh dewan</p>
        </div>
        <a href="{{ route('admin.pengurus.create') }}" class="px-4 py-2.5 bg-navy-900 hover:bg-navy-800 text-white font-semibold text-xs rounded-xl shadow-xs transition-all inline-flex items-center gap-2 shrink-0">
            <span class="material-symbols-outlined text-sm text-amber-400">add</span>
            <span>Tambah Anggota Baru</span>
        </a>
    </div>

    <!-- Main Container: Tabs, Search & Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
        
        <!-- Segmented Tabs Navigation -->
        <div class="border-b border-slate-200 bg-slate-50/50 px-4 pt-3 flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-1 overflow-x-auto hide-scrollbar">
                @php
                    $tabs = [
                        'pengurus'    => ['label' => 'Dewan Pengurus', 'count' => $counts['pengurus']],
                        'penasehat'   => ['label' => 'Dewan Penasehat', 'count' => $counts['penasehat']],
                        'pakar'       => ['label' => 'Dewan Pakar', 'count' => $counts['pakar']],
                        'sekretariat' => ['label' => 'Sekretariat', 'count' => $counts['sekretariat']],
                        ''            => ['label' => 'Semua', 'count' => $counts['semua']],
                    ];
                @endphp

                @foreach($tabs as $key => $tab)
                    @php
                        $isActive = ($jenisAktif === $key) || (empty($jenisAktif) && $key === '');
                    @endphp
                    <a href="{{ route('admin.pengurus.index', array_merge(request('cari') ? ['cari' => request('cari')] : [], $key ? ['jenis' => $key] : [])) }}"
                       class="px-3.5 py-2.5 text-xs font-semibold rounded-t-xl transition-all border-b-2 inline-flex items-center gap-2 {{ $isActive ? 'border-navy-900 text-navy-900 bg-white shadow-2xs' : 'border-transparent text-slate-500 hover:text-slate-800 hover:bg-slate-100/60' }}">
                        <span>{{ $tab['label'] }}</span>
                        <span class="px-1.5 py-0.5 rounded text-[11px] font-mono {{ $isActive ? 'bg-navy-900 text-white' : 'bg-slate-200/70 text-slate-600' }}">
                            {{ $tab['count'] }}
                        </span>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Filter & Search Toolbar -->
        <div class="p-4 border-b border-slate-100 bg-white">
            <form action="{{ route('admin.pengurus.index') }}" method="GET" class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
                @if($jenisAktif)
                    <input type="hidden" name="jenis" value="{{ $jenisAktif }}">
                @endif

                <div class="relative flex-1">
                    <span class="material-symbols-outlined absolute left-3 top-2 text-slate-400 text-sm">search</span>
                    <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari berdasarkan nama, jabatan, atau provinsi..."
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-9 pr-4 py-2 text-xs font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors">
                </div>

                <div class="flex items-center gap-2 shrink-0">
                    <button type="submit" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-800 font-semibold text-xs rounded-xl transition-colors">
                        Cari
                    </button>
                    @if(request('cari') || $jenisAktif)
                        <a href="{{ route('admin.pengurus.index') }}" class="px-3 py-2 text-rose-600 hover:bg-rose-50 font-semibold text-xs rounded-xl transition-colors inline-flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">restart_alt</span>
                            <span>Reset</span>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Data Table Grid Formal -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-600 uppercase text-[11px] font-bold tracking-wider border-b border-slate-200">
                        <th class="px-4 py-3 w-14 text-center">Urutan</th>
                        <th class="px-4 py-3 w-16">Foto</th>
                        <th class="px-5 py-3">Nama Lengkap & Gelar</th>
                        <th class="px-5 py-3">Jabatan di Organisasi</th>
                        <th class="px-4 py-3">Kelompok / Dewan</th>
                        <th class="px-4 py-3">Asal Provinsi</th>
                        <th class="px-4 py-3 text-center">Status</th>
                        <th class="px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($pengurus as $index => $p)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <!-- Urutan -->
                            <td class="px-4 py-3.5 text-center font-mono font-bold text-slate-500 bg-slate-50/30">
                                #{{ $p->urutan }}
                            </td>

                            <!-- Foto -->
                            <td class="px-4 py-3.5">
                                <img src="{{ $p->foto_url }}" alt="{{ $p->nama }}"
                                     class="w-10 h-10 object-cover object-top rounded-lg border border-slate-200 bg-slate-100 shadow-2xs">
                            </td>

                            <!-- Nama -->
                            <td class="px-5 py-3.5">
                                <div class="font-bold text-slate-900 text-xs">{{ $p->nama }}</div>
                            </td>

                            <!-- Jabatan -->
                            <td class="px-5 py-3.5">
                                <div class="font-semibold text-slate-800 text-xs">{{ $p->jabatan }}</div>
                            </td>

                            <!-- Kelompok Dewan -->
                            <td class="px-4 py-3.5">
                                <span class="px-2 py-0.5 rounded text-[10px] font-semibold border
                                    @if($p->jenis == 'pengurus') bg-slate-100 border-slate-300 text-slate-800
                                    @elseif($p->jenis == 'penasehat') bg-purple-50 border-purple-200 text-purple-800
                                    @elseif($p->jenis == 'pakar') bg-sky-50 border-sky-200 text-sky-800
                                    @else bg-emerald-50 border-emerald-200 text-emerald-800 @endif">
                                    {{ $p->label_jenis }}
                                </span>
                            </td>

                            <!-- Asal Provinsi -->
                            <td class="px-4 py-3.5 font-medium text-slate-600">
                                {{ $p->provinsi ?: '—' }}
                            </td>

                            <!-- Status Aktif -->
                            <td class="px-4 py-3.5 text-center whitespace-nowrap">
                                <form action="{{ route('admin.pengurus.toggle', $p->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" title="Klik untuk ubah status"
                                        class="px-2 py-0.5 rounded text-[10px] font-bold transition-all cursor-pointer inline-flex items-center gap-1.5 {{ $p->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100' : 'bg-slate-100 text-slate-500 border border-slate-200 hover:bg-slate-200' }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $p->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                        <span>{{ $p->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                                    </button>
                                </form>
                            </td>

                            <!-- Aksi -->
                            <td class="px-5 py-3.5 text-right space-x-1 whitespace-nowrap">
                                @php
                                    $frontendRoute = match($p->jenis) {
                                        'pengurus'   => route('dewan-pengurus'),
                                        'penasehat'  => route('dewan-penasehat'),
                                        'pakar'      => route('dewan-pakar'),
                                        'sekretariat'=> route('sekretariat'),
                                        default      => route('dewan-pengurus'),
                                    };
                                @endphp
                                <a href="{{ $frontendRoute }}" target="_blank" title="Lihat di Portal Publik" class="p-1.5 text-slate-400 hover:text-slate-700 inline-block rounded-lg hover:bg-slate-100 transition-colors">
                                    <span class="material-symbols-outlined text-base">visibility</span>
                                </a>
                                <a href="{{ route('admin.pengurus.edit', $p->id) }}" title="Edit Data" class="p-1.5 text-slate-600 hover:text-navy-900 inline-block rounded-lg hover:bg-slate-100 transition-colors">
                                    <span class="material-symbols-outlined text-base">edit</span>
                                </a>
                                <form action="{{ route('admin.pengurus.destroy', $p->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pengurus ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Hapus Data" class="p-1.5 text-rose-500 hover:text-rose-700 inline-block rounded-lg hover:bg-rose-50 transition-colors cursor-pointer">
                                        <span class="material-symbols-outlined text-base">delete</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-5 py-12 text-center text-slate-400">
                                <span class="material-symbols-outlined text-4xl mb-1 text-slate-300 block">person_search</span>
                                Tidak ada data pengurus ditemukan dalam filter ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pengurus->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $pengurus->links() }}
            </div>
        @endif

    </div>

</div>
@endsection
