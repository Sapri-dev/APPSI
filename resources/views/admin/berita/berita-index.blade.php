@extends('layouts.admin')

@section('title', 'Kelola Berita & Artikel')
@section('subtitle', 'Daftar semua berita dan siaran pers APPSI')

@section('content')
<div class="space-y-5">

    <!-- Header Action Bar -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4"
         x-data="{
             showModal: false,
             categories: {{ json_encode($daftarKategori) }},
             stats: {{ json_encode($kategoriStats) }},
             inputKategoriBaru: '',
             editKat: null,
             newName: '',
             deleteKat: null,
             fallbackKat: 'Berita',
             isLoading: false,
             flashMessage: '',
             async submitTambah() {
                 if (!this.inputKategoriBaru.trim()) return;
                 this.isLoading = true;
                 try {
                     const res = await fetch('{{ route('admin.berita.kategori.store') }}', {
                         method: 'POST',
                         headers: {
                             'Content-Type': 'application/json',
                             'X-CSRF-TOKEN': '{{ csrf_token() }}',
                             'Accept': 'application/json'
                         },
                         body: JSON.stringify({ kategori: this.inputKategoriBaru.trim() })
                     });
                     const data = await res.json();
                     if (data.success) {
                         this.categories = data.categories;
                         this.stats = data.stats;
                         this.inputKategoriBaru = '';
                         this.flashMessage = data.message;
                         setTimeout(() => this.flashMessage = '', 3500);
                     }
                 } catch (err) {
                     console.error(err);
                 } finally {
                     this.isLoading = false;
                 }
             },
             async submitRename() {
                 if (!this.newName.trim()) return;
                 this.isLoading = true;
                 try {
                     const res = await fetch('{{ route('admin.berita.kategori.rename') }}', {
                         method: 'POST',
                         headers: {
                             'Content-Type': 'application/json',
                             'X-CSRF-TOKEN': '{{ csrf_token() }}',
                             'Accept': 'application/json'
                         },
                         body: JSON.stringify({ kategori_lama: this.editKat, kategori_baru: this.newName.trim() })
                     });
                     const data = await res.json();
                     if (data.success) {
                         this.categories = data.categories;
                         this.stats = data.stats;
                         this.editKat = null;
                         this.newName = '';
                         this.flashMessage = data.message;
                         setTimeout(() => this.flashMessage = '', 3500);
                     }
                 } catch (err) {
                     console.error(err);
                 } finally {
                     this.isLoading = false;
                 }
             },
             async submitDelete() {
                 this.isLoading = true;
                 try {
                     const res = await fetch('{{ route('admin.berita.kategori.delete') }}', {
                         method: 'POST',
                         headers: {
                             'Content-Type': 'application/json',
                             'X-CSRF-TOKEN': '{{ csrf_token() }}',
                             'Accept': 'application/json'
                         },
                         body: JSON.stringify({ kategori: this.deleteKat, alihkan_ke: this.fallbackKat })
                     });
                     const data = await res.json();
                     if (data.success) {
                         this.categories = data.categories;
                         this.stats = data.stats;
                         this.deleteKat = null;
                         this.flashMessage = data.message;
                         setTimeout(() => this.flashMessage = '', 3500);
                     }
                 } catch (err) {
                     console.error(err);
                 } finally {
                     this.isLoading = false;
                 }
             }
         }">
        <div>
            <h3 class="text-lg font-bold text-slate-800">Manajemen Berita</h3>
            <p class="text-xs text-slate-500">Total {{ $berita->total() }} artikel tersimpan dalam database</p>
        </div>
        <div class="flex items-center gap-2.5">
            <button type="button" @click="showModal = true"
                class="px-4 py-2.5 bg-white hover:bg-slate-50 text-slate-700 font-semibold text-xs rounded-xl border border-slate-200 shadow-2xs transition-all inline-flex items-center gap-2 shrink-0 cursor-pointer">
                <span class="material-symbols-outlined text-sm text-amber-600">category</span>
                <span>Kelola Kategori</span>
            </button>
            <a href="{{ route('admin.berita.create') }}" class="px-4 py-2.5 bg-amber-500 hover:bg-amber-600 text-navy-950 font-bold text-xs rounded-xl shadow-xs transition-all inline-flex items-center gap-2 shrink-0">
                <span class="material-symbols-outlined text-sm">add</span>
                <span>Tulis Berita Baru</span>
            </a>
        </div>

        <!-- MODAL KELOLA KATEGORI -->
        <div x-show="showModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
            <div @click.away="showModal = false; editKat = null; deleteKat = null"
                 class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-slate-100 space-y-5 animate-scale-up">

                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-amber-500">category</span>
                        <h4 class="font-bold text-slate-800 text-sm">Kelola Kategori Berita</h4>
                    </div>
                    <button type="button" @click="showModal = false; editKat = null; deleteKat = null" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                        <span class="material-symbols-outlined text-lg">close</span>
                    </button>
                </div>

                <!-- Flash Message Notifikasi -->
                <div x-show="flashMessage" x-cloak x-transition
                     class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-3.5 py-2.5 rounded-xl text-xs flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm text-emerald-600">check_circle</span>
                    <span x-text="flashMessage"></span>
                </div>

                <!-- Form Tambah Kategori Baru Langsung -->
                <form @submit.prevent="submitTambah()" class="flex items-center gap-2 bg-slate-50 p-2 rounded-xl border border-slate-200">
                    <input type="text" x-model="inputKategoriBaru" required :disabled="isLoading"
                        placeholder="Ketik nama kategori baru..."
                        class="flex-1 bg-white border border-slate-200 rounded-lg px-3 py-1.5 text-xs font-medium text-slate-800 focus:outline-none focus:ring-1 focus:ring-amber-500 disabled:opacity-50">
                    <button type="submit" :disabled="isLoading"
                        class="px-3.5 py-1.5 bg-amber-500 hover:bg-amber-600 text-navy-950 font-bold text-xs rounded-lg shadow-2xs transition-colors inline-flex items-center gap-1 shrink-0 disabled:opacity-50 cursor-pointer">
                        <span class="material-symbols-outlined text-sm" x-show="!isLoading">add</span>
                        <span x-text="isLoading ? 'Menyimpan...' : 'Tambah'"></span>
                    </button>
                </form>

                <!-- Form Ubah Nama Kategori -->
                <div x-show="editKat !== null" class="bg-amber-50/70 border border-amber-200 p-4 rounded-xl space-y-3">
                    <h5 class="text-xs font-bold text-amber-900 flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-sm">edit</span>
                        <span>Ubah Nama Kategori: <strong x-text="editKat"></strong></span>
                    </h5>
                    <form @submit.prevent="submitRename()" class="space-y-3">
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-600 mb-1">Nama Kategori Baru</label>
                            <input type="text" x-model="newName" required :disabled="isLoading"
                                class="w-full bg-white border border-amber-300 rounded-lg px-3 py-2 text-xs font-medium text-slate-800 focus:outline-none focus:ring-1 focus:ring-amber-500 disabled:opacity-50"
                                placeholder="Masukkan nama baru...">
                        </div>
                        <div class="flex items-center justify-end gap-2">
                            <button type="button" @click="editKat = null; newName = ''" :disabled="isLoading"
                                class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-lg cursor-pointer">
                                Batal
                            </button>
                            <button type="submit" :disabled="isLoading"
                                class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-navy-950 text-xs font-bold rounded-lg shadow-2xs cursor-pointer disabled:opacity-50">
                                <span x-text="isLoading ? 'Menyimpan...' : 'Simpan Perubahan'"></span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Form Konfirmasi Hapus Kategori -->
                <div x-show="deleteKat !== null" class="bg-rose-50/70 border border-rose-200 p-4 rounded-xl space-y-3">
                    <h5 class="text-xs font-bold text-rose-900 flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-sm">warning</span>
                        <span>Hapus Kategori: <strong x-text="deleteKat"></strong></span>
                    </h5>
                    <p class="text-xs text-rose-700 leading-normal">
                        Semua artikel dengan kategori ini akan otomatis dialihkan ke kategori pilihan di bawah:
                    </p>
                    <form @submit.prevent="submitDelete()" class="space-y-3">
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-600 mb-1">Alihkan Artikel Ke</label>
                            <select x-model="fallbackKat" :disabled="isLoading"
                                class="w-full bg-white border border-rose-300 rounded-lg px-3 py-2 text-xs font-medium text-slate-800 focus:outline-none focus:ring-1 focus:ring-rose-500 disabled:opacity-50">
                                <template x-for="k in categories.filter(c => c !== deleteKat)" :key="k">
                                    <option :value="k" x-text="k"></option>
                                </template>
                            </select>
                        </div>
                        <div class="flex items-center justify-end gap-2">
                            <button type="button" @click="deleteKat = null" :disabled="isLoading"
                                class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-lg cursor-pointer">
                                Batal
                            </button>
                            <button type="submit" :disabled="isLoading"
                                class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-lg shadow-2xs cursor-pointer disabled:opacity-50">
                                <span x-text="isLoading ? 'Menghapus...' : 'Ya, Hapus Kategori'"></span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Daftar Kategori Aktif (Dinamis dari Alpine.js) -->
                <div class="space-y-2 max-h-72 overflow-y-auto pr-1">
                    <template x-for="kat in categories" :key="kat">
                        <div class="flex items-center justify-between p-3 rounded-xl border border-slate-100 bg-slate-50/50 hover:bg-slate-50 transition-colors">
                            <div>
                                <div class="font-bold text-slate-800 text-xs" x-text="kat"></div>
                                <div class="text-[11px] text-slate-400" x-text="(stats[kat] || 0) + ' artikel terdaftar'"></div>
                            </div>
                            <div class="flex items-center gap-1">
                                <button type="button" @click="editKat = kat; newName = kat; deleteKat = null"
                                    title="Ubah Nama" class="p-1.5 text-slate-500 hover:text-amber-600 hover:bg-white rounded-lg transition-colors cursor-pointer">
                                    <span class="material-symbols-outlined text-base">edit</span>
                                </button>
                                <button type="button" @click="deleteKat = kat; editKat = null"
                                    title="Hapus Kategori" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-white rounded-lg transition-colors cursor-pointer">
                                    <span class="material-symbols-outlined text-base">delete</span>
                                </button>
                            </div>
                        </div>
                    </template>
                    <div x-show="categories.length === 0" class="p-6 text-center text-xs text-slate-400">
                        Belum ada kategori terdaftar.
                    </div>
                </div>

                <div class="pt-2 border-t border-slate-100 flex justify-end">
                    <button type="button" @click="showModal = false; editKat = null; deleteKat = null"
                        class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl cursor-pointer">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3">
        <form action="{{ route('admin.berita.index') }}" method="GET" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5 flex-1">
            <div class="relative flex-1">
                <span class="material-symbols-outlined absolute left-3 top-2.5 text-slate-400 text-sm">search</span>
                <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari judul berita..."
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-9 pr-4 py-2 text-xs font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors">
            </div>

            <div class="sm:w-56">
                <select name="kategori" onchange="this.form.submit()"
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium text-slate-800 focus:bg-white focus:outline-none focus:border-navy-900 focus:ring-1 focus:ring-navy-900 transition-colors">
                    <option value="semua">Semua Kategori</option>
                    @foreach($daftarKategori as $kat)
                        <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="px-4 py-2 bg-navy-900 hover:bg-navy-800 text-white font-semibold text-xs rounded-xl transition-colors shrink-0">
                Filter
            </button>

            @if(request('cari') || (request('kategori') && request('kategori') !== 'semua'))
                <a href="{{ route('admin.berita.index') }}" class="px-3 py-2 text-rose-600 hover:bg-rose-50 font-semibold text-xs rounded-xl transition-colors inline-flex items-center justify-center gap-1">
                    <span class="material-symbols-outlined text-sm">restart_alt</span>
                    <span>Reset</span>
                </a>
            @endif
        </form>
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
