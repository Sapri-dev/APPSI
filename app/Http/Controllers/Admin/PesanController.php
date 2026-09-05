<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aktivitas;
use App\Models\Pesan;
use Illuminate\Http\Request;

class PesanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pesan::latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pesans = $query->paginate(20)->withQueryString();
        $totalBaru = Pesan::baru()->count();

        return view('admin.pesan.pesan-index', compact('pesans', 'totalBaru'));
    }

    public function show(Pesan $pesan)
    {
        $pesan->markAsDibaca();
        return view('admin.pesan.pesan-show', compact('pesan'));
    }

    public function destroy(Pesan $pesan)
    {
        $nama = $pesan->nama;
        $pesan->delete();

        Aktivitas::log('hapus', 'pesan', "Menghapus pesan dari {$nama}.");

        return redirect()->route('admin.pesan.index')->with('success', "Pesan dari {$nama} berhasil dihapus.");
    }

    public function destroyBulk(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!empty($ids)) {
            Pesan::whereIn('id', $ids)->delete();
            Aktivitas::log('hapus', 'pesan', 'Menghapus ' . count($ids) . ' pesan sekaligus.');
        }
        return back()->with('success', count($ids) . ' pesan berhasil dihapus.');
    }
}
