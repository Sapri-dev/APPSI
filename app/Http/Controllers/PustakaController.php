<?php

namespace App\Http\Controllers;

use App\Models\Pustaka;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PustakaController extends Controller
{
    // Label mapping selaras dengan struktur appsi.or.id
    const KATEGORI_LABEL = [
        'semua'        => 'Semua Pustaka',
        'uu'           => 'Undang-Undang',
        'adart'        => 'AD/ART',
        'rekomendasi'  => 'Rekomendasi',
        'sk'           => 'SK',
        'berita_acara' => 'Berita Acara',
        'data_bps'     => 'Data BPS',
    ];

    public function index(Request $request, string $kategori = 'semua')
    {
        $saved = \App\Models\Pengaturan::get('kategori_pustaka_list');
        $savedList = $saved ? json_decode($saved, true) : [];
        if (!is_array($savedList)) $savedList = [];

        // Kategori yang memiliki dokumen terpublikasi
        $kategoriDiDb = Pustaka::published()->pluck('kategori')->filter()->unique()->toArray();
        $semuaKategori = array_values(array_unique(array_merge(['uu', 'adart', 'rekomendasi', 'sk', 'berita_acara', 'data_bps'], $savedList, $kategoriDiDb)));

        $kategoriLabel = ['semua' => 'Semua Pustaka'];
        foreach ($semuaKategori as $katKey) {
            $lbl = match($katKey) {
                'uu'           => 'Undang-Undang',
                'adart'        => 'AD/ART',
                'rekomendasi'  => 'Rekomendasi',
                'sk'           => 'SK',
                'berita_acara' => 'Berita Acara',
                'data_bps'     => 'Data BPS',
                default        => $katKey,
            };
            $kategoriLabel[$katKey] = $lbl;
        }

        $kategoriValid = array_keys($kategoriLabel);
        if (!in_array($kategori, $kategoriValid)) {
            $kategori = 'semua';
        }

        $search = $request->query('q');
        $tahun  = $request->query('tahun');

        $query = Pustaka::published();

        if ($kategori !== 'semua') {
            $query->where('kategori', $kategori);
        }

        if (!empty($tahun)) {
            $query->where('tahun', $tahun);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%")
                  ->orWhere('tahun', 'like', "%{$search}%");
            });
        }

        $dokumen = $query->get();

        // Hitung jumlah per kategori untuk badge tab (hanya tampilkan yang ber-dokumen / ada di db)
        $counts = [];
        foreach ($kategoriLabel as $key => $lbl) {
            $counts[$key] = $key === 'semua'
                ? Pustaka::where('is_published', true)->count()
                : Pustaka::where('is_published', true)->where('kategori', $key)->count();
        }

        // Daftar tahun untuk filter dokumen (scoped per kategori aktif jika ada)
        $tahunQuery = Pustaka::where('is_published', true)
            ->whereNotNull('tahun')
            ->where('tahun', '!=', '');

        if ($kategori !== 'semua') {
            $tahunQuery->where('kategori', $kategori);
        }

        $tahunList = $tahunQuery
            ->reorder('tahun', 'desc')
            ->select('tahun')
            ->distinct()
            ->pluck('tahun');

        $aktifLabel = $kategoriLabel[$kategori] ?? 'Dokumen';

        return view('pages.pustaka', compact('dokumen', 'kategori', 'kategoriLabel', 'aktifLabel', 'search', 'tahun', 'counts', 'tahunList'));
    }

    public function download($id)
    {
        $doc = Pustaka::findOrFail($id);
        $doc->increment('unduhan');

        $filename = Str::slug($doc->judul) . '.pdf';

        if ($doc->file && Storage::disk('public')->exists($doc->file)) {
            $filePath = Storage::disk('public')->path($doc->file);
            $fileSize = filesize($filePath);

            return response()->streamDownload(function () use ($filePath) {
                $handle = fopen($filePath, 'rb');
                while (!feof($handle)) {
                    echo fread($handle, 8192);
                    ob_flush();
                    flush();
                }
                fclose($handle);
            }, $filename, [
                'Content-Type'              => 'application/pdf',
                'Content-Length'            => $fileSize,
                'Content-Disposition'       => 'attachment; filename="' . $filename . '"',
                'Content-Transfer-Encoding' => 'binary',
                'Pragma'                    => 'no-cache',
                'Cache-Control'             => 'must-revalidate, post-check=0, pre-check=0',
                'Expires'                   => '0',
            ]);
        }

        if ($doc->file_url) {
            return redirect()->away($doc->file_url);
        }

        abort(404, 'Berkas dokumen tidak ditemukan');
    }
}
