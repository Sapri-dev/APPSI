# tasks/lessons.md — Database Pelajaran dari Error

> File ini dikelola otomatis oleh Claude setiap kali `/debug` berhasil memecahkan masalah.
> **Jangan hapus entri lama** — ini adalah memori kolektif proyek kita.
> Claude wajib membaca file ini sebelum mengerjakan `/debug`.

---

## Cara Membaca File Ini
- Gunakan **Tag** untuk cari cepat: `#livewire` `#blade` `#alpine` `#query` `#validasi` `#vite` `#auth` `#upload`
- Entri terbaru ada di **paling atas**
- Setiap entri punya status: ✅ Selesai | ⚠️ Perlu Monitor

---

## Entri Pelajaran

---
## [2026-08-24] — DFlip Flipbook Toolbar Icons 404 & PDF Browser Caching
**Status**: ✅ Selesai
**Tag**: #frontend #dflip #pdf #cdn

- **Konteks**: Modal pembaca PDF 3D Flipbook (`pustaka.blade.php`).
- **Gejala**: Tombol-tombol toolbar bawah hanya muncul sebagai kotak kosong tanpa ikon, dan file PDF kadang masih menampilkan versi dummy 1-halaman lama.
- **Penyebab**: 
  1. Paket `@dearhive/dearflip-jquery-flipbook` di jsDelivr menggunakan nama file `themify-icons.min.css` (bukan `themify-icons.css`). File yang salah menyebabkan 404 sehingga font icon tidak dapat dimuat.
  2. Browser menyimpan cache (304 Not Modified) pada URL file `/storage/pustaka/...` saat file di server telah diperbarui.
- **Solusi**:
  1. Hubungkan CDN ke `dflip/css/themify-icons.min.css` dan tentukan `window.dFlipLocation = "https://cdn.jsdelivr.net/npm/@dearhive/dearflip-jquery-flipbook@1.7.3/dflip/";` sebelum script DFlip dijalankan.
  2. Tambahkan timestamp cache buster `?t=` pada pemanggilan `openPdfViewer`.
- **Pencegahan**: Selalu verifikasi status respons HTTP (200 OK) dari file asset CDN pihak ketiga dan sertakan parameter timestamp/versi saat memuat file dinamis yang baru disinkronkan.
---

---

## Template untuk Claude (salin saat menambah entri baru):

```markdown
---
## [YYYY-MM-DD] — [Judul Error Singkat]
**Status**: ✅ Selesai
**Tag**: #[tag1] #[tag2]

- **Konteks**: [Di komponen/fitur/halaman apa error ini terjadi?]
- **Gejala**: [Pesan error atau perilaku yang terlihat oleh user]
- **Penyebab**: [Root cause sebenarnya — bukan hanya gejala]
- **Solusi**:
  ```php/html/js
  [kode solusinya di sini]
  ```
- **Pencegahan**: [Apa yang harus selalu dilakukan/dihindari agar ini tidak terulang?]
---
```

---

## Pola Error Umum TALL Stack (Pre-loaded Knowledge)

### #livewire — Property tidak tersimpan
**Penyebab umum**: Lupa tambahkan nama property ke `$fillable` di Model
**Solusi**: Cek `protected $fillable` di Model terkait

### #livewire — CSRF Token Mismatch  
**Penyebab umum**: Form Livewire tidak dibungkus tag `<form>`
**Solusi**: Selalu bungkus form Livewire dengan `<form wire:submit="...">`

### #query — Data relasi tidak muncul (N+1)
**Penyebab umum**: Tidak menggunakan `with()` saat query
**Solusi**: `Model::with(['relasi1', 'relasi2'])->get()`

### #vite — Asset 404 setelah deploy
**Penyebab umum**: Lupa jalankan `npm run build` atau menggunakan URL hardcode
**Solusi**: Gunakan `@vite(...)` helper dan pastikan `npm run build` dijalankan sebelum deploy

### #alpine — `x-data` tidak reaktif ke Livewire
**Penyebab umum**: Alpine dan Livewire mengelola state terpisah
**Solusi**: Gunakan `$wire.entangle('propertyName')` untuk sinkronisasi
