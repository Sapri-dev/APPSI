<?php

namespace App\Http\Controllers;

use App\Models\Provinsi;
use Illuminate\Support\Str;

class ProvinsiController extends Controller
{
    public function index()
    {
        $provinsi = Provinsi::ordered()->get();
        $perPulau = $provinsi->groupBy('pulau');

        // Data untuk peta JavaScript — disiapkan di controller agar @json() tetap sederhana
        $provinsiJson = $provinsi->map(function ($p) {
            return [
                'nama'     => $p->nama,
                'gubernur' => $p->gubernur,
                'ibu_kota' => $p->ibu_kota,
                'pulau'    => $p->pulau,
                'lambang'  => $p->lambang_url,
                'slug'     => Str::slug($p->nama),
            ];
        })->values();

        return view('pages.provinsi', compact('provinsi', 'perPulau', 'provinsiJson'));
    }
}
