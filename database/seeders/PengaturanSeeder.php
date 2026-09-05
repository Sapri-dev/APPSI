<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengaturan;

class PengaturanSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Identitas Website & Global Info
            'nama_organisasi'           => 'Asosiasi Pemerintah Provinsi Seluruh Indonesia',
            'singkatan'                 => 'APPSI',
            'deskripsi'                 => 'APPSI dibentuk sebagai wadah koordinasi dan sinergi Pemerintah Provinsi se-Indonesia dalam memperkuat peran gubernur, menyuarakan aspirasi daerah, serta mendukung penyelenggaraan pemerintahan dan pembangunan nasional dalam bingkai Negara Kesatuan Republik Indonesia.',
            'email'                     => 'info@appsi.or.id',
            'telepon'                   => '021- 2168 4200',
            'fax'                       => '021- 2598 4843, 2598 4316',
            'alamat'                    => 'Gedung Nyi Ageng Serang Lt. 4, Jl. HR. Rasuna Said Kav. 22 C, Jakarta Selatan, Indonesia 12940',
            'facebook'                  => 'https://www.facebook.com/info.appsi/?locale=id_ID',
            'instagram'                 => 'https://www.instagram.com/appsi.or.id/',
            'youtube'                   => 'https://www.youtube.com/@OfficialAPPSI',
            'twitter'                   => 'https://x.com/appsi_id',

            // Profil Ketua Umum & Sambutan Beranda
            'ketua_umum'                => 'Dr. H. Rudy Mas’ud, SE., ME.',
            'ketua_umum_provinsi'       => 'Gubernur Kalimantan Timur',
            'periode'                   => '2025–2029',
            'beranda_sambutan_badge'    => 'Asosiasi Pemerintah Provinsi Seluruh Indonesia',
            'beranda_sambutan_judul'    => 'Wadah Kerjasama Strategis Antar Provinsi se-Indonesia',
            'beranda_sambutan_teks'     => "Asosiasi Pemerintahan Provinsi Seluruh Indonesia (APPSI) merupakan organisasi resmi yang menghimpun seluruh Pemerintah Provinsi di Indonesia. APPSI dibentuk sebagai wadah koordinasi nasional guna menyatukan aspirasi daerah provinsi, memperkuat hubungan Pemerintah Pusat dan Pemerintah Daerah, serta mendukung perumusan dan implementasi kebijakan nasional.\n\nAPPSI berkedudukan sebagai mitra strategis Pemerintah Pusat dan pemangku kepentingan nasional lainnya dalam penyelenggaraan pemerintahan daerah sesuai dengan prinsip Negara Kesatuan Republik Indonesia.",

            // Kutipan Tokoh
            'beranda_quote_teks'         => 'Amanah ini bukan sekadar kehormatan, tetapi juga tanggung jawab besar untuk memajukan daerah-daerah di seluruh Indonesia.',
            'beranda_quote_tokoh'        => 'H Rudy Mas’ud',
            'beranda_quote_sub'          => 'Ketua Umum APPSI',

            // Visi & Misi
            'visi'                      => 'Terwujudnya sinergi nasional Pemerintah Provinsi yang kuat, mandiri, dan berdaya saing dalam mendukung pembangunan nasional berkelanjutan.',
            'misi'                      => "Memperkuat koordinasi dan kerja sama antar Pemerintah Provinsi.\nMendorong sinkronisasi kebijakan pusat dan daerah.\nMeningkatkan kapasitas tata kelola pemerintahan daerah.\nMenyampaikan aspirasi daerah secara konstruktif di tingkat nasional.",

            // Peran & Fungsi
            'beranda_peran_1_judul'     => 'Koordinasi Nasional',
            'beranda_peran_1_deskripsi' => 'Menyelaraskan kebijakan dan program antar Pemerintah Provinsi dengan kebijakan nasional.',
            'beranda_peran_2_judul'     => 'Advokasi Kebijakan',
            'beranda_peran_2_deskripsi' => 'Mewakili kepentingan Pemerintah Provinsi dalam forum nasional dan antar lembaga.',
            'beranda_peran_3_judul'     => 'Penguatan Kapasitas',
            'beranda_peran_3_deskripsi' => 'Mendorong peningkatan kapasitas kelembagaan dan SDM aparatur daerah.',
            'beranda_peran_4_judul'     => 'Sinergi Pembangunan',
            'beranda_peran_4_deskripsi' => 'Mendorong kolaborasi antar daerah untuk pembangunan yang merata dan berkelanjutan.',

            // Program Utama
            'beranda_program_1_judul'     => 'Rapat Koordinasi Nasional',
            'beranda_program_1_deskripsi' => 'Forum rutin antar Pemerintah Provinsi untuk membahas isu strategis nasional dan daerah.',
            'beranda_program_2_judul'     => 'Forum Best Practice',
            'beranda_program_2_deskripsi' => 'Pertukaran praktik terbaik dalam tata kelola pemerintahan dan pelayanan publik.',
            'beranda_program_3_judul'     => 'Kajian & Rekomendasi',
            'beranda_program_3_deskripsi' => 'Penyusunan kajian kebijakan dan rekomendasi strategis bagi pemerintah pusat.',

            // Media & Widget Override
            'beranda_youtube_video_id'  => '',
            'instagram_widget_code'     => '',
        ];

        foreach ($settings as $kunci => $nilai) {
            Pengaturan::firstOrCreate(['kunci' => $kunci], ['nilai' => $nilai]);
        }
    }
}
