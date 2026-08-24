<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Pengaturan;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $kategoriAktif = $request->input('kategori');
        $cari = $request->input('cari');

        $query = Berita::published();

        if ($kategoriAktif && $kategoriAktif !== 'semua') {
            $query->where('kategori', $kategoriAktif);
        }

        if ($cari) {
            $query->where(function ($q) use ($cari) {
                $q->where('judul', 'like', "%{$cari}%")
                  ->orWhere('konten', 'like', "%{$cari}%")
                  ->orWhere('ringkasan', 'like', "%{$cari}%");
            });
        }

        $berita = $query->latest('tanggal_publikasi')->paginate(9)->withQueryString();
        $sorotan = Berita::published()->latest('tanggal_publikasi')->first();
        $daftarKategori = Berita::published()->pluck('kategori')->unique()->filter()->values();
        $pengaturan = $this->getPengaturan();

        return view('pages.berita', compact('berita', 'sorotan', 'kategoriAktif', 'daftarKategori', 'cari', 'pengaturan'));
    }

    public function show(string $slug)
    {
        $artikel = Berita::where('slug', $slug)->where('is_published', true)->firstOrFail();
        $artikel->incrementViews();

        $terkait = Berita::published()
            ->where('id', '!=', $artikel->id)
            ->take(3)
            ->get();

        $pengaturan = $this->getPengaturan();

        return view('pages.berita-detail', compact('artikel', 'terkait', 'pengaturan'));
    }

    private function getPengaturan(): array
    {
        return [
            'nama' => Pengaturan::get('nama_organisasi', 'APPSI'),
        ];
    }
}
