@extends('layouts.admin')

@section('title', 'Kelola Pustaka & Dokumen')
@section('subtitle', 'Daftar dokumen resmi, AD/ART, SK, UU, dan regulasi APPSI')

@section('content')
<div x-data="kelolaKategoriPustakaApp()" class="space-y-5">

    <!-- Header Action Bar -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h3 class="text-lg font-bold text-slate-800">Perpustakaan & Regulasi</h3>
            <p class="text-xs text-slate-500">Total {{ $pustaka->total() }} berkas dokumen tersimpan</p>
        </div>
        <div class="flex items-center gap-2.5">
            <button type="button" @click="openModalModal()"
                class="px-3.5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition-all inline-flex items-center gap-2 cursor-pointer border border-slate-200 shadow-2xs">
                <span class="material-symbols-outlined text-sm text-slate-600">category</span>
                <span>Kelola Kategori</span>
            </button>

            <a href="{{ route('admin.pustaka.create') }}" class="px-4 py-2.5 bg-amber-500 hover:bg-amber-600 text-navy-950 font-bold text-xs rounded-xl shadow-xs transition-all inline-flex items-center gap-2 shrink-0">
                <span class="material-symbols-outlined text-sm">upload_file</span>
                <span>Upload Dokumen Baru</span>
            </a>
        </div>
    </div>

    <!-- Category Tabs & Search Bar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs space-y-3">
        <!-- Filter Tabs -->
        <div class="flex items-center gap-2 overflow-x-auto pb-1 border-b border-slate-100 hide-scrollbar">
            <a href="{{ route('admin.pustaka.index', request('cari') ? ['cari' => request('cari')] : []) }}"
                class="whitespace-nowrap px-3.5 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 {{ empty($kategoriAktif) || $kategoriAktif === 'semua' ? 'bg-navy-900 text-white shadow-2xs' : 'text-slate-600 hover:bg-slate-100' }}">
                <span>Semua Dokumen</span>
            </a>

            <template x-for="kat in categories" :key="kat">
                <a :href="'{{ route('admin.pustaka.index') }}?kategori=' + encodeURIComponent(kat) + '{{ request('cari') ? '&cari=' . urlencode(request('cari')) : '' }}'"
                    class="whitespace-nowrap px-3.5 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5"
                    :class="activeCategory === kat ? 'bg-navy-900 text-white shadow-2xs' : 'text-slate-600 hover:bg-slate-100'">
                    <span x-text="formatLabel(kat)"></span>
                    <span class="px-1.5 py-0.5 rounded text-[10px] font-mono"
                          :class="activeCategory === kat ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-700'"
                          x-text="stats[kat] || 0"></span>
                </a>
            </template>
        </div>

        <!-- Search Bar -->
        <form action="{{ route('admin.pustaka.index') }}" method="GET" class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 pt-1">
            @if(!empty($kategoriAktif) && $kategoriAktif !== 'semua')
                <input type="hidden" name="kategori" value="{{ $kategoriAktif }}">
            @endif

            <div class="relative flex-1">
                <span class="material-symbols-outlined absolute left-3 top-2.5 text-slate-400 text-sm">search</span>
                <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari judul dokumen, deskripsi, atau tahun..."
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-9 pr-4 py-2 text-xs font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors">
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="px-4 py-2 bg-navy-900 hover:bg-navy-800 text-white font-semibold text-xs rounded-xl transition-colors shrink-0">
                    Cari
                </button>
                @if(request('cari') || (!empty($kategoriAktif) && $kategoriAktif !== 'semua'))
                    <a href="{{ route('admin.pustaka.index') }}" class="px-3 py-2 text-rose-600 hover:bg-rose-50 font-semibold text-xs rounded-xl transition-colors inline-flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">restart_alt</span>
                        <span>Reset Filter</span>
                    </a>
                @endif
            </div>
        </form>
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
                                <div class="font-bold text-slate-900 text-xs">{{ $doc->judul }}</div>
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
                                Tidak ada dokumen pustaka ditemukan.
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

    <!-- Modal Kelola Kategori Pustaka (Alpine.js Real-Time) -->
    <div x-show="isModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="isModalOpen" x-transition.opacity @click="isModalOpen = false" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="isModalOpen" x-transition.scale.origin.center class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-200">
                <!-- Modal Header -->
                <div class="bg-navy-950 px-6 py-4 flex items-center justify-between">
                    <div class="flex items-center gap-2.5 text-white">
                        <span class="material-symbols-outlined text-amber-400">category</span>
                        <h3 class="font-bold text-sm">Kelola Kategori Pustaka</h3>
                    </div>
                    <button type="button" @click="isModalOpen = false" class="text-slate-400 hover:text-white transition-colors cursor-pointer">
                        <span class="material-symbols-outlined text-lg">close</span>
                    </button>
                </div>

                <div class="p-6 space-y-5">
                    <!-- Alert Message -->
                    <template x-if="alertMessage">
                        <div class="p-3 rounded-xl text-xs font-semibold flex items-center gap-2"
                            :class="alertType === 'success' ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'bg-rose-50 text-rose-800 border border-rose-200'">
                            <span class="material-symbols-outlined text-base" x-text="alertType === 'success' ? 'check_circle' : 'error'"></span>
                            <span x-text="alertMessage"></span>
                        </div>
                    </template>

                    <!-- Form Tambah Kategori Baru -->
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 space-y-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Tambah Kategori Pustaka Baru</label>
                        <div class="flex items-center gap-2">
                            <input type="text" x-model="newCategoryName" @keyup.enter="tambahKategori()" placeholder="Nama kategori baru (mis: Juknis, Lapkeu)..."
                                class="flex-1 bg-white border border-slate-300 rounded-xl px-3.5 py-2 text-xs font-medium text-slate-800 focus:outline-none focus:border-navy-900">
                            <button type="button" @click="tambahKategori()" :disabled="isLoading"
                                class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-navy-950 font-bold text-xs rounded-xl transition-all shadow-2xs shrink-0 cursor-pointer disabled:opacity-50">
                                <span x-show="!isLoading">+ Tambah</span>
                                <span x-show="isLoading">Memproses...</span>
                            </button>
                        </div>
                    </div>

                    <!-- Daftar Kategori -->
                    <div class="space-y-2">
                        <div class="flex items-center justify-between text-xs font-bold text-slate-500 uppercase tracking-wider px-1">
                            <span>Daftar Kategori</span>
                            <span>Jumlah Dokumen</span>
                        </div>

                        <div class="max-h-60 overflow-y-auto divide-y divide-slate-100 border border-slate-200 rounded-xl">
                            <template x-for="kat in categories" :key="kat">
                                <div class="p-3 bg-white hover:bg-slate-50 flex items-center justify-between gap-3 transition-colors">
                                    <!-- Mode Normal -->
                                    <div x-show="editingCategory !== kat" class="flex-1 flex items-center justify-between pr-2">
                                        <span class="text-xs font-bold text-slate-800" x-text="formatLabel(kat)"></span>
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-mono font-bold bg-slate-100 text-slate-600" x-text="(stats[kat] || 0) + ' dokumen'"></span>
                                    </div>

                                    <!-- Mode Rename -->
                                    <div x-show="editingCategory === kat" class="flex-1 flex items-center gap-2">
                                        <input type="text" x-model="renameCategoryName" @keyup.enter="simpanRename(kat)"
                                            class="w-full bg-amber-50/60 border border-amber-300 rounded-lg px-2.5 py-1 text-xs font-semibold text-slate-800 focus:outline-none">
                                        <button type="button" @click="simpanRename(kat)" class="p-1 text-emerald-600 hover:text-emerald-800" title="Simpan Nama">
                                            <span class="material-symbols-outlined text-base">check</span>
                                        </button>
                                        <button type="button" @click="editingCategory = null" class="p-1 text-slate-400 hover:text-slate-600" title="Batal">
                                            <span class="material-symbols-outlined text-base">close</span>
                                        </button>
                                    </div>

                                    <!-- Tombol Aksi Kategori -->
                                    <div x-show="editingCategory !== kat" class="flex items-center gap-1">
                                        <button type="button" @click="mulaiRename(kat)" class="p-1 text-slate-400 hover:text-indigo-600 transition-colors" title="Ubah Nama">
                                            <span class="material-symbols-outlined text-base">edit</span>
                                        </button>
                                        <button type="button" @click="konfirmasiHapus(kat)" class="p-1 text-slate-400 hover:text-rose-600 transition-colors" title="Hapus Kategori">
                                            <span class="material-symbols-outlined text-base">delete</span>
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Confirm Delete Section -->
                    <template x-if="deletingCategory">
                        <div class="p-4 bg-rose-50 border border-rose-200 rounded-xl space-y-3">
                            <div class="text-xs text-rose-900 font-medium">
                                Hapus kategori <strong class="font-bold text-rose-950" x-text="formatLabel(deletingCategory)"></strong>?
                                <template x-if="(stats[deletingCategory] || 0) > 0">
                                    <p class="mt-1 text-[11px] text-rose-700">
                                        Terdapat <span class="font-bold" x-text="stats[deletingCategory]"></span> dokumen dalam kategori ini. Pilih kategori dialihkan:
                                    </p>
                                </template>
                            </div>

                            <template x-if="(stats[deletingCategory] || 0) > 0">
                                <select x-model="targetCategoryForDelete" class="w-full bg-white border border-rose-300 rounded-lg px-3 py-1.5 text-xs font-semibold text-slate-800">
                                    <template x-for="target in categories.filter(c => c !== deletingCategory)" :key="target">
                                        <option :value="target" x-text="formatLabel(target)"></option>
                                    </template>
                                </select>
                            </template>

                            <div class="flex items-center justify-end gap-2 pt-1">
                                <button type="button" @click="deletingCategory = null" class="px-3 py-1.5 bg-white border border-slate-300 text-slate-700 rounded-lg text-xs font-semibold hover:bg-slate-100">
                                    Batal
                                </button>
                                <button type="button" @click="eksekusiHapus()" :disabled="isLoading" class="px-3 py-1.5 bg-rose-600 text-white rounded-lg text-xs font-bold hover:bg-rose-700 cursor-pointer">
                                    Ya, Hapus Kategori
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
function kelolaKategoriPustakaApp() {
    return {
        isModalOpen: false,
        isLoading: false,
        alertMessage: '',
        alertType: 'success',
        categories: @json($daftarKategori),
        stats: @json($kategoriStats),
        activeCategory: @json($kategoriAktif ?? 'semua'),
        newCategoryName: '',
        editingCategory: null,
        renameCategoryName: '',
        deletingCategory: null,
        targetCategoryForDelete: 'uu',

        formatLabel(kat) {
            const labels = {
                'uu': 'Undang-Undang (UU)',
                'adart': 'AD / ART',
                'rekomendasi': 'Rekomendasi',
                'sk': 'Surat Keputusan (SK)',
                'berita_acara': 'Berita Acara',
                'data_bps': 'Data BPS',
            };
            return labels[kat] || kat;
        },

        openModalModal() {
            this.isModalOpen = true;
            this.alertMessage = '';
            this.deletingCategory = null;
            this.editingCategory = null;
        },

        showAlert(msg, type = 'success') {
            this.alertMessage = msg;
            this.alertType = type;
            setTimeout(() => { this.alertMessage = ''; }, 4000);
        },

        async tambahKategori() {
            if (!this.newCategoryName.trim()) return;
            this.isLoading = true;
            try {
                const res = await fetch("{{ route('admin.pustaka.kategori.store') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ nama: this.newCategoryName })
                });
                const data = await res.json();
                if (data.success) {
                    this.categories = data.categories;
                    this.stats = data.stats;
                    this.newCategoryName = '';
                    this.showAlert(data.message, 'success');
                } else {
                    this.showAlert(data.message || 'Gagal menambahkan kategori.', 'error');
                }
            } catch (err) {
                this.showAlert('Terjadi kesalahan jaringan.', 'error');
            } finally {
                this.isLoading = false;
            }
        },

        mulaiRename(kat) {
            this.editingCategory = kat;
            this.renameCategoryName = kat;
        },

        async simpanRename(katLama) {
            if (!this.renameCategoryName.trim()) return;
            this.isLoading = true;
            try {
                const res = await fetch("{{ route('admin.pustaka.kategori.rename') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ kategori_lama: katLama, kategori_baru: this.renameCategoryName })
                });
                const data = await res.json();
                if (data.success) {
                    this.categories = data.categories;
                    this.stats = data.stats;
                    this.editingCategory = null;
                    this.showAlert(data.message, 'success');
                } else {
                    this.showAlert(data.message || 'Gagal merename kategori.', 'error');
                }
            } catch (err) {
                this.showAlert('Terjadi kesalahan jaringan.', 'error');
            } finally {
                this.isLoading = false;
            }
        },

        konfirmasiHapus(kat) {
            this.deletingCategory = kat;
            const remaining = this.categories.filter(c => c !== kat);
            if (remaining.length > 0) {
                this.targetCategoryForDelete = remaining[0];
            }
        },

        async eksekusiHapus() {
            if (!this.deletingCategory) return;
            this.isLoading = true;
            try {
                const res = await fetch("{{ route('admin.pustaka.kategori.delete') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        kategori: this.deletingCategory,
                        alihkan_ke: this.targetCategoryForDelete
                    })
                });
                const data = await res.json();
                if (data.success) {
                    this.categories = data.categories;
                    this.stats = data.stats;
                    const hapusKat = this.deletingCategory;
                    this.deletingCategory = null;
                    this.showAlert(data.message, 'success');

                    if (this.activeCategory === hapusKat) {
                        this.activeCategory = 'semua';
                    }
                } else {
                    this.showAlert(data.message || 'Gagal menghapus kategori.', 'error');
                }
            } catch (err) {
                this.showAlert('Terjadi kesalahan jaringan.', 'error');
            } finally {
                this.isLoading = false;
            }
        }
    };
}
</script>
@endpush
@endsection
