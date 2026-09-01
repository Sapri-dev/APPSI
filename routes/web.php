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
    Route::post('/berita/kategori', [AdminController::class, 'beritaKategoriStore'])->name('berita.kategori.store');
    Route::post('/berita/kategori/rename', [AdminController::class, 'beritaKategoriRename'])->name('berita.kategori.rename');
    Route::post('/berita/kategori/delete', [AdminController::class, 'beritaKategoriDelete'])->name('berita.kategori.delete');

    // Pengurus CRUD
    Route::get('/pengurus', [AdminController::class, 'pengurusIndex'])->name('pengurus.index');
    Route::get('/pengurus/create', [AdminController::class, 'pengurusCreate'])->name('pengurus.create');
    Route::post('/pengurus', [AdminController::class, 'pengurusStore'])->name('pengurus.store');
    Route::post('/pengurus/reorder', [AdminController::class, 'pengurusReorder'])->name('pengurus.reorder');
    Route::get('/pengurus/{id}/edit', [AdminController::class, 'pengurusEdit'])->name('pengurus.edit');
    Route::put('/pengurus/{id}', [AdminController::class, 'pengurusUpdate'])->name('pengurus.update');
    Route::delete('/pengurus/{id}', [AdminController::class, 'pengurusDestroy'])->name('pengurus.destroy');
    Route::patch('/pengurus/{id}/toggle', [AdminController::class, 'pengurusToggle'])->name('pengurus.toggle');

    // Pustaka CRUD
    Route::get('/pustaka', [AdminController::class, 'pustakaIndex'])->name('pustaka.index');
    Route::get('/pustaka/create', [AdminController::class, 'pustakaCreate'])->name('pustaka.create');
    Route::post('/pustaka', [AdminController::class, 'pustakaStore'])->name('pustaka.store');
    Route::get('/pustaka/{id}/edit', [AdminController::class, 'pustakaEdit'])->name('pustaka.edit');
    Route::put('/pustaka/{id}', [AdminController::class, 'pustakaUpdate'])->name('pustaka.update');
    Route::delete('/pustaka/{id}', [AdminController::class, 'pustakaDestroy'])->name('pustaka.destroy');
    Route::post('/pustaka/kategori', [AdminController::class, 'pustakaKategoriStore'])->name('pustaka.kategori.store');
    Route::post('/pustaka/kategori/rename', [AdminController::class, 'pustakaKategoriRename'])->name('pustaka.kategori.rename');
    Route::post('/pustaka/kategori/delete', [AdminController::class, 'pustakaKategoriDelete'])->name('pustaka.kategori.delete');

    // Provinsi CRUD
    Route::get('/provinsi', [AdminController::class, 'provinsiIndex'])->name('provinsi.index');
    Route::get('/provinsi/create', [AdminController::class, 'provinsiCreate'])->name('provinsi.create');
    Route::post('/provinsi', [AdminController::class, 'provinsiStore'])->name('provinsi.store');
    Route::get('/provinsi/{id}/edit', [AdminController::class, 'provinsiEdit'])->name('provinsi.edit');
    Route::put('/provinsi/{id}', [AdminController::class, 'provinsiUpdate'])->name('provinsi.update');
    Route::delete('/provinsi/{id}', [AdminController::class, 'provinsiDestroy'])->name('provinsi.destroy');

    // Profil Saya & Ubah Password
    Route::get('/profil', [AdminController::class, 'profileIndex'])->name('profile.index');
    Route::put('/profil', [AdminController::class, 'profileUpdate'])->name('profile.update');

    // Manajemen User / Staf Admin
    Route::get('/users', [AdminController::class, 'usersIndex'])->name('users.index');
    Route::get('/users/create', [AdminController::class, 'usersCreate'])->name('users.create');
    Route::post('/users', [AdminController::class, 'usersStore'])->name('users.store');
    Route::get('/users/{id}/edit', [AdminController::class, 'usersEdit'])->name('users.edit');
    Route::put('/users/{id}', [AdminController::class, 'usersUpdate'])->name('users.update');
    Route::delete('/users/{id}', [AdminController::class, 'usersDestroy'])->name('users.destroy');

    // Pengaturan Website
    Route::get('/pengaturan', [AdminController::class, 'pengaturanIndex'])->name('pengaturan.index');
    Route::post('/pengaturan', [AdminController::class, 'pengaturanUpdate'])->name('pengaturan.update');
});
