# CLAUDE.md — TALL Stack Frontend Project

> Baca file ini setiap sesi baru. Ini adalah "konstitusi" proyek kita.

---

## STACK & IDENTITAS PROYEK
- **Stack**: TALL — **T**ailwind CSS v3 · **A**lpine.js v3 · **L**aravel 11 · **L**ivewire v3
- **Template Engine**: Blade
- **Build Tool**: Vite (bukan Mix)
- **Auth**: Laravel Breeze (Blade variant)
- **Role Saya**: Frontend awam — prioritaskan penjelasan singkat sebelum kode

---

## PERINTAH CEPAT
```bash
php artisan serve          # Jalankan server lokal
npm run dev                # Jalankan Vite dev server (wajib bersamaan)
npm run build              # Build untuk produksi
php artisan migrate        # Jalankan migrasi database
php artisan optimize:clear # Bersihkan cache semua
php artisan livewire:make NamaKomponen  # Buat komponen Livewire baru
```

---

## ATURAN WAJIB (SELALU IKUTI)

### Blade & Livewire
- Gunakan `wire:model.live` untuk binding real-time, `wire:model.lazy` untuk form besar
- Selalu tambahkan `wire:loading` pada tombol submit
- Pecah UI menjadi komponen Livewire kecil, jangan satu file raksasa
- Gunakan `<x-slot>` dan Blade Components (`php artisan make:component`) untuk UI yang dipakai ulang

### Tailwind CSS
- **Tidak boleh** menulis CSS kustom kecuali benar-benar tidak ada utility class-nya
- Gunakan `@apply` di dalam `resources/css/app.css` hanya untuk komponen berulang (tombol, badge)
- Responsive: selalu mobile-first (`sm:` → `md:` → `lg:`)
- Dark mode: gunakan class `dark:` jika proyek mendukungnya

### Alpine.js
- Gunakan Alpine hanya untuk interaksi **sisi klien murni** (dropdown, modal, toggle, accordion)
- Untuk data yang perlu disimpan ke database → pakai **Livewire**, bukan Alpine
- Kombinasikan dengan Livewire menggunakan `$wire` entangle jika perlu sinkronisasi

### Laravel (Backend)
- Validasi input: wajib gunakan `FormRequest`, jangan `$request->all()`
- Query database: selalu `with()` (eager loading) untuk hindari masalah N+1
- Gunakan helper `asset()`, `route()`, `vite()` — **jangan hardcode URL**

---

## STRUKTUR FOLDER PENTING
```
resources/
  views/
    components/     ← Blade components (UI reusable)
    livewire/       ← Template Livewire
    layouts/        ← Layout utama (app.blade.php, guest.blade.php)
  css/app.css       ← @tailwind directives + @apply custom
  js/app.js         ← Alpine.js & Livewire bootstrap
app/
  Livewire/         ← Class PHP Livewire
  Http/Requests/    ← FormRequest validasi
```

---

## PRINSIP TOKEN-EFISIEN (UNTUK SAYA)
1. **Mulai sesi baru** untuk setiap fitur/halaman berbeda — ketik `/clear` dulu
2. **Gunakan slash commands** di bawah untuk tugas spesifik agar AI tidak membaca konteks berlebih
3. Jika sesi sudah panjang dan AI mulai lambat → simpan progres ke `tasks/progress.md`, lalu `/clear`
4. **Sertakan hanya file yang relevan** saat minta bantuan, jangan dump seluruh codebase

---

## IDENTITAS DESAIN PROYEK
> Diisi otomatis via /init — jangan diubah sembarangan.

- **Palet warna utama**: `navy-900 (#001647) · amber-500 (#f59e0b) · slate-900 · white`
- **Font display & body**: `Plus Jakarta Sans`
- **Nuansa desain**: `professional-government · clean-modern · navy-accent`
- **Border radius dominan**: `rounded-2xl untuk card & modal, rounded-xl untuk tombol/input`

> Semua komponen UI baru harus konsisten dengan identitas di atas.

---

## MODE AI

### 🎨 UI Designer Mode
Aktif otomatis saat menggunakan `/fix-ui` atau `/new-page`.
- Berpikir sebagai desainer, bukan hanya programmer
- Tawarkan pilihan estetik, jangan langsung eksekusi kalau ada keputusan selera
- Gunakan token Tailwind yang konsisten dengan identitas proyek di atas

### 🔧 Debug Mode
Aktif saat menggunakan `/debug`.
- Setiap error yang berhasil dipecahkan **wajib dicatat** ke `tasks/lessons.md`
- Format catatan: `[konteks error] → [penyebab] → [solusi permanen]`
- Sebelum menjawab, selalu cek `tasks/lessons.md` apakah error serupa pernah terjadi

### 🧠 Advisor Mode
Aktif **sepanjang waktu** — bahkan tanpa diminta.
- Jika Claude melihat pendekatan yang lebih baik, **wajib sampaikan** sebelum mengeksekusi
- Format: `💡 SARAN: [masalah yang dilihat] → [rekomendasi]`
- Jika ada technical debt atau pola berbahaya, flagging langsung
- Tujuan: bukan hanya mengerjakan perintah, tapi membantu saya berkembang

---

## SLASH COMMANDS TERSEDIA
| Command | Fungsi |
|---|---|
| `/init` | 🚀 **Mulai proyek baru** — onboarding & konsultasi |
| `/new-component` | Buat komponen Blade + Livewire baru |
| `/new-page` | Buat halaman lengkap dengan desain premium |
| `/fix-ui` | Perbaiki tampilan & tambah interaktivitas Alpine.js |
| `/debug` | Debug error + catat pelajaran ke lessons.md |
| `/form` | Buat form Livewire lengkap dengan validasi |
| `/deploy-check` | Cek kesiapan sebelum upload ke hosting |
| `/review` | Minta Claude review kode & beri saran peningkatan |

> File detail tiap command ada di `.claude/commands/`

---

## CATATAN PELAJARAN
> Jangan edit manual. Diisi otomatis oleh Claude via `/debug`.
> Lihat file lengkapnya di `tasks/lessons.md`

---

## 🚀 MULAI PROYEK BARU
Jika ini adalah awal dari proyek baru dan bagian **KONTEKS PROYEK** di bawah masih kosong:

> **Ketik `/init` dan Claude akan memandu Anda dari nol** — menggali kebutuhan, merekomendasikan desain, dan membuat rencana kerja bertahap. Jangan langsung minta kode sebelum `/init` selesai.

---

## KONTEKS PROYEK
> Diisi otomatis via /init.

- **Nama Proyek**: `Website Resmi APPSI (Asosiasi Pemerintah Provinsi Seluruh Indonesia)`
- **Tujuan**: Portal berita, profil organisasi, pustaka dokumen regulasi, dan daftar 38 provinsi anggota
- **Target User**: Publik (bebas akses) & Admin (Custom Blade Admin Panel dengan login)
- **Stack**: Laravel 12 · Tailwind CSS · Alpine.js · TinyMCE · MySQL
- **Fitur Selesai**: Database MySQL, Admin Panel (Dashboard, Berita, Pengurus, Pustaka, 38 Provinsi, Pengaturan), Frontend Publik (Beranda, Sejarah, Visi-Misi, Dewan Pengurus/Penasehat/Pakar, Sekretariat, 38 Provinsi, Pustaka, Berita & Detail Artikel)
- **Akun Admin Default**: `admin@appsi.or.id` / `appsi@2025`
