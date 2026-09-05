<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aktivitas;
use App\Models\Pengaturan;
use App\Services\InstagramService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class PengaturanController extends Controller
{
    // ─── PENGATURAN WEBSITE ──────────────────────────────────────────

    public function pengaturanIndex()
    {
        $settings = [
            'nama_organisasi', 'singkatan', 'deskripsi', 'email', 'telepon',
            'fax', 'alamat', 'facebook', 'instagram', 'youtube', 'twitter',
            'logo_utama', 'logo_emblem',
        ];

        $pengaturan = [];
        foreach ($settings as $kunci) {
            $pengaturan[$kunci] = Pengaturan::get($kunci, '');
        }

        return view('admin.pengaturan', compact('pengaturan'));
    }

    public function pengaturanUpdate(Request $request)
    {
        $request->validate([
            'logo_utama'  => 'nullable|image|max:2048',
            'logo_emblem' => 'nullable|image|max:2048',
        ]);

        $keys = [
            'nama_organisasi', 'singkatan', 'deskripsi', 'email', 'telepon',
            'fax', 'alamat', 'facebook', 'instagram', 'youtube', 'twitter',
        ];

        foreach ($keys as $kunci) {
            if ($request->has($kunci)) {
                Pengaturan::set($kunci, $request->input($kunci));
            }
        }

        // Upload Logo Utama
        if ($request->hasFile('logo_utama')) {
            $oldLogo = Pengaturan::get('logo_utama');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }
            $path = $request->file('logo_utama')->store('pengaturan', 'public');
            Pengaturan::set('logo_utama', $path);
        }

        // Reset Logo Utama ke default
        if ($request->boolean('hapus_logo_utama')) {
            $oldLogo = Pengaturan::get('logo_utama');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }
            Pengaturan::set('logo_utama', null);
        }

        // Upload Logo Emblem / Favicon
        if ($request->hasFile('logo_emblem')) {
            $oldEmblem = Pengaturan::get('logo_emblem');
            if ($oldEmblem && Storage::disk('public')->exists($oldEmblem)) {
                Storage::disk('public')->delete($oldEmblem);
            }
            $path = $request->file('logo_emblem')->store('pengaturan', 'public');
            Pengaturan::set('logo_emblem', $path);
        }

        // Reset Logo Emblem ke default
        if ($request->boolean('hapus_logo_emblem')) {
            $oldEmblem = Pengaturan::get('logo_emblem');
            if ($oldEmblem && Storage::disk('public')->exists($oldEmblem)) {
                Storage::disk('public')->delete($oldEmblem);
            }
            Pengaturan::set('logo_emblem', null);
        }

        // Reset cache video dan pengaturan agar langsung sinkron ke seluruh halaman
        Cache::forget('appsi_youtube_latest_video_auto');

        Aktivitas::log('edit', 'pengaturan', 'Memperbarui pengaturan logo, identitas & kontak website.');

        return back()->with('success', 'Pengaturan website berhasil disimpan.');
    }

    // ─── PENGATURAN KHUSUS BERANDA ────────────────────────────────────

    public function berandaSettingsIndex()
    {
        $keys = [
            'visi', 'misi',
            'beranda_quote_teks', 'beranda_quote_tokoh', 'beranda_quote_sub',
            'ketua_umum', 'ketua_umum_provinsi', 'periode',
            'beranda_sambutan_badge', 'beranda_sambutan_judul', 'beranda_sambutan_teks',
            'beranda_foto_ketua',
            'beranda_peran_1_judul', 'beranda_peran_1_deskripsi',
            'beranda_peran_2_judul', 'beranda_peran_2_deskripsi',
            'beranda_peran_3_judul', 'beranda_peran_3_deskripsi',
            'beranda_peran_4_judul', 'beranda_peran_4_deskripsi',
            'beranda_program_1_judul', 'beranda_program_1_deskripsi',
            'beranda_program_2_judul', 'beranda_program_2_deskripsi',
            'beranda_program_3_judul', 'beranda_program_3_deskripsi',
            'beranda_youtube_video_id', 'instagram_widget_code',
        ];

        $pengaturan = [];
        foreach ($keys as $kunci) {
            $pengaturan[$kunci] = Pengaturan::get($kunci, '');
        }

        return view('admin.beranda.beranda-settings', compact('pengaturan'));
    }

    public function berandaSettingsUpdate(Request $request)
    {
        $request->validate([
            'beranda_foto_ketua' => 'nullable|image|max:3072',
        ]);

        $keys = [
            'visi', 'misi',
            'beranda_quote_teks', 'beranda_quote_tokoh', 'beranda_quote_sub',
            'ketua_umum', 'ketua_umum_provinsi', 'periode',
            'beranda_sambutan_badge', 'beranda_sambutan_judul', 'beranda_sambutan_teks',
            'beranda_peran_1_judul', 'beranda_peran_1_deskripsi',
            'beranda_peran_2_judul', 'beranda_peran_2_deskripsi',
            'beranda_peran_3_judul', 'beranda_peran_3_deskripsi',
            'beranda_peran_4_judul', 'beranda_peran_4_deskripsi',
            'beranda_program_1_judul', 'beranda_program_1_deskripsi',
            'beranda_program_2_judul', 'beranda_program_2_deskripsi',
            'beranda_program_3_judul', 'beranda_program_3_deskripsi',
            'beranda_youtube_video_id',
            'instagram_widget_code',
        ];

        foreach ($keys as $kunci) {
            if ($request->has($kunci)) {
                Pengaturan::set($kunci, $request->input($kunci));
            }
        }

        // Handle upload foto ketua
        if ($request->hasFile('beranda_foto_ketua')) {
            $oldFoto = Pengaturan::get('beranda_foto_ketua');
            if ($oldFoto && Storage::disk('public')->exists($oldFoto)) {
                Storage::disk('public')->delete($oldFoto);
            }
            $path = $request->file('beranda_foto_ketua')->store('pengaturan', 'public');
            Pengaturan::set('beranda_foto_ketua', $path);
        }

        // Hapus foto jika diminta
        if ($request->boolean('hapus_foto_ketua')) {
            $oldFoto = Pengaturan::get('beranda_foto_ketua');
            if ($oldFoto && Storage::disk('public')->exists($oldFoto)) {
                Storage::disk('public')->delete($oldFoto);
            }
            Pengaturan::set('beranda_foto_ketua', null);
        }

        Cache::forget('appsi_youtube_latest_video_auto');

        Aktivitas::log('edit', 'pengaturan', 'Memperbarui pengaturan konten & tata letak Beranda.');

        return back()->with('success', 'Pengaturan Beranda berhasil diperbarui.');
    }

    // ─── INSTAGRAM ─────────────────────────────────────────────────────

    /**
     * Refresh cache postingan Instagram secara manual dari panel admin.
     */
    public function instagramRefresh(Request $request)
    {
        $posts = InstagramService::runScraper();

        if (!empty($posts)) {
            Cache::put('appsi_instagram_latest_posts_auto', $posts, 3600 * 6);
            $count = count($posts);
            Aktivitas::log('refresh', 'instagram', "Berhasil memperbarui {$count} postingan Instagram ke cache.");
            return back()->with('success', "✅ Berhasil memperbarui {$count} postingan Instagram terbaru ke cache.");
        }

        return back()->with('error', 'Scraper belum berhasil mengambil data Instagram terbaru. Periksa koneksi atau coba beberapa saat lagi.');
    }

    // Aliases
    public function websiteIndex() { return $this->pengaturanIndex(); }
    public function websiteUpdate(Request $request) { return $this->pengaturanUpdate($request); }
    public function berandaIndex() { return $this->berandaSettingsIndex(); }
    public function berandaUpdate(Request $request) { return $this->berandaSettingsUpdate($request); }
}
