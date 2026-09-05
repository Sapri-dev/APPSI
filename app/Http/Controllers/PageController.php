<?php

namespace App\Http\Controllers;

use App\Mail\PesanMasukMail;
use App\Models\Berita;
use App\Models\Pengaturan;
use App\Models\Pesan;
use App\Models\Provinsi;
use App\Services\YouTubeService;
use App\Services\InstagramService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    public function beranda()
    {
        $sliderBerita  = Berita::published()->take(5)->get();
        $beritaTerbaru = Berita::published()->take(4)->get();
        $provinsi      = Provinsi::ordered()->take(12)->get();

        $customVideoId = Pengaturan::get('beranda_youtube_video_id');
        if (!empty($customVideoId)) {
            $videoTerbaru = [
                'id'        => $customVideoId,
                'title'     => 'Dokumentasi Kegiatan Resmi APPSI',
                'author'    => 'Official APPSI Channel',
                'thumbnail' => "https://img.youtube.com/vi/{$customVideoId}/hqdefault.jpg",
            ];
        } else {
            $videoTerbaru = YouTubeService::getLatestVideo();
        }

        $igPosts       = InstagramService::getLatestPosts(3);

        $fotoKetua     = Pengaturan::get('beranda_foto_ketua');
        $fotoKetuaUrl  = $fotoKetua ? asset('storage/' . $fotoKetua) : asset('storage/pengurus/kaltim.jpg');

        $keys = [
            'nama_organisasi', 'singkatan', 'visi', 'misi',
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
            'instagram', 'instagram_widget_code',
        ];

        $pengaturan = [];
        foreach ($keys as $kunci) {
            $pengaturan[$kunci] = Pengaturan::get($kunci, '');
        }

        // Alias penamaan agar kompatibel penuh dengan view beranda
        $pengaturan['nama']              = $pengaturan['nama_organisasi'];
        $pengaturan['quote_teks']        = $pengaturan['beranda_quote_teks'];
        $pengaturan['quote_tokoh']       = $pengaturan['beranda_quote_tokoh'];
        $pengaturan['quote_sub']         = $pengaturan['beranda_quote_sub'];
        $pengaturan['ketua_provinsi']    = $pengaturan['ketua_umum_provinsi'];
        $pengaturan['foto_ketua_url']    = $fotoKetuaUrl;
        $pengaturan['sambutan_badge']    = $pengaturan['beranda_sambutan_badge'];
        $pengaturan['sambutan_judul']    = $pengaturan['beranda_sambutan_judul'];
        $pengaturan['sambutan_teks']     = $pengaturan['beranda_sambutan_teks'];
        $pengaturan['peran_1_judul']     = $pengaturan['beranda_peran_1_judul'];
        $pengaturan['peran_1_deskripsi'] = $pengaturan['beranda_peran_1_deskripsi'];
        $pengaturan['peran_2_judul']     = $pengaturan['beranda_peran_2_judul'];
        $pengaturan['peran_2_deskripsi'] = $pengaturan['beranda_peran_2_deskripsi'];
        $pengaturan['peran_3_judul']     = $pengaturan['beranda_peran_3_judul'];
        $pengaturan['peran_3_deskripsi'] = $pengaturan['beranda_peran_3_deskripsi'];
        $pengaturan['peran_4_judul']     = $pengaturan['beranda_peran_4_judul'];
        $pengaturan['peran_4_deskripsi'] = $pengaturan['beranda_peran_4_deskripsi'];
        $pengaturan['program_1_judul']   = $pengaturan['beranda_program_1_judul'];
        $pengaturan['program_1_deskripsi'] = $pengaturan['beranda_program_1_deskripsi'];
        $pengaturan['program_2_judul']   = $pengaturan['beranda_program_2_judul'];
        $pengaturan['program_2_deskripsi'] = $pengaturan['beranda_program_2_deskripsi'];
        $pengaturan['program_3_judul']   = $pengaturan['beranda_program_3_judul'];
        $pengaturan['program_3_deskripsi'] = $pengaturan['beranda_program_3_deskripsi'];

        return view('pages.beranda', compact('sliderBerita', 'beritaTerbaru', 'provinsi', 'videoTerbaru', 'igPosts', 'pengaturan'));
    }

    public function sejarah()
    {
        $pengaturan = ['nama' => Pengaturan::get('nama_organisasi', 'APPSI')];
        return view('pages.sejarah', compact('pengaturan'));
    }

    public function hubungi()
    {
        $pengaturan = [
            'nama'      => Pengaturan::get('nama_organisasi', 'APPSI'),
            'email'     => Pengaturan::get('email'),
            'telepon'   => Pengaturan::get('telepon'),
            'fax'       => Pengaturan::get('fax'),
            'alamat'    => Pengaturan::get('alamat'),
            'facebook'  => Pengaturan::get('facebook'),
            'instagram' => Pengaturan::get('instagram'),
            'youtube'   => Pengaturan::get('youtube'),
            'twitter'   => Pengaturan::get('twitter'),
        ];

        return view('pages.hubungi', compact('pengaturan'));
    }

    public function kirimPesan(Request $request)
    {
        $validated = $request->validate([
            'nama'   => 'required|string|max:100',
            'email'  => 'required|email|max:100',
            'subjek' => 'required|string|max:200',
            'pesan'  => 'required|string|max:5000',
        ], [
            'nama.required'   => 'Nama lengkap wajib diisi.',
            'email.required'  => 'Alamat email wajib diisi.',
            'email.email'     => 'Format email tidak valid.',
            'subjek.required' => 'Subjek pesan wajib diisi.',
            'pesan.required'  => 'Isi pesan wajib diisi.',
        ]);

        // Simpan ke database
        $pesanBaru = Pesan::create($validated);

        // Kirim notifikasi email ke admin
        $emailAdmin = Pengaturan::get('email', config('mail.from.address'));
        try {
            Mail::to($emailAdmin)->send(new PesanMasukMail($pesanBaru));
        } catch (\Exception $e) {
            // Gagal kirim email tidak menggagalkan proses — pesan tetap tersimpan
            logger()->error('Gagal kirim email notifikasi pesan: ' . $e->getMessage());
        }

        return back()->with('success', 'Pesan Anda berhasil terkirim! Kami akan segera menghubungi Anda.');
    }
}
