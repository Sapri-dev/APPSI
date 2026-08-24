<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Pengaturan;
use App\Models\Provinsi;
use App\Services\YouTubeService;
use App\Services\InstagramService;

class PageController extends Controller
{
    public function beranda()
    {
        $sliderBerita  = Berita::published()->take(5)->get();
        $beritaTerbaru = Berita::published()->take(4)->get();
        $provinsi      = Provinsi::ordered()->take(12)->get();
        $videoTerbaru  = YouTubeService::getLatestVideo();
        $igPosts       = InstagramService::getLatestPosts(3);
        $pengaturan    = [
            'nama'                  => Pengaturan::get('nama_organisasi', 'APPSI'),
            'singkatan'             => Pengaturan::get('singkatan', 'APPSI'),
            'visi'                  => Pengaturan::get('visi'),
            'misi'                  => Pengaturan::get('misi'),
            'ketua_umum'            => Pengaturan::get('ketua_umum'),
            'ketua_provinsi'        => Pengaturan::get('ketua_umum_provinsi'),
            'periode'               => Pengaturan::get('periode', '2025-2029'),
            'instagram'             => Pengaturan::get('instagram', 'https://www.instagram.com/appsi.or.id/'),
            'instagram_widget_code' => Pengaturan::get('instagram_widget_code'),
        ];

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
}
