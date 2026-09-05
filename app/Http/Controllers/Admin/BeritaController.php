<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $query = Berita::query();

        if ($request->filled('kategori') && $request->kategori !== 'semua') {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where(function ($q) use ($cari) {
                $q->where('judul', 'like', "%{$cari}%")
                  ->orWhere('konten', 'like', "%{$cari}%");
            });
        }

        $berita = $query->orderBy('tanggal_publikasi', 'desc')->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
        $daftarKategori = $this->getDaftarKategoriBerita();

        // Statistik penggunaan per kategori
        $kategoriStats = Berita::select('kategori', DB::raw('count(*) as total'))
            ->groupBy('kategori')
            ->pluck('total', 'kategori')
            ->toArray();

        return view('admin.berita.berita-index', compact('berita', 'daftarKategori', 'kategoriStats'));
    }

    public function create()
    {
        $daftarKategori = $this->getDaftarKategoriBerita();
        return view('admin.berita.berita-form', ['berita' => null, 'daftarKategori' => $daftarKategori]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'              => 'required|string|max:255',
            'ringkasan'          => 'nullable|string',
            'konten'             => 'required|string',
            'gambar'             => 'nullable|image|max:2048',
            'kategori'           => 'required|string',
            'kategori_baru'      => 'nullable|string|max:100',
            'tanggal_publikasi'  => 'required|date',
            'is_published'       => 'nullable|boolean',
        ]);

        if ($request->input('kategori') === '__baru__' || $request->filled('kategori_baru')) {
            $kategoriBaru = trim($request->input('kategori_baru'));
            if (!empty($kategoriBaru)) {
                $data['kategori'] = $kategoriBaru;
            }
        }
        unset($data['kategori_baru']);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        $data['slug']         = Str::slug($data['judul']);
        $data['is_published'] = $request->boolean('is_published');

        Berita::create($data);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $berita = Berita::findOrFail($id);
        $daftarKategori = $this->getDaftarKategoriBerita();
        return view('admin.berita.berita-form', compact('berita', 'daftarKategori'));
    }

    public function update(Request $request, int $id)
    {
        $berita = Berita::findOrFail($id);

        $data = $request->validate([
            'judul'              => 'required|string|max:255',
            'ringkasan'          => 'nullable|string',
            'konten'             => 'required|string',
            'gambar'             => 'nullable|image|max:2048',
            'kategori'           => 'required|string',
            'kategori_baru'      => 'nullable|string|max:100',
            'tanggal_publikasi'  => 'required|date',
            'is_published'       => 'nullable|boolean',
        ]);

        if ($request->input('kategori') === '__baru__' || $request->filled('kategori_baru')) {
            $kategoriBaru = trim($request->input('kategori_baru'));
            if (!empty($kategoriBaru)) {
                $data['kategori'] = $kategoriBaru;
            }
        }
        unset($data['kategori_baru']);

        if ($request->hasFile('gambar')) {
            if ($berita->gambar) Storage::disk('public')->delete($berita->gambar);
            $data['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        $data['slug']         = Str::slug($data['judul']);
        $data['is_published'] = $request->boolean('is_published');

        $berita->update($data);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $berita = Berita::findOrFail($id);
        if ($berita->gambar) Storage::disk('public')->delete($berita->gambar);
        $berita->delete();

        return back()->with('success', 'Berita berhasil dihapus.');
    }

    public function toggle(int $id)
    {
        $berita = Berita::findOrFail($id);
        $berita->update(['is_published' => !$berita->is_published]);

        return back()->with('success', 'Status berita diperbarui.');
    }

    public function kategoriStore(Request $request)
    {
        $request->validate([
            'kategori' => 'required|string|max:100',
        ]);

        $nama = trim($request->input('kategori'));
        if (!empty($nama)) {
            $list = $this->getDaftarKategoriBerita();
            if (!in_array($nama, $list)) {
                $list[] = $nama;
                Pengaturan::set('kategori_berita_list', json_encode(array_values($list)));
            }

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => "Kategori '{$nama}' berhasil ditambahkan.",
                    'categories' => $this->getDaftarKategoriBerita(),
                    'stats' => $this->getKategoriStats(),
                ]);
            }

            return back()->with('success', "Kategori '{$nama}' berhasil ditambahkan.");
        }

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => false, 'message' => 'Nama kategori tidak boleh kosong.'], 422);
        }

        return back()->with('error', 'Nama kategori tidak boleh kosong.');
    }

    public function kategoriRename(Request $request)
    {
        $request->validate([
            'kategori_lama' => 'required|string',
            'kategori_baru' => 'required|string|max:100',
        ]);

        $lama = trim($request->input('kategori_lama'));
        $baru = trim($request->input('kategori_baru'));

        if (!empty($lama) && !empty($baru) && $lama !== $baru) {
            $updated = Berita::where('kategori', $lama)->update(['kategori' => $baru]);

            // Sync di list kategori pengaturan
            $list = $this->getDaftarKategoriBerita();
            $list = array_map(fn($item) => $item === $lama ? $baru : $item, $list);
            if (!in_array($baru, $list)) {
                $list[] = $baru;
            }
            Pengaturan::set('kategori_berita_list', json_encode(array_values(array_unique($list))));

            $msg = "Kategori '{$lama}' berhasil diubah menjadi '{$baru}' ({$updated} artikel diperbarui).";

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $msg,
                    'categories' => $this->getDaftarKategoriBerita(),
                    'stats' => $this->getKategoriStats(),
                ]);
            }

            return back()->with('success', $msg);
        }

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => false, 'message' => 'Tidak ada perubahan pada nama kategori.']);
        }

        return back()->with('info', 'Tidak ada perubahan pada nama kategori.');
    }

    public function kategoriDelete(Request $request)
    {
        $request->validate([
            'kategori' => 'required|string',
            'alihkan_ke' => 'nullable|string',
        ]);

        $kategori = trim($request->input('kategori'));
        $alihkanKe = trim($request->input('alihkan_ke', 'Berita')) ?: 'Berita';

        $count = Berita::where('kategori', $kategori)->count();
        if ($count > 0) {
            Berita::where('kategori', $kategori)->update(['kategori' => $alihkanKe]);
        }

        // Hapus dari daftar kategori tersimpan
        $list = $this->getDaftarKategoriBerita();
        $list = array_values(array_filter($list, fn($item) => $item !== $kategori));
        Pengaturan::set('kategori_berita_list', json_encode($list));

        $msg = $count > 0 
            ? "Kategori '{$kategori}' berhasil dihapus ({$count} artikel dialihkan ke '{$alihkanKe}')."
            : "Kategori '{$kategori}' berhasil dihapus.";

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $msg,
                'categories' => $this->getDaftarKategoriBerita(),
                'stats' => $this->getKategoriStats(),
            ]);
        }

        return back()->with('success', $msg);
    }

    private function getDaftarKategoriBerita(): array
    {
        $saved = Pengaturan::get('kategori_berita_list');
        if ($saved !== null) {
            $list = json_decode($saved, true);
            if (is_array($list)) {
                $dbKategori = Berita::pluck('kategori')->filter()->unique()->toArray();
                return array_values(array_unique(array_merge($list, $dbKategori)));
            }
        }

        $defaultKategori = ['Berita', 'Munas', 'Rapat Kerja Nasional', 'Seminar Nasional', 'Kegiatan', 'Siaran Pers', 'Umum'];
        $dbKategori      = Berita::pluck('kategori')->filter()->unique()->toArray();
        $initial         = array_values(array_unique(array_merge($defaultKategori, $dbKategori)));
        Pengaturan::set('kategori_berita_list', json_encode($initial));

        return $initial;
    }

    private function getKategoriStats(): array
    {
        return Berita::select('kategori', DB::raw('count(*) as total'))
            ->groupBy('kategori')
            ->pluck('total', 'kategori')
            ->toArray();
    }

    // Aliases for compatibility with any legacy calls
    public function beritaIndex(Request $request) { return $this->index($request); }
    public function beritaCreate() { return $this->create(); }
    public function beritaStore(Request $request) { return $this->store($request); }
    public function beritaEdit(int $id) { return $this->edit($id); }
    public function beritaUpdate(Request $request, int $id) { return $this->update($request, $id); }
    public function beritaDestroy(int $id) { return $this->destroy($id); }
    public function beritaToggle(int $id) { return $this->toggle($id); }
    public function beritaKategoriStore(Request $request) { return $this->kategoriStore($request); }
    public function beritaKategoriRename(Request $request) { return $this->kategoriRename($request); }
    public function beritaKategoriDelete(Request $request) { return $this->kategoriDelete($request); }
}
