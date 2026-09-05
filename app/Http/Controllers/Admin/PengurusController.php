<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengurus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengurusController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengurus::query();

        $jenisAktif = $request->input('jenis');
        if ($jenisAktif && in_array($jenisAktif, ['pengurus', 'penasehat', 'pakar', 'sekretariat'])) {
            $query->where('jenis', $jenisAktif);
        }

        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where(function ($q) use ($cari) {
                $q->where('nama', 'like', "%{$cari}%")
                  ->orWhere('jabatan', 'like', "%{$cari}%")
                  ->orWhere('provinsi', 'like', "%{$cari}%");
            });
        }

        $pengurus = $query->orderBy('jenis')->orderBy('urutan')->paginate(20)->withQueryString();

        // Statistik per jenis dewan
        $counts = [
            'semua'       => Pengurus::count(),
            'pengurus'    => Pengurus::where('jenis', 'pengurus')->count(),
            'penasehat'   => Pengurus::where('jenis', 'penasehat')->count(),
            'pakar'       => Pengurus::where('jenis', 'pakar')->count(),
            'sekretariat' => Pengurus::where('jenis', 'sekretariat')->count(),
        ];

        return view('admin.pengurus.pengurus-index', compact('pengurus', 'counts', 'jenisAktif'));
    }

    public function create()
    {
        return view('admin.pengurus.pengurus-form', ['pengurus' => null]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama'     => 'required|string|max:255',
            'jabatan'  => 'required|string|max:255',
            'jenis'    => 'required|in:pengurus,penasehat,pakar,sekretariat',
            'foto'     => 'nullable|image|max:2048',
            'provinsi' => 'nullable|string|max:100',
            'bio'      => 'nullable|string',
            'urutan'   => 'nullable|integer',
            'periode'  => 'nullable|string|max:20',
            'is_active'=> 'nullable|boolean',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('pengurus', 'public');
        }

        $data['is_active'] = $request->boolean('is_active', true);

        Pengurus::create($data);

        return redirect()->route('admin.pengurus.index')->with('success', 'Data pengurus berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $pengurus = Pengurus::findOrFail($id);
        return view('admin.pengurus.pengurus-form', compact('pengurus'));
    }

    public function update(Request $request, int $id)
    {
        $pengurus = Pengurus::findOrFail($id);

        $data = $request->validate([
            'nama'     => 'required|string|max:255',
            'jabatan'  => 'required|string|max:255',
            'jenis'    => 'required|in:pengurus,penasehat,pakar,sekretariat',
            'foto'     => 'nullable|image|max:2048',
            'provinsi' => 'nullable|string|max:100',
            'bio'      => 'nullable|string',
            'urutan'   => 'nullable|integer',
            'periode'  => 'nullable|string|max:20',
            'is_active'=> 'nullable|boolean',
        ]);

        if ($request->hasFile('foto')) {
            if ($pengurus->foto) Storage::disk('public')->delete($pengurus->foto);
            $data['foto'] = $request->file('foto')->store('pengurus', 'public');
        }

        $data['is_active'] = $request->boolean('is_active', true);
        $pengurus->update($data);

        return redirect()->route('admin.pengurus.index')->with('success', 'Data pengurus berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $pengurus = Pengurus::findOrFail($id);
        if ($pengurus->foto) Storage::disk('public')->delete($pengurus->foto);
        $pengurus->delete();

        return back()->with('success', 'Data pengurus berhasil dihapus.');
    }

    public function toggle(int $id)
    {
        $p = Pengurus::findOrFail($id);
        $p->update(['is_active' => !$p->is_active]);

        return back()->with('success', 'Status keaktifan pengurus berhasil diperbarui.');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*.id' => 'required|integer|exists:pengurus,id',
            'orders.*.urutan' => 'required|integer',
        ]);

        foreach ($request->input('orders') as $item) {
            Pengurus::where('id', $item['id'])->update(['urutan' => $item['urutan']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Urutan pengurus berhasil diperbarui.',
        ]);
    }

    // Aliases for backward compatibility
    public function pengurusIndex(Request $request) { return $this->index($request); }
    public function pengurusCreate() { return $this->create(); }
    public function pengurusStore(Request $request) { return $this->store($request); }
    public function pengurusEdit(int $id) { return $this->edit($id); }
    public function pengurusUpdate(Request $request, int $id) { return $this->update($request, $id); }
    public function pengurusDestroy(int $id) { return $this->destroy($id); }
    public function pengurusToggle(int $id) { return $this->toggle($id); }
    public function pengurusReorder(Request $request) { return $this->reorder($request); }
}
