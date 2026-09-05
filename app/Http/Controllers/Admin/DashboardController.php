<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aktivitas;
use App\Models\Berita;
use App\Models\Pengurus;
use App\Models\Provinsi;
use App\Models\Pustaka;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'berita'   => Berita::count(),
            'pengurus' => Pengurus::count(),
            'provinsi' => Provinsi::count(),
            'pustaka'  => Pustaka::count(),
        ];
        $beritaTerbaru = Berita::latest()->take(5)->get();
        $recentAktivitas = Aktivitas::with('user')->latest()->take(8)->get();

        return view('admin.dashboard', compact('stats', 'beritaTerbaru', 'recentAktivitas'));
    }

    // Alias for dashboard route
    public function dashboard()
    {
        return $this->index();
    }

    public function aktivitasIndex(Request $request)
    {
        $query = Aktivitas::with('user')->latest();

        if ($request->filled('modul')) {
            $query->where('module', $request->modul);
        }

        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where(function ($q) use ($cari) {
                $q->where('description', 'like', "%{$cari}%")
                  ->orWhere('user_name', 'like', "%{$cari}%");
            });
        }

        $aktivitas = $query->paginate(20)->withQueryString();

        return view('admin.aktivitas.aktivitas-index', compact('aktivitas'));
    }
}
