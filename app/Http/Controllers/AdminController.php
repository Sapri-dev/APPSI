<?php

namespace App\Http\Controllers;

use App\Models\Aktivitas;
use App\Models\Berita;
use App\Models\Pengaturan;
use App\Models\Pengurus;
use App\Models\Provinsi;
use App\Models\Pustaka;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    // ─── AUTH ─────────────────────────────────────────────────────────

    public function loginForm()
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            if (!Auth::user()->isAdmin()) {
                Auth::logout();
                return back()->withErrors(['email' => 'Akun ini tidak memiliki akses admin.']);
            }
            $request->session()->regenerate();
            Aktivitas::log('login', 'auth', 'Admin berhasil login ke panel kontrol.');
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Aktivitas::log('logout', 'auth', 'Admin keluar dari sistem.');
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }

    // ─── DASHBOARD ───────────────────────────────────────────────────

    public function dashboard()
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

    // ─── BERITA ──────────────────────────────────────────────────────

    public function beritaIndex(Request $request)
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

    public function beritaCreate()
    {
        $daftarKategori = $this->getDaftarKategoriBerita();
        return view('admin.berita.berita-form', ['berita' => null, 'daftarKategori' => $daftarKategori]);
    }

    public function beritaStore(Request $request)
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

    public function beritaEdit(int $id)
    {
        $berita = Berita::findOrFail($id);
        $daftarKategori = $this->getDaftarKategoriBerita();
        return view('admin.berita.berita-form', compact('berita', 'daftarKategori'));
    }

    public function beritaUpdate(Request $request, int $id)
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

    public function beritaKategoriStore(Request $request)
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

    public function beritaKategoriRename(Request $request)
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

    public function beritaKategoriDelete(Request $request)
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

    public function beritaDestroy(int $id)
    {
        $berita = Berita::findOrFail($id);
        if ($berita->gambar) Storage::disk('public')->delete($berita->gambar);
        $berita->delete();

        return back()->with('success', 'Berita berhasil dihapus.');
    }

    public function beritaToggle(int $id)
    {
        $berita = Berita::findOrFail($id);
        $berita->update(['is_published' => !$berita->is_published]);

        return back()->with('success', 'Status berita diperbarui.');
    }

    // ─── PENGURUS ────────────────────────────────────────────────────

    public function pengurusIndex(Request $request)
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

    public function pengurusCreate()
    {
        return view('admin.pengurus.pengurus-form', ['pengurus' => null]);
    }

    public function pengurusStore(Request $request)
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

    public function pengurusEdit(int $id)
    {
        $pengurus = Pengurus::findOrFail($id);
        return view('admin.pengurus.pengurus-form', compact('pengurus'));
    }

    public function pengurusUpdate(Request $request, int $id)
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

    public function pengurusDestroy(int $id)
    {
        $pengurus = Pengurus::findOrFail($id);
        if ($pengurus->foto) Storage::disk('public')->delete($pengurus->foto);
        $pengurus->delete();

        return back()->with('success', 'Data pengurus berhasil dihapus.');
    }

    public function pengurusToggle(int $id)
    {
        $p = Pengurus::findOrFail($id);
        $p->update(['is_active' => !$p->is_active]);

        return back()->with('success', 'Status keaktifan pengurus berhasil diperbarui.');
    }

    public function pengurusReorder(Request $request)
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

    // ─── PUSTAKA ─────────────────────────────────────────────────────

    public function pustakaIndex(Request $request)
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

    public function pustakaCreate()
    {
        $daftarKategori = $this->getDaftarKategoriPustaka();
        return view('admin.pustaka.pustaka-form', ['pustaka' => null, 'daftarKategori' => $daftarKategori]);
    }

    public function pustakaStore(Request $request)
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

    public function pustakaEdit(int $id)
    {
        $pustaka = Pustaka::findOrFail($id);
        $daftarKategori = $this->getDaftarKategoriPustaka();
        return view('admin.pustaka.pustaka-form', compact('pustaka', 'daftarKategori'));
    }

    public function pustakaUpdate(Request $request, int $id)
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

    public function pustakaDestroy(int $id)
    {
        $pustaka = Pustaka::findOrFail($id);
        if ($pustaka->file) Storage::disk('public')->delete($pustaka->file);
        $pustaka->delete();

        return back()->with('success', 'Dokumen berhasil dihapus.');
    }

    public function pustakaKategoriStore(Request $request)
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

    public function pustakaKategoriRename(Request $request)
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

    public function pustakaKategoriDelete(Request $request)
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

    // ─── PROVINSI ────────────────────────────────────────────────────

    public function provinsiIndex(Request $request)
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

    public function provinsiCreate()
    {
        return view('admin.provinsi.provinsi-form', ['provinsi' => null]);
    }

    public function provinsiStore(Request $request)
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

    public function provinsiEdit(int $id)
    {
        $provinsi = Provinsi::findOrFail($id);
        return view('admin.provinsi.provinsi-form', compact('provinsi'));
    }

    public function provinsiUpdate(Request $request, int $id)
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

    public function provinsiDestroy(int $id)
    {
        $provinsi = Provinsi::findOrFail($id);
        if ($provinsi->lambang) Storage::disk('public')->delete($provinsi->lambang);
        $provinsi->delete();

        return back()->with('success', 'Data provinsi berhasil dihapus.');
    }

    // ─── PENGATURAN ──────────────────────────────────────────────────

    public function pengaturanIndex()
    {
        $settings = [
            'nama_organisasi', 'singkatan', 'deskripsi', 'email', 'telepon',
            'fax', 'alamat', 'facebook', 'instagram', 'youtube', 'twitter',
            'instagram_widget_code',
            'ketua_umum', 'ketua_umum_provinsi', 'periode', 'visi', 'misi',
        ];

        $pengaturan = [];
        foreach ($settings as $kunci) {
            $pengaturan[$kunci] = Pengaturan::get($kunci, '');
        }

        return view('admin.pengaturan', compact('pengaturan'));
    }

    public function pengaturanUpdate(Request $request)
    {
        $keys = [
            'nama_organisasi', 'singkatan', 'deskripsi', 'email', 'telepon',
            'fax', 'alamat', 'facebook', 'instagram', 'youtube', 'twitter',
            'instagram_widget_code',
            'ketua_umum', 'ketua_umum_provinsi', 'periode', 'visi', 'misi',
        ];

        foreach ($keys as $kunci) {
            if ($request->has($kunci)) {
                Pengaturan::set($kunci, $request->input($kunci));
            }
        }

        // Reset cache video dan pengaturan agar langsung sinkron ke seluruh halaman
        Cache::forget('appsi_youtube_latest_video_auto');

        Aktivitas::log('edit', 'pengaturan', 'Memperbarui pengaturan identitas & kontak website.');

        return back()->with('success', 'Pengaturan website berhasil disimpan.');
    }

    // ─── PROFIL SAYA & UBAH PASSWORD ──────────────────────────────────

    public function profileIndex()
    {
        $user = Auth::user();
        return view('admin.users.profile', compact('user'));
    }

    public function profileUpdate(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|max:255|unique:users,email,' . $user->id,
            'current_password'      => 'nullable|required_with:new_password',
            'new_password'          => 'nullable|min:6|confirmed',
        ]);

        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
            }
            $data['password'] = Hash::make($request->new_password);
        }

        unset($data['current_password'], $data['new_password'], $data['new_password_confirmation']);
        $user->update($data);

        Aktivitas::log('edit', 'auth', "Memperbarui akun profil/password: {$user->name}");

        return back()->with('success', 'Profil & password berhasil diperbarui.');
    }

    // ─── MANAJEMEN USER / STAF ADMIN ─────────────────────────────────

    public function usersIndex(Request $request)
    {
        $users = User::latest()->paginate(15);
        return view('admin.users.users-index', compact('users'));
    }

    public function usersCreate()
    {
        return view('admin.users.users-form', ['user' => null]);
    }

    public function usersStore(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users',
            'role'     => 'required|string|in:admin,staf',
            'password' => 'required|min:6',
        ]);

        $data['password'] = Hash::make($data['password']);
        $newUser = User::create($data);

        Aktivitas::log('tambah', 'users', "Menambahkan staf admin baru: {$newUser->name} ({$newUser->email})");

        return redirect()->route('admin.users.index')->with('success', 'Staf admin baru berhasil ditambahkan.');
    }

    public function usersEdit(int $id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.users-form', compact('user'));
    }

    public function usersUpdate(Request $request, int $id)
    {
        $targetUser = User::findOrFail($id);

        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email,' . $targetUser->id,
            'role'     => 'required|string|in:admin,staf',
            'password' => 'nullable|min:6',
        ]);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        $targetUser->update($data);

        Aktivitas::log('edit', 'users', "Memperbarui data akun staf admin: {$targetUser->name}");

        return redirect()->route('admin.users.index')->with('success', 'Data staf admin berhasil diperbarui.');
    }

    public function usersDestroy(int $id)
    {
        if (Auth::id() === $id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $targetUser = User::findOrFail($id);
        $name = $targetUser->name;
        $targetUser->delete();

        Aktivitas::log('hapus', 'users', "Menghapus akun staf admin: {$name}");

        return back()->with('success', 'Akun staf admin berhasil dihapus.');
    }

    // ─── LOG AKTIVITAS SISTEM ────────────────────────────────────────

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
