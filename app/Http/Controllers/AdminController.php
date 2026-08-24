<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Pengaturan;
use App\Models\Pengurus;
use App\Models\Provinsi;
use App\Models\Pustaka;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
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
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
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

        return view('admin.dashboard', compact('stats', 'beritaTerbaru'));
    }

    // ─── BERITA ──────────────────────────────────────────────────────

    public function beritaIndex()
    {
        $berita = Berita::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.berita.index', compact('berita'));
    }

    public function beritaCreate()
    {
        return view('admin.berita.form', ['berita' => null]);
    }

    public function beritaStore(Request $request)
    {
        $data = $request->validate([
            'judul'              => 'required|string|max:255',
            'ringkasan'          => 'nullable|string',
            'konten'             => 'required|string',
            'gambar'             => 'nullable|image|max:2048',
            'kategori'           => 'required|string',
            'tanggal_publikasi'  => 'required|date',
            'is_published'       => 'nullable|boolean',
        ]);

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
        return view('admin.berita.form', compact('berita'));
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
            'tanggal_publikasi'  => 'required|date',
            'is_published'       => 'nullable|boolean',
        ]);

        if ($request->hasFile('gambar')) {
            if ($berita->gambar) Storage::disk('public')->delete($berita->gambar);
            $data['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        $data['slug']         = Str::slug($data['judul']);
        $data['is_published'] = $request->boolean('is_published');

        $berita->update($data);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui.');
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

    public function pengurusIndex()
    {
        $pengurus = Pengurus::orderBy('jenis')->orderBy('urutan')->paginate(20);
        return view('admin.pengurus.index', compact('pengurus'));
    }

    public function pengurusCreate()
    {
        return view('admin.pengurus.form', ['pengurus' => null]);
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
        return view('admin.pengurus.form', compact('pengurus'));
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

    // ─── PUSTAKA ─────────────────────────────────────────────────────

    public function pustakaIndex()
    {
        $pustaka = Pustaka::orderBy('kategori')->orderBy('tahun', 'desc')->paginate(20);
        return view('admin.pustaka.index', compact('pustaka'));
    }

    public function pustakaCreate()
    {
        return view('admin.pustaka.form', ['pustaka' => null]);
    }

    public function pustakaStore(Request $request)
    {
        $data = $request->validate([
            'judul'        => 'required|string|max:255',
            'kategori'     => 'required|in:uu,adart,rekomendasi,sk,berita_acara,data_bps',
            'tahun'        => 'nullable|integer|min:2000|max:2099',
            'deskripsi'    => 'nullable|string',
            'file'         => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'file_url'     => 'nullable|url',
            'is_published' => 'nullable|boolean',
        ]);

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
        return view('admin.pustaka.form', compact('pustaka'));
    }

    public function pustakaUpdate(Request $request, int $id)
    {
        $pustaka = Pustaka::findOrFail($id);

        $data = $request->validate([
            'judul'        => 'required|string|max:255',
            'kategori'     => 'required|in:uu,adart,rekomendasi,sk,berita_acara,data_bps',
            'tahun'        => 'nullable|integer|min:2000|max:2099',
            'deskripsi'    => 'nullable|string',
            'file'         => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'file_url'     => 'nullable|url',
            'is_published' => 'nullable|boolean',
        ]);

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

    // ─── PROVINSI ────────────────────────────────────────────────────

    public function provinsiIndex(Request $request)
    {
        $perPage = $request->input('perPage', 10);

        // Jika "all" tampilkan semua, jika tidak pakai pagination
        if ($perPage === 'all') {
            $provinsi = Provinsi::ordered()->get();
            $isPaginated = false;
        } else {
            $perPage  = in_array((int)$perPage, [10, 25, 38]) ? (int)$perPage : 10;
            $provinsi = Provinsi::ordered()->paginate($perPage)->withQueryString();
            $isPaginated = true;
        }

        return view('admin.provinsi.index', compact('provinsi', 'isPaginated', 'perPage'));
    }

    public function provinsiEdit(int $id)
    {
        $provinsi = Provinsi::findOrFail($id);
        return view('admin.provinsi.form', compact('provinsi'));
    }

    public function provinsiUpdate(Request $request, int $id)
    {
        $provinsi = Provinsi::findOrFail($id);

        $data = $request->validate([
            'gubernur' => 'nullable|string|max:255',
            'lambang'  => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('lambang')) {
            if ($provinsi->lambang) Storage::disk('public')->delete($provinsi->lambang);
            $data['lambang'] = $request->file('lambang')->store('provinsi', 'public');
        }

        $provinsi->update($data);

        return redirect()->route('admin.provinsi.index')->with('success', 'Data provinsi berhasil diperbarui.');
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

        return back()->with('success', 'Pengaturan website berhasil disimpan.');
    }
}
