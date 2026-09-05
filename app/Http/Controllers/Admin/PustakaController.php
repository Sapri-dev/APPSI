<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use App\Models\Pustaka;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PustakaController extends Controller
{
    public function index(Request $request)
    {
        $query = Pustaka::query();

        $kategoriAktif = $request->input('kategori');
        if ($kategoriAktif && $kategoriAktif !== 'semua') {
            $query->where('kategori', $kategoriAktif);
        }

        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where(function ($q) use ($cari) {
                $q->where('judul', 'like', "%{$cari}%")
                  ->orWhere('deskripsi', 'like', "%{$cari}%")
                  ->orWhere('tahun', 'like', "%{$cari}%");
            });
        }

        $pustaka = $query->orderBy('tahun', 'desc')->latest()->paginate(20)->withQueryString();
        $daftarKategori = $this->getDaftarKategoriPustaka();
        $kategoriStats = $this->getKategoriPustakaStats();

        return view('admin.pustaka.pustaka-index', compact('pustaka', 'daftarKategori', 'kategoriStats', 'kategoriAktif'));
    }

    public function create()
    {
        $daftarKategori = $this->getDaftarKategoriPustaka();
        return view('admin.pustaka.pustaka-form', ['pustaka' => null, 'daftarKategori' => $daftarKategori]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'         => 'required|string|max:255',
            'kategori'      => 'required|string',
            'kategori_baru' => 'nullable|string|max:100',
            'tahun'         => 'nullable|integer|min:1900|max:2099',
            'deskripsi'     => 'nullable|string',
            'file'          => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip|max:10240',
            'file_url'      => 'nullable|url',
            'is_published'  => 'nullable|boolean',
        ]);

        if ($request->input('kategori') === '__baru__' || $request->filled('kategori_baru')) {
            $kategoriBaru = trim($request->input('kategori_baru'));
            if (!empty($kategoriBaru)) {
                $data['kategori'] = $kategoriBaru;
            }
        }
        unset($data['kategori_baru']);

        if (!empty($data['kategori'])) {
            $saved = $this->getDaftarKategoriPustaka();
            if (!in_array($data['kategori'], $saved)) {
                $saved[] = $data['kategori'];
                Pengaturan::set('kategori_pustaka_list', json_encode(array_values(array_unique($saved))));
            }
        }

        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('pustaka', 'public');
        }

        $data['is_published'] = $request->boolean('is_published', true);
        Pustaka::create($data);

        return redirect()->route('admin.pustaka.index')->with('success', 'Dokumen berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $pustaka = Pustaka::findOrFail($id);
        $daftarKategori = $this->getDaftarKategoriPustaka();
        return view('admin.pustaka.pustaka-form', compact('pustaka', 'daftarKategori'));
    }

    public function update(Request $request, int $id)
    {
        $pustaka = Pustaka::findOrFail($id);

        $data = $request->validate([
            'judul'         => 'required|string|max:255',
            'kategori'      => 'required|string',
            'kategori_baru' => 'nullable|string|max:100',
            'tahun'         => 'nullable|integer|min:1900|max:2099',
            'deskripsi'     => 'nullable|string',
            'file'          => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip|max:10240',
            'file_url'      => 'nullable|url',
            'is_published'  => 'nullable|boolean',
        ]);

        if ($request->input('kategori') === '__baru__' || $request->filled('kategori_baru')) {
            $kategoriBaru = trim($request->input('kategori_baru'));
            if (!empty($kategoriBaru)) {
                $data['kategori'] = $kategoriBaru;
            }
        }
        unset($data['kategori_baru']);

        if (!empty($data['kategori'])) {
            $saved = $this->getDaftarKategoriPustaka();
            if (!in_array($data['kategori'], $saved)) {
                $saved[] = $data['kategori'];
                Pengaturan::set('kategori_pustaka_list', json_encode(array_values(array_unique($saved))));
            }
        }

        if ($request->hasFile('file')) {
            if ($pustaka->file) Storage::disk('public')->delete($pustaka->file);
            $data['file'] = $request->file('file')->store('pustaka', 'public');
        }

        $data['is_published'] = $request->boolean('is_published', true);
        $pustaka->update($data);

        return redirect()->route('admin.pustaka.index')->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $pustaka = Pustaka::findOrFail($id);
        if ($pustaka->file) Storage::disk('public')->delete($pustaka->file);
        $pustaka->delete();

        return back()->with('success', 'Dokumen berhasil dihapus.');
    }

    public function kategoriStore(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
        ]);

        $nama = trim($request->input('nama'));
        $list = $this->getDaftarKategoriPustaka();

        if (!in_array($nama, $list)) {
            $list[] = $nama;
            Pengaturan::set('kategori_pustaka_list', json_encode(array_values(array_unique($list))));
        }

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Kategori pustaka '{$nama}' berhasil ditambahkan.",
                'categories' => $this->getDaftarKategoriPustaka(),
                'stats' => $this->getKategoriPustakaStats(),
            ]);
        }

        return back()->with('success', "Kategori pustaka '{$nama}' berhasil ditambahkan.");
    }

    public function kategoriRename(Request $request)
    {
        $request->validate([
            'kategori_lama' => 'required|string',
            'kategori_baru' => 'required|string|max:100',
        ]);

        $lama = trim($request->input('kategori_lama'));
        $baru = trim($request->input('kategori_baru'));

        if ($lama !== $baru) {
            $updated = Pustaka::where('kategori', $lama)->update(['kategori' => $baru]);
            $list = $this->getDaftarKategoriPustaka();
            $list = array_map(fn($item) => $item === $lama ? $baru : $item, $list);
            Pengaturan::set('kategori_pustaka_list', json_encode(array_values(array_unique($list))));

            $msg = "Kategori '{$lama}' berhasil diubah menjadi '{$baru}' ({$updated} dokumen diperbarui).";

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $msg,
                    'categories' => $this->getDaftarKategoriPustaka(),
                    'stats' => $this->getKategoriPustakaStats(),
                ]);
            }

            return back()->with('success', $msg);
        }

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => false, 'message' => 'Tidak ada perubahan nama kategori.']);
        }

        return back()->with('info', 'Tidak ada perubahan nama kategori.');
    }

    public function kategoriDelete(Request $request)
    {
        $request->validate([
            'kategori' => 'required|string',
            'alihkan_ke' => 'nullable|string',
        ]);

        $kategori = trim($request->input('kategori'));
        $alihkanKe = trim($request->input('alihkan_ke', 'Lainnya')) ?: 'Lainnya';

        $count = Pustaka::where('kategori', $kategori)->count();
        if ($count > 0) {
            Pustaka::where('kategori', $kategori)->update(['kategori' => $alihkanKe]);
        }

        $list = $this->getDaftarKategoriPustaka();
        $list = array_values(array_filter($list, fn($item) => $item !== $kategori));
        Pengaturan::set('kategori_pustaka_list', json_encode($list));

        $msg = $count > 0 
            ? "Kategori '{$kategori}' berhasil dihapus ({$count} dokumen dialihkan ke '{$alihkanKe}')."
            : "Kategori '{$kategori}' berhasil dihapus.";

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $msg,
                'categories' => $this->getDaftarKategoriPustaka(),
                'stats' => $this->getKategoriPustakaStats(),
            ]);
        }

        return back()->with('success', $msg);
    }

    private function getDaftarKategoriPustaka(): array
    {
        $saved = Pengaturan::get('kategori_pustaka_list');
        if ($saved !== null) {
            $list = json_decode($saved, true);
            if (is_array($list)) {
                $dbKategori = Pustaka::pluck('kategori')->filter()->unique()->toArray();
                return array_values(array_unique(array_merge($list, $dbKategori)));
            }
        }

        $initial = ['uu', 'adart', 'rekomendasi', 'sk', 'berita_acara', 'data_bps'];
        $dbKategori = Pustaka::pluck('kategori')->filter()->unique()->toArray();
        $merged = array_values(array_unique(array_merge($initial, $dbKategori)));
        Pengaturan::set('kategori_pustaka_list', json_encode($merged));

        return $merged;
    }

    private function getKategoriPustakaStats(): array
    {
        return Pustaka::select('kategori', DB::raw('count(*) as total'))
            ->groupBy('kategori')
            ->pluck('total', 'kategori')
            ->toArray();
    }

    // Aliases for backward compatibility
    public function pustakaIndex(Request $request) { return $this->index($request); }
    public function pustakaCreate() { return $this->create(); }
    public function pustakaStore(Request $request) { return $this->store($request); }
    public function pustakaEdit(int $id) { return $this->edit($id); }
    public function pustakaUpdate(Request $request, int $id) { return $this->update($request, $id); }
    public function pustakaDestroy(int $id) { return $this->destroy($id); }
    public function pustakaKategoriStore(Request $request) { return $this->kategoriStore($request); }
    public function pustakaKategoriRename(Request $request) { return $this->kategoriRename($request); }
    public function pustakaKategoriDelete(Request $request) { return $this->kategoriDelete($request); }
}
