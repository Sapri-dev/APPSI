# tasks/progress.md — Pelacak Progres Proyek

> Gunakan file ini untuk menyimpan konteks sebelum sesi baru.
> Saat mulai sesi baru, minta asisten: "Baca tasks/progress.md dan lanjutkan."

---

## Status Proyek
**Terakhir diupdate**: 2026-08-24 (13:36 WIB)
**Fase saat ini**: Development — Frontend, Admin Layout & Multi-Channel Feed Selesai
**Target deadline**: TBD
**Target hosting**: Hostinger (shared hosting) / Laragon lokal
**Stack**: Laravel 12 · Tailwind CSS v3 · Alpine.js v3 · MySQL

---

## Fitur Selesai ✅

### Fondasi & Backend Utama
- [x] Setup MySQL database (tabel `berita`, `pengurus`, `provinsi`, `pustaka`, `pengaturan`, `users`)
- [x] Seeder data awal: 38 provinsi, susunan Dewan Pengurus/Penasehat/Pakar/Sekretariat, Pengaturan, Admin User
- [x] Controller & Routing (43 routes)
- [x] Custom Admin Panel dengan authentication & middleware
- [x] Admin Dashboard dengan statistik dan daftar aktivitas
- [x] Admin Berita (CRUD + TinyMCE Rich Text Editor + Upload Gambar)
- [x] Admin Pengurus (CRUD + Upload Foto + Kategori Dewan)
- [x] Admin Pustaka (CRUD + File Upload PDF/DOC/URL + Kategori Regulasi)
- [x] Admin 38 Provinsi (Edit Gubernur & Upload Lambang)
- [x] Admin Pengaturan Website (Identitas, Kontak, Visi Misi, Sosmed)
- [x] Image Placeholders (`placeholder-avatar.png`, `placeholder-lambang.png`, `placeholder-berita.jpg`)
- [x] Navbar & Footer terhubung ke seluruh halaman publik & login admin

---

### Sesi 2026-08-20 & 2026-08-21 ✅
- [x] **Top Header (Navbar)**:
  - Logo resmi APPSI (`Logo-appsi.png`)
  - Ikon Search modal dengan shortcut `Ctrl+K` dan `Esc`
  - Tautan sosial media resmi (Facebook, YouTube, Instagram)
- [x] **Admin Sidebar & Pagination Fix**:
  - Sidebar `fixed` position dengan mobile overlay
  - Pagination per-page (10/25/38/Semua) pada tabel 38 provinsi
- [x] **Hero News Slider Dinamis** (`beranda.blade.php`):
  - 5 berita terbaru dari database dengan thumbnail background, kategori amber, tanggal, dan auto-slide 5 detik
- [x] **Provinsi Anggota Marquee Slider** (`beranda.blade.php`):
  - Slider horizontal marquee otomatis tanpa putus (infinite auto-scroll)

---

### Sesi 2026-08-24 (Pagi) ✅
- [x] **Navigasi Tetap Tampil (Sticky / Always Visible)** (`bottom-nav.blade.php`):
  - Menghapus efek auto-hide saat scroll ke bawah sehingga Floating Bottom Navigation Bar selalu tampil terus menerus.
- [x] **Pembersihan Submenu Tentang APPSI** (`bottom-nav.blade.php`, `beranda.blade.php`, `routes/web.php`):
  - Menghapus item Visi & Misi dari popup submenu Tentang karena sudah terintegrasi lengkap pada Beranda.
- [x] **Pembersihan Footer & Hak Cipta** (`footer.blade.php`):
  - Memperbarui logo menjadi logo lingkaran APPSI besar (110px) berdampingan dengan deskripsi organisasi dan padding bawah yang proporsional.
- [x] **Sinkronisasi Foto & Database Dewan Pengurus & Penasehat 100%**:
  - Mengunduh dan menghubungkan seluruh foto resmi 9 anggota Dewan Penasehat ke `public/storage/pengurus/`.
  - Memperbarui database seeder dan kartu profil pada `dewan-penasehat.blade.php`.
