<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\PengurusController;
use App\Http\Controllers\ProvinsiController;
use App\Http\Controllers\PustakaController;
use App\Http\Controllers\AdminController;

// ─────────────────────────────────────────────
// FRONTEND — Halaman Publik
// ─────────────────────────────────────────────

Route::get('/', [PageController::class, 'beranda'])->name('home');

// Tentang APPSI
Route::get('/sejarah', [PageController::class, 'sejarah'])->name('sejarah');
Route::redirect('/visi-misi', '/#visi-misi')->name('visi-misi');
Route::get('/hubungi', [PageController::class, 'hubungi'])->name('hubungi');

// Dewan
Route::get('/dewan-pengurus', [PengurusController::class, 'pengurus'])->name('dewan-pengurus');
Route::get('/dewan-penasehat', [PengurusController::class, 'penasehat'])->name('dewan-penasehat');
Route::get('/dewan-pakar', [PengurusController::class, 'pakar'])->name('dewan-pakar');
Route::get('/sekretariat', [PengurusController::class, 'sekretariat'])->name('sekretariat');

// Berita & Artikel
Route::get('/berita', [BeritaController::class, 'index'])->name('berita');
Route::get('/berita/{slug}', [BeritaController::class, 'show'])->name('artikel');

// Provinsi
Route::get('/provinsi', [ProvinsiController::class, 'index'])->name('provinsi');

// Pustaka
Route::get('/pustaka/unduh/{id}', [PustakaController::class, 'download'])->name('pustaka.download');
Route::get('/pustaka/{kategori?}', [PustakaController::class, 'index'])->name('pustaka');

// ─────────────────────────────────────────────
// ADMIN — Panel Administrasi
// ─────────────────────────────────────────────

// Login/Logout (tanpa middleware)
Route::get('/admin/login', [AdminController::class, 'loginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

// Panel Admin (dilindungi middleware)
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // Berita CRUD
    Route::get('/berita', [AdminController::class, 'beritaIndex'])->name('berita.index');
    Route::get('/berita/create', [AdminController::class, 'beritaCreate'])->name('berita.create');
    Route::post('/berita', [AdminController::class, 'beritaStore'])->name('berita.store');
    Route::get('/berita/{id}/edit', [AdminController::class, 'beritaEdit'])->name('berita.edit');
    Route::put('/berita/{id}', [AdminController::class, 'beritaUpdate'])->name('berita.update');
    Route::delete('/berita/{id}', [AdminController::class, 'beritaDestroy'])->name('berita.destroy');
    Route::patch('/berita/{id}/toggle', [AdminController::class, 'beritaToggle'])->name('berita.toggle');

    // Pengurus CRUD
    Route::get('/pengurus', [AdminController::class, 'pengurusIndex'])->name('pengurus.index');
    Route::get('/pengurus/create', [AdminController::class, 'pengurusCreate'])->name('pengurus.create');
    Route::post('/pengurus', [AdminController::class, 'pengurusStore'])->name('pengurus.store');
    Route::get('/pengurus/{id}/edit', [AdminController::class, 'pengurusEdit'])->name('pengurus.edit');
    Route::put('/pengurus/{id}', [AdminController::class, 'pengurusUpdate'])->name('pengurus.update');
    Route::delete('/pengurus/{id}', [AdminController::class, 'pengurusDestroy'])->name('pengurus.destroy');

    // Pustaka CRUD
    Route::get('/pustaka', [AdminController::class, 'pustakaIndex'])->name('pustaka.index');
    Route::get('/pustaka/create', [AdminController::class, 'pustakaCreate'])->name('pustaka.create');
    Route::post('/pustaka', [AdminController::class, 'pustakaStore'])->name('pustaka.store');
    Route::get('/pustaka/{id}/edit', [AdminController::class, 'pustakaEdit'])->name('pustaka.edit');
    Route::put('/pustaka/{id}', [AdminController::class, 'pustakaUpdate'])->name('pustaka.update');
    Route::delete('/pustaka/{id}', [AdminController::class, 'pustakaDestroy'])->name('pustaka.destroy');

    // Provinsi (hanya edit)
    Route::get('/provinsi', [AdminController::class, 'provinsiIndex'])->name('provinsi.index');
    Route::get('/provinsi/{id}/edit', [AdminController::class, 'provinsiEdit'])->name('provinsi.edit');
    Route::put('/provinsi/{id}', [AdminController::class, 'provinsiUpdate'])->name('provinsi.update');

    // Pengaturan Website
    Route::get('/pengaturan', [AdminController::class, 'pengaturanIndex'])->name('pengaturan.index');
    Route::post('/pengaturan', [AdminController::class, 'pengaturanUpdate'])->name('pengaturan.update');
});
