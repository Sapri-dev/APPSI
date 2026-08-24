# Scraper Suite — APPSI Synchronization Tools

Direktori ini berisi kumpulan skrip mandiri (PHP CLI) untuk mengambil (*scraping*) dan mensinkronkan data resmi dari portal **[https://appsi.or.id/](https://appsi.or.id/)** ke database lokal APPSI beserta pengunduhan berkas media (foto pengurus, lambang daerah, gambar berita).

---

## 📂 Daftar Berkas Scraper

| Berkas | Fungsi Utama | Target Data & Berkas |
|---|---|---|
| [`scrape_pengurus.php`](scrape_pengurus.php) | Mengambil seluruh anggota dewan & sekretariat serta **mengunduh foto asli** | Dewan Pakar, Dewan Pengurus, Dewan Penasehat, Sekretariat (`storage/app/public/pengurus/`) |
| [`scrape_pustaka.php`](scrape_pustaka.php) | Mengambil 37+ publikasi PDF resmi (Data BPS, AD/ART, UU, SK, Rekomendasi) | Dokumen & buku PDF (`storage/app/public/pustaka/`) |
| [`scrape_berita.php`](scrape_berita.php) | Mengambil berita & siaran pers terbaru beserta thumbnail | Artikel, tanggal, ringkasan, gambar thumbnail (`storage/app/public/berita/`) |
| [`scrape_provinsi.php`](scrape_provinsi.php) | Mengambil daftar 38 provinsi & lambang daerah | 38 Provinsi, nama gubernur, lambang (`storage/app/public/lambang/`) |
| [`run_all.php`](run_all.php) | Menu interaktif untuk menjalankan semua scraper sekaligus | CLI Runner |

---

## 🚀 Cara Menjalankan

Buka terminal di root proyek `C:\laragon\www\APPSI\`:

### 1. Jalankan Scraper Pengurus & Unduh Foto
```bash
php .tall-stack-claude-system/scrapers/scrape_pengurus.php
```

### 2. Jalankan Scraper Pustaka & Dokumen Regulasi
```bash
php .tall-stack-claude-system/scrapers/scrape_pustaka.php
```

### 3. Jalankan Scraper Berita & Gambar
```bash
php .tall-stack-claude-system/scrapers/scrape_berita.php
```

### 4. Jalankan Scraper 38 Provinsi
```bash
php .tall-stack-claude-system/scrapers/scrape_provinsi.php
```

### 5. Jalankan Master Runner (Semua Scraper)
```bash
php .tall-stack-claude-system/scrapers/run_all.php
```

---

## ⚙️ Mekanisme Penyimpanan Foto

1. Foto diunduh langsung dari server WordPress `https://appsi.or.id/wp-content/uploads/...`
2. Disimpan ke dua lokasi otomatis:
   - `storage/app/public/pengurus/`
   - `public/storage/pengurus/`
3. Kolom `foto` di tabel database `pengurus` otomatis diisi dengan path relatif `pengurus/{nama_file}.jpg`.
4. Halaman frontend (`/dewan-pakar`, `/dewan-pengurus`, `/dewan-penasehat`, `/sekretariat`) langsung menampilkan foto yang telah terunduh.
