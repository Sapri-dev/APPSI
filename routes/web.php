<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.beranda');
})->name('home');

Route::get('/artikel', function () {
    return view('pages.artikel');
})->name('artikel');

Route::get('/berita', function () {
    return view('pages.berita');
})->name('berita');

Route::get('/hubungi', function () {
    return view('pages.hubungi');
})->name('hubungi');

Route::get('/sekretariat', function () {
    return view('pages.sekretariat');
})->name('sekretariat');

Route::get('/dewan-penasehat', function () {
    return view('pages.dewan-penasehat');
})->name('dewan-penasehat');

Route::get('/dewan-pengurus', function () {
    return view('pages.dewan-pengurus');
})->name('dewan-pengurus');
