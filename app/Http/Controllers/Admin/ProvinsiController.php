<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProvinsiController extends Controller
{
    public function index(Request $request)
    {
        $query = Provinsi::query();

        // Search
        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where(function ($q) use ($cari) {
                $q->where('nama', 'like', "%{$cari}%")
                  ->orWhere('gubernur', 'like', "%{$cari}%")
                  ->orWhere('ibu_kota', 'like', "%{$cari}%");
            });
        }

        // Filter Pulau
        if ($request->filled('pulau') && $request->pulau !== 'semua') {
            $query->where('pulau', $request->pulau);
        }

        $query->orderBy('urutan', 'asc')->orderBy('nama', 'asc');

        $perPage = $request->input('perPage', 10);
        if ($perPage === 'all') {
            $provinsi = $query->get();
            $isPaginated = false;
        } else {
            $perPage = in_array((int)$perPage, [10, 25, 38]) ? (int)$perPage : 10;
            $provinsi = $query->paginate($perPage)->withQueryString();
            $isPaginated = true;
        }

        $pulauList = Provinsi::select('pulau')->whereNotNull('pulau')->where('pulau', '!=', '')->distinct()->pluck('pulau');

        return view('admin.provinsi.provinsi-index', compact('provinsi', 'isPaginated', 'perPage', 'pulauList'));
    }

    public function create()
    {
        return view('admin.provinsi.provinsi-form', ['provinsi' => null]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama'     => 'required|string|max:255',
            'ibu_kota' => 'nullable|string|max:255',
            'gubernur' => 'nullable|string|max:255',
            'pulau'    => 'nullable|string|max:100',
            'urutan'   => 'nullable|integer|min:1',
            'lambang'  => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('lambang')) {
            $data['lambang'] = $request->file('lambang')->store('provinsi', 'public');
        }

        if (empty($data['urutan'])) {
            $data['urutan'] = (Provinsi::max('urutan') ?? 0) + 1;
        }

        Provinsi::create($data);

        return redirect()->route('admin.provinsi.index')->with('success', 'Provinsi baru berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $provinsi = Provinsi::findOrFail($id);
        return view('admin.provinsi.provinsi-form', compact('provinsi'));
    }

    public function update(Request $request, int $id)
    {
        $provinsi = Provinsi::findOrFail($id);

        $data = $request->validate([
            'nama'     => 'required|string|max:255',
            'ibu_kota' => 'nullable|string|max:255',
            'gubernur' => 'nullable|string|max:255',
            'pulau'    => 'nullable|string|max:100',
            'urutan'   => 'nullable|integer|min:1',
            'lambang'  => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('lambang')) {
            if ($provinsi->lambang) Storage::disk('public')->delete($provinsi->lambang);
            $data['lambang'] = $request->file('lambang')->store('provinsi', 'public');
        }

        $provinsi->update($data);

        return redirect()->route('admin.provinsi.index')->with('success', 'Data provinsi berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $provinsi = Provinsi::findOrFail($id);
        if ($provinsi->lambang) Storage::disk('public')->delete($provinsi->lambang);
        $provinsi->delete();

        return back()->with('success', 'Data provinsi berhasil dihapus.');
    }

    // Aliases for backward compatibility
    public function provinsiIndex(Request $request) { return $this->index($request); }
    public function provinsiCreate() { return $this->create(); }
    public function provinsiStore(Request $request) { return $this->store($request); }
    public function provinsiEdit(int $id) { return $this->edit($id); }
    public function provinsiUpdate(Request $request, int $id) { return $this->update($request, $id); }
    public function provinsiDestroy(int $id) { return $this->destroy($id); }
}