- [x] **Scraping & Sinkronisasi 100% Dokumen PDF Resmi Asli dari appsi.or.id** (`public/storage/pustaka/`):
  - Mengunduh 47 dokumen PDF resmi multi-halaman (AD/ART, UU 23/2014, Rekomendasi Munas, Berita Acara, 6 SK Kepengurusan, dan 37 Buku Statistik BPS).
  - Integrasi 3D Flipbook Reader (DFlip) interaktif.

---

### Sesi 2026-08-24 (Siang - Navbar Popup, Admin Layout, Berita & IG Feed) ✅
- [x] **Redesign Popup Navbar Bawah (Clean & Minimal)** (`bottom-nav.blade.php`):
  - Tampilan clean tanpa header besar, teks penjelasan panjang dihapus, tombol "Lihat Semua Pustaka" ditiadakan.
  - Ikon sederhana Material Symbols + nama menu + centang status aktif.
- [x] **Submenu Data BPS Dual-Mode Responsif** (`bottom-nav.blade.php`):
  - **Di Mobile / Layar HP (`< 768px`)**: Membuka **Inline Accordion** di dalam kartu popup utama — menampilkan tombol pill tahun (**2018**, **2019**, **2020**), 100% aman dan tidak terpotong tepi layar.
  - **Di Desktop (`≥ 768px`)**: Membuka **Side Flyout Popup** yang melayang rapi di sebelah kanan kartu Pustaka utama.
- [x] **Verifikasi & Penyempurnaan Dewan Penasehat** (`dewan-penasehat.blade.php`):
  - Data 9 anggota dewan penasehat 100% sinkron dengan `appsi.or.id/dewan-penasehat/`.
  - Teks Peran & Fungsi Strategis dilengkapi menjadi 5 butir resmi.
- [x] **Sinkronisasi 22 Berita & Kategori Resmi APPSI** (`BeritaController.php`, `berita.blade.php`, `scrape_berita.php`):
  - Seluruh 22 artikel resmi tersinkron dari WordPress REST API `appsi.or.id` beserta media beresolusi penuh.
  - Kategori dinamis: `Berita`, `Munas`, `Rapat Kerja Nasional`, `Seminar Nasional`, `Umum`.
  - Tab filter kategori di halaman `/berita` dibuat otomatis dinamis sesuai database.
- [x] **Kredensial Login Admin**:
  - Password admin diperbarui menjadi `password` (Email: `admin@appsi.or.id`).
- [x] **Redesign Full-Width 2-Column Admin Forms**:
  - Seluruh form admin dirombak menjadi tata letak 2-kolom lebar penuh (*Full Width*) modern khas CMS profesional:
    - `admin/pengaturan.blade.php`: Kolom Kiri (Identitas & Visi Misi) & Kolom Kanan (Kontak, Sosmed, Tombol Simpan).
    - `admin/berita/form.blade.php`: Kolom Kiri (Judul, Ringkasan, TinyMCE Editor 480px) & Kolom Kanan (Status Publikasi, Kategori Resmi, Featured Image).
    - `admin/pengurus/form.blade.php`: Kolom Kiri (Data Pengurus) & Kolom Kanan (Foto Profil, Urutan, Status).
    - `admin/pustaka/form.blade.php`: Kolom Kiri (Dokumen Info) & Kolom Kanan (Berkas PDF/DOC/URL, Visibilitas).
    - `admin/provinsi/form.blade.php`: Kolom Kiri (Info Daerah & Gubernur) & Kolom Kanan (Lambang Daerah).
- [x] **Integrasi Live Instagram Auto-Sync Service Resmi APPSI** (`beranda.blade.php`, `InstagramService.php`, `scrape_instagram.cjs`, `PageController.php`):
  - Sistem otomatis (*Custom Native Service*) yang secara berkala menyedot link postingan & Reels terbaru langsung dari akun resmi `@appsi.or.id` via background worker.
  - Menampilkan 3 frame embed resmi asli dari Instagram (Reels & Postingan) lengkap dengan video playback, caption asli, jumlah likes, komentar, dan direct link ke aplikasi Instagram.
  - Dilengkapi sistem cache 6 jam di Laravel sehingga website tetap super cepat, bebas batasan kuota (*unlimited*), bebas watermark pihak ketiga, dan 100% gratis selamanya.

