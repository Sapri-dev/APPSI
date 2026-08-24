<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengaturan;

class PengaturanSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'nama_organisasi'  => 'Asosiasi Pemerintah Provinsi Seluruh Indonesia',
            'singkatan'        => 'APPSI',
            'deskripsi'        => 'APPSI dibentuk sebagai wadah koordinasi dan sinergi Pemerintah Provinsi se-Indonesia dalam memperkuat peran gubernur, menyuarakan aspirasi daerah, serta mendukung penyelenggaraan pemerintahan dan pembangunan nasional dalam bingkai Negara Kesatuan Republik Indonesia.',
            'email'            => 'info@appsi.or.id',
            'telepon'          => '021- 2168 4200',
            'fax'              => '021- 2598 4843, 2598 4316',
            'alamat'           => 'Gedung Nyi Ageng Serang Lt. 4, Jl. HR. Rasuna Said Kav. 22 C, Jakarta Selatan, Indonesia 12940',
            'facebook'         => 'https://www.facebook.com/info.appsi/?locale=id_ID',
            'instagram'        => 'https://www.instagram.com/appsi.or.id/',
            'youtube'          => 'https://www.youtube.com/@OfficialAPPSI',
            'twitter'          => 'https://x.com/appsi_id',
            'ketua_umum'       => 'Dr. H. Rudy Mas’ud, SE., ME.',
            'ketua_umum_provinsi' => 'Gubernur Kalimantan Timur',
            'periode'          => '2025-2029',
            'visi'             => 'Terwujudnya sinergi nasional Pemerintah Provinsi yang kuat, mandiri, dan berdaya saing dalam mendukung pembangunan nasional berkelanjutan.',
            'misi'             => "Memperkuat koordinasi dan kerja sama antar Pemerintah Provinsi.\nMendorong sinkronisasi kebijakan pusat dan daerah.\nMeningkatkan kapasitas tata kelola pemerintahan daerah.\nMenyampaikan aspirasi daerah secara konstruktif di tingkat nasional.",
        ];

        foreach ($settings as $kunci => $nilai) {
            Pengaturan::updateOrCreate(['kunci' => $kunci], ['nilai' => $nilai]);
        }
    }
}
