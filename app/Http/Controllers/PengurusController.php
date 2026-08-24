<?php

namespace App\Http\Controllers;

use App\Models\Pengurus;

class PengurusController extends Controller
{
    public function pengurus()
    {
        $anggota = Pengurus::pengurus()->get();
        return view('pages.dewan-pengurus', compact('anggota'));
    }

    public function penasehat()
    {
        $anggota = Pengurus::penasehat()->get();
        return view('pages.dewan-penasehat', compact('anggota'));
    }

    public function pakar()
    {
        $anggota = Pengurus::pakar()->get();
        return view('pages.dewan-pakar', compact('anggota'));
    }

    public function sekretariat()
    {
        $anggota = Pengurus::sekretariat()->get();
        return view('pages.sekretariat', compact('anggota'));
    }
}
