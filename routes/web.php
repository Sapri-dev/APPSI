<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\PengurusController;
use App\Http\Controllers\ProvinsiController;
use App\Http\Controllers\PustakaController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BeritaController as AdminBeritaController;
use App\Http\Controllers\Admin\PengurusController as AdminPengurusController;
use App\Http\Controllers\Admin\PustakaController as AdminPustakaController;
use App\Http\Controllers\Admin\ProvinsiController as AdminProvinsiController;
use App\Http\Controllers\Admin\PengaturanController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\UserController;

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
Route::get('/admin/login', [AuthController::class, 'loginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

// Panel Admin (dilindungi middleware)
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Berita CRUD
    Route::get('/berita', [AdminBeritaController::class, 'index'])->name('berita.index');
    Route::get('/berita/create', [AdminBeritaController::class, 'create'])->name('berita.create');
    Route::post('/berita', [AdminBeritaController::class, 'store'])->name('berita.store');
    Route::get('/berita/{id}/edit', [AdminBeritaController::class, 'edit'])->name('berita.edit');
    Route::put('/berita/{id}', [AdminBeritaController::class, 'update'])->name('berita.update');
    Route::delete('/berita/{id}', [AdminBeritaController::class, 'destroy'])->name('berita.destroy');
    Route::patch('/berita/{id}/toggle', [AdminBeritaController::class, 'toggle'])->name('berita.toggle');
    Route::post('/berita/kategori', [AdminBeritaController::class, 'kategoriStore'])->name('berita.kategori.store');
    Route::post('/berita/kategori/rename', [AdminBeritaController::class, 'kategoriRename'])->name('berita.kategori.rename');
    Route::post('/berita/kategori/delete', [AdminBeritaController::class, 'kategoriDelete'])->name('berita.kategori.delete');

    // Pengurus CRUD
    Route::get('/pengurus', [AdminPengurusController::class, 'index'])->name('pengurus.index');
    Route::get('/pengurus/create', [AdminPengurusController::class, 'create'])->name('pengurus.create');
    Route::post('/pengurus', [AdminPengurusController::class, 'store'])->name('pengurus.store');
    Route::post('/pengurus/reorder', [AdminPengurusController::class, 'reorder'])->name('pengurus.reorder');
    Route::get('/pengurus/{id}/edit', [AdminPengurusController::class, 'edit'])->name('pengurus.edit');
    Route::put('/pengurus/{id}', [AdminPengurusController::class, 'update'])->name('pengurus.update');
    Route::delete('/pengurus/{id}', [AdminPengurusController::class, 'destroy'])->name('pengurus.destroy');
    Route::patch('/pengurus/{id}/toggle', [AdminPengurusController::class, 'toggle'])->name('pengurus.toggle');

    // Pustaka CRUD
    Route::get('/pustaka', [AdminPustakaController::class, 'index'])->name('pustaka.index');
    Route::get('/pustaka/create', [AdminPustakaController::class, 'create'])->name('pustaka.create');
    Route::post('/pustaka', [AdminPustakaController::class, 'store'])->name('pustaka.store');
    Route::get('/pustaka/{id}/edit', [AdminPustakaController::class, 'edit'])->name('pustaka.edit');
    Route::put('/pustaka/{id}', [AdminPustakaController::class, 'update'])->name('pustaka.update');
    Route::delete('/pustaka/{id}', [AdminPustakaController::class, 'destroy'])->name('pustaka.destroy');
    Route::post('/pustaka/kategori', [AdminPustakaController::class, 'kategoriStore'])->name('pustaka.kategori.store');
    Route::post('/pustaka/kategori/rename', [AdminPustakaController::class, 'kategoriRename'])->name('pustaka.kategori.rename');
    Route::post('/pustaka/kategori/delete', [AdminPustakaController::class, 'kategoriDelete'])->name('pustaka.kategori.delete');

    // Provinsi CRUD
    Route::get('/provinsi', [AdminProvinsiController::class, 'index'])->name('provinsi.index');
    Route::get('/provinsi/create', [AdminProvinsiController::class, 'create'])->name('provinsi.create');
    Route::post('/provinsi', [AdminProvinsiController::class, 'store'])->name('provinsi.store');
    Route::get('/provinsi/{id}/edit', [AdminProvinsiController::class, 'edit'])->name('provinsi.edit');
    Route::put('/provinsi/{id}', [AdminProvinsiController::class, 'update'])->name('provinsi.update');
    Route::delete('/provinsi/{id}', [AdminProvinsiController::class, 'destroy'])->name('provinsi.destroy');

    // Profil Saya & Ubah Password
    Route::get('/profil', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');

    // Manajemen User / Staf Admin
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    // Pengaturan Khusus Beranda
    Route::get('/pengaturan-beranda', [PengaturanController::class, 'berandaSettingsIndex'])->name('pengaturan.beranda');
    Route::post('/pengaturan-beranda', [PengaturanController::class, 'berandaSettingsUpdate'])->name('pengaturan.beranda.update');

    // Pengaturan Website
    Route::get('/pengaturan', [PengaturanController::class, 'pengaturanIndex'])->name('pengaturan.index');
    Route::post('/pengaturan', [PengaturanController::class, 'pengaturanUpdate'])->name('pengaturan.update');

    // Instagram — Refresh Cache Manual
    Route::post('/instagram/refresh', [PengaturanController::class, 'instagramRefresh'])->name('instagram.refresh');
});