### Sesi 2026-08-24 (Sore - Responsivitas Mobile Navbar & Sinkronisasi Teks Beranda) ✅
- [x] **Penyempurnaan Responsivitas Floating Bottom Navbar** (`bottom-nav.blade.php`):
  - Memisahkan sizing desktop vs mobile menggunakan CSS media query (`@media (max-width: 767px)`).
  - Tampilan desktop tetap luas, lega, dan proporsional dengan logo lengkap.
  - Tampilan mobile sangat rapi, kompak, logo otomatis menjadi ikon bulat ringkas (36px), padding disesuaikan agar pas di layar HP kecil (iPhone/Android) tanpa overflow.
- [x] **Pemeriksaan Header & Logo Atas**:
  - Memverifikasi tidak adanya teks tersembunyi / tumpang tindih di belakang header logo.
- [x] **Sinkronisasi 100% Teks Beranda dengan Website Resmi appsi.or.id** (`beranda.blade.php`, `PengaturanSeeder`):
  - **Deskripsi Mengenal APPSI**: Redaksi resmi tentang APPSI sebagai wadah koordinasi nasional dan mitra strategis Pemerintah Pusat dalam bingkai NKRI.
  - **Visi & Misi 2025–2029**:
    - Visi: *"Terwujudnya sinergi nasional Pemerintah Provinsi yang kuat, mandiri, dan berdaya saing dalam mendukung pembangunan nasional berkelanjutan."*
    - 4 Misi: Koordinasi Antar Daerah, Sinkronisasi Kebijakan, Tata Kelola Pemerintahan, dan Aspirasi Nasional.
  - **Subtitle Program Utama**: *"Inisiatif strategis yang dijalankan APPSI"*.
  - **Channel YouTube**: Diselaraskan ke akun resmi `@OfficialAPPSI` pada database `pengaturan`.
  - **Layout & Desain**: Tetap terjaga 100% utuh tanpa merusak estetika antarmuka.

---

## 📂 File Penting yang Dimodifikasi

| File | Keterangan |
|---|---|
| `resources/views/components/bottom-nav.blade.php` | Floating pill nav + Clean popups + Dual-mode responsive BPS submenu + Mobile sizing override |
| `resources/views/pages/beranda.blade.php` | Hero slider + Mengenal APPSI + Marquee + Video YouTube + Instagram Feed + Teks resmi appsi.or.id |
| `resources/views/pages/berita.blade.php` | Filter kategori dinamis + Grid 22 artikel resmi APPSI |
| `resources/views/pages/dewan-penasehat.blade.php` | 9 Tokoh Gubernur Penasehat + 5 butir peran strategis resmi |
| `resources/views/pages/pustaka.blade.php` | 47 Dokumen resmi PDF multi-halaman + 3D Flipbook DFlip reader |
| `resources/views/admin/pengaturan.blade.php` | Full-width 2-column website settings layout |
| `resources/views/admin/berita/form.blade.php` | Full-width 2-column editorial CMS news form |
| `resources/views/admin/pengurus/form.blade.php` | Full-width 2-column leadership member form |
| `resources/views/admin/pustaka/form.blade.php` | Full-width 2-column document upload form |
| `resources/views/admin/provinsi/form.blade.php` | Full-width 2-column province governor & logo form |
| `.tall-stack-claude-system/scrapers/scrape_berita.php` | Auto-sync 22 artikel resmi + kategori WP REST API |
| `database/seeders/AdminSeeder.php` | Kredensial default admin (`admin@appsi.or.id` / `password`) |

---

## 📌 Catatan & Status Navigasi
- **Struktur Navigasi Utama**: Selaras 100% dengan portal `appsi.or.id` (**Beranda · Tentang APPSI · Pustaka · Berita · Kontak**).
- **Menu Provinsi & Peta Interaktif**: Ditiadakan dari navigasi utama. Representasi 38 Pemerintah Provinsi ditampilkan melalui *Marquee Slider* otomatis di halaman Beranda.

