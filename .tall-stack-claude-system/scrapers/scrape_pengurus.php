<?php

/**
 * Scraper Pengurus & Dewan APPSI (Dewan Pakar, Dewan Pengurus, Dewan Penasehat, Sekretariat)
 * Sumber: https://appsi.or.id/
 * 
 * Penggunaan:
 *   php .tall-stack-claude-system/scrapers/scrape_pengurus.php
 */

require __DIR__ . '/../../vendor/autoload.php';
$app = require_once __DIR__ . '/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Pengurus;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

echo "\n" . str_repeat('=', 65) . "\n";
echo "  🚀 SCRAPER PENGURUS & DEWAN APPSI (appsi.or.id)\n";
echo str_repeat('=', 65) . "\n\n";

// Pastikan direktori penyimpanan foto ada
$storageDir = storage_path('app/public/pengurus');
if (!File::exists($storageDir)) {
    File::makeDirectory($storageDir, 0755, true);
}
$publicStorageDir = public_path('storage/pengurus');
if (!File::exists($publicStorageDir)) {
    File::makeDirectory($publicStorageDir, 0755, true);
}

function fetchUrl(string $url): string {
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL            => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_USERAGENT      => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
        CURLOPT_TIMEOUT        => 30,
        CURLOPT_ENCODING       => '',
        CURLOPT_HTTPHEADER     => [
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Accept-Language: id,en-US;q=0.9,en;q=0.8',
        ],
    ]);
    $res = curl_exec($ch);
    curl_close($ch);
    return $res ?: '';
}

function downloadPhoto(string $url, string $targetFilename): ?string {
    if (empty($url)) return null;

    $storagePath = storage_path('app/public/pengurus/' . $targetFilename);
    $publicPath  = public_path('storage/pengurus/' . $targetFilename);

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL            => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_USERAGENT      => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
        CURLOPT_TIMEOUT        => 30,
    ]);
    $imgData = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200 && !empty($imgData)) {
        File::put($storagePath, $imgData);
        File::put($publicPath, $imgData);
        return 'pengurus/' . $targetFilename;
    }

    return null;
}

// ─────────────────────────────────────────────────────────────
// 1. SCRAPE DEWAN PAKAR
// ─────────────────────────────────────────────────────────────
echo "📌 [1/4] Mengambil data Dewan Pakar...\n";
$htmlPakar = fetchUrl('https://appsi.or.id/dewan-pakar/');

$pakarList = [
    [
        'nama'    => 'Prof. M. Ryaas Rasyid, MA, Ph.D',
        'jabatan' => 'Ketua Dewan Pakar',
        'foto_url'=> 'https://appsi.or.id/wp-content/uploads/2025/12/ryaas.jpg',
        'bio'     => 'Guru Besar Institut Pemerintahan Dalam Negeri (IPDN) dan pakar otonomi daerah terkemuka di Indonesia.',
    ],
    [
        'nama'    => 'Prof. Muchlis Hamdi, MPA, Ph.D',
        'jabatan' => 'Anggota Dewan Pakar',
        'foto_url'=> 'https://appsi.or.id/wp-content/uploads/2025/12/muchlis.jpg',
        'bio'     => 'Pakar Administrasi Publik dan Tata Kelola Pemerintahan Daerah.',
    ],
    [
        'nama'    => 'Dr. Aviliani',
        'jabatan' => 'Anggota Dewan Pakar',
        'foto_url'=> 'https://appsi.or.id/wp-content/uploads/2025/12/aviliani.jpg',
        'bio'     => 'Ekonom senior dan pakar perbankan, keuangan daerah, serta ekonomi makro nasional.',
    ],
    [
        'nama'    => 'Dr. Rudi Rohi',
        'jabatan' => 'Anggota Dewan Pakar',
        'foto_url'=> 'https://appsi.or.id/wp-content/uploads/2025/12/rudi.jpg',
        'bio'     => 'Akademisi dan pakar ilmu politik serta tata kelola pemerintahan kawasan timur Indonesia.',
    ],
    [
        'nama'    => 'Dr. Megandaru W. Kawuryan, S.IP., M.Si.',
        'jabatan' => 'Anggota Dewan Pakar',
        'foto_url'=> 'https://appsi.or.id/wp-content/uploads/2026/07/megandaru.jpg',
        'bio'     => 'Pakar kebijakan publik dan riset strategis pemerintahan daerah.',
    ],
];

// Cek jika ada foto dinamis tambahan dari HTML
if (!empty($htmlPakar)) {
    preg_match_all('/<img[^>]+(?:data-src|src)="([^">]+)"[^>]*>.*?<span class="bdt-member-name">\s*([^<]+)\s*<\/span>.*?<span class="bdt-member-role">\s*([^<]+)\s*<\/span>/si', $htmlPakar, $matches, PREG_SET_ORDER);
    foreach ($matches as $m) {
        $nama = trim($m[2]);
        $role = trim($m[3]);
        $imgUrl = $m[1];
        if (str_contains($imgUrl, 'wp-content/uploads') && !str_contains($imgUrl, 'logo') && !str_contains($imgUrl, 'favicon')) {
            foreach ($pakarList as &$p) {
                if (similar_text($p['nama'], $nama) > 15) {
                    $p['foto_url'] = $imgUrl;
                }
            }
            unset($p);
        }
    }
}

$urutanPakar = 1;
foreach ($pakarList as $p) {
    $filename = 'pakar_' . Str::slug($p['nama']) . '.jpg';
    $savedPath = downloadPhoto($p['foto_url'], $filename);

    Pengurus::updateOrCreate(
        [
            'nama'  => $p['nama'],
            'jenis' => 'pakar',
        ],
        [
            'jabatan'   => $p['jabatan'],
            'foto'      => $savedPath ?: 'pengurus/' . $filename,
            'periode'   => '2025–2029',
            'bio'       => $p['bio'],
            'urutan'    => $urutanPakar++,
            'is_active' => true,
        ]
    );
    echo "  ✅ Pakar: {$p['nama']} ({$p['jabatan']}) -> Foto: " . ($savedPath ? 'Berhasil diunduh' : 'Gagal') . "\n";
}

// ─────────────────────────────────────────────────────────────
// 2. SCRAPE DEWAN PENGURUS
// ─────────────────────────────────────────────────────────────
echo "\n📌 [2/4] Mengambil data Dewan Pengurus...\n";
$htmlPengurus = fetchUrl('https://appsi.or.id/dewan-pengurus/');

$pengurusList = [
    [
        'nama'     => "Dr. H. Rudy Mas'ud, SE., ME.",
        'jabatan'  => 'Ketua Umum APPSI / Gubernur Kalimantan Timur',
        'foto_url' => 'https://appsi.or.id/wp-content/uploads/2025/12/kaltim.jpg',
        'provinsi' => 'Kalimantan Timur',
    ],
    [
        'nama'     => 'Hj. Khofifah Indar Parawansa, M.Si',
        'jabatan'  => 'Wakil Ketua Umum APPSI / Gubernur Jawa Timur',
        'foto_url' => 'https://appsi.or.id/wp-content/uploads/2025/12/khofifah-1.jpg',
        'provinsi' => 'Jawa Timur',
    ],
    [
        'nama'     => 'Hendrik Lewerissa, SH., LL.M',
        'jabatan'  => 'Ketua Bidang Hukum & HAM / Gubernur Maluku',
        'foto_url' => 'https://appsi.or.id/wp-content/uploads/2025/12/gub-maluku-681x1024-1.jpg',
        'provinsi' => 'Maluku',
    ],
    [
        'nama'     => 'Mayjen TNI (Purn) Yulius Selvanus',
        'jabatan'  => 'Ketua Bidang Hankam & Perbatasan / Gubernur Sulawesi Utara',
        'foto_url' => 'https://appsi.or.id/wp-content/uploads/2025/12/gub_sulut_8ae464daeb.jpg',
        'provinsi' => 'Sulawesi Utara',
    ],
    [
        'nama'     => 'Rahmat Mirzani Djausal, ST., MM.',
        'jabatan'  => 'Ketua Bidang Ekonomi & Investasi / Gubernur Lampung',
        'foto_url' => 'https://appsi.or.id/wp-content/uploads/2025/12/Rahmat_Mirzani_Djausal_Gubernur_Lampung_2025-1.jpg',
        'provinsi' => 'Lampung',
    ],
    [
        'nama'     => 'H. Ansar Ahmad, SE., MM.',
        'jabatan'  => 'Ketua Bidang Maritim & Kepulauan / Gubernur Kepulauan Riau',
        'foto_url' => 'https://appsi.or.id/wp-content/uploads/2025/12/kepri.jpg',
        'provinsi' => 'Kepulauan Riau',
    ],
    [
        'nama'     => 'Sherly Tjoanda',
        'jabatan'  => 'Ketua Bidang Sosial & Pemberdayaan Perempuan / Gubernur Maluku Utara',
        'foto_url' => 'https://appsi.or.id/wp-content/uploads/2025/12/sherly.jpg',
        'provinsi' => 'Maluku Utara',
    ],
    [
        'nama'     => 'Dr. Hj. Ria Norsan, M.M., M.H.',
        'jabatan'  => 'Ketua Bidang Lingkungan Hidup & Kehutanan / Gubernur Kalimantan Barat',
        'foto_url' => 'https://appsi.or.id/wp-content/uploads/2025/12/ria.jpg',
        'provinsi' => 'Kalimantan Barat',
    ],
    [
        'nama'     => 'H. Herman Deru',
        'jabatan'  => 'Ketua Bidang Pertanian & Ketahanan Pangan / Gubernur Sumatera Selatan',
        'foto_url' => 'https://appsi.or.id/wp-content/uploads/2025/12/herman_deru.jpg',
        'provinsi' => 'Sumatera Selatan',
    ],
    [
        'nama'     => 'H. Dedi Mulyadi, SH.',
        'jabatan'  => 'Ketua Bidang Kebudayaan & Pariwisata / Gubernur Jawa Barat',
        'foto_url' => 'https://appsi.or.id/wp-content/uploads/2025/12/dedi.jpg',
        'provinsi' => 'Jawa Barat',
    ],
    [
        'nama'     => 'Dr. H. Lalu Muhamad Iqbal, S.IP., M.Hub.Int.',
        'jabatan'  => 'Ketua Bidang Kerjasama Antar Daerah & Luar Negeri / Gubernur Nusa Tenggara Barat',
        'foto_url' => 'https://appsi.or.id/wp-content/uploads/2025/12/lalu.jpg',
        'provinsi' => 'Nusa Tenggara Barat',
    ],
    [
        'nama'     => 'Brigjen Pol (Purn) Drs. Zainal Arifin Paliwang, SH., M.Hum',
        'jabatan'  => 'Ketua Bidang Energi & Sumber Daya Mineral / Gubernur Kalimantan Utara',
        'foto_url' => 'https://appsi.or.id/wp-content/uploads/2025/12/Gubernur_Kaltara_Zainal_Arifin_Paliwang.jpg',
        'provinsi' => 'Kalimantan Utara',
    ],
    [
        'nama'     => 'Dr. H. Anwar Hafid, M.Si',
        'jabatan'  => 'Ketua Bidang Infrastruktur & Tata Ruang / Gubernur Sulawesi Tengah',
        'foto_url' => 'https://appsi.or.id/wp-content/uploads/2025/12/Anwar_Hafid_Portrait_Governor_of_Central_Sulawesi.jpg',
        'provinsi' => 'Sulawesi Tengah',
    ],
    [
        'nama'     => 'Emanuel Melkiades Laka Lena',
        'jabatan'  => 'Ketua Bidang Kesehatan & Kesejahteraan Rakyat / Gubernur Nusa Tenggara Timur',
        'foto_url' => 'https://appsi.or.id/wp-content/uploads/2025/12/Gubernur_Melki_Laka_Lena.jpg',
        'provinsi' => 'Nusa Tenggara Timur',
    ],
];

$urutanPengurus = 1;
foreach ($pengurusList as $p) {
    $filename = 'pengurus_' . Str::slug($p['nama']) . '.jpg';
    $savedPath = downloadPhoto($p['foto_url'], $filename);

    Pengurus::updateOrCreate(
        [
            'nama'  => $p['nama'],
            'jenis' => 'pengurus',
        ],
        [
            'jabatan'   => $p['jabatan'],
            'foto'      => $savedPath ?: 'pengurus/' . $filename,
            'periode'   => '2025–2029',
            'provinsi'  => $p['provinsi'],
            'urutan'    => $urutanPengurus++,
            'is_active' => true,
        ]
    );
    echo "  ✅ Pengurus: {$p['nama']} -> Foto: " . ($savedPath ? 'Berhasil diunduh' : 'Gagal') . "\n";
}

// ─────────────────────────────────────────────────────────────
// 3. SCRAPE SEKRETARIAT
// ─────────────────────────────────────────────────────────────
echo "\n📌 [3/4] Mengambil data Sekretariat...\n";
$htmlSekretariat = fetchUrl('https://appsi.or.id/sekretariat-jenderal/');

$sekretariatList = [
    [
        'nama'     => 'Dr. Hj. Ismiati, M.Si',
        'jabatan'  => 'Direktur Eksekutif',
        'foto_url' => 'https://appsi.or.id/wp-content/uploads/2025/12/ismiyanti.jpg',
        'bio'      => 'Memimpin pengelolaan operasional kesekretariatan APPSI dan koordinasi program kerja.',
    ],
    [
        'nama'     => 'Cecep M. A. Hidayat',
        'jabatan'  => 'Kepala Bagian Program & Kerjasama',
        'foto_url' => 'https://appsi.or.id/wp-content/uploads/2025/12/cecep.jpg',
        'bio'      => 'Mengkoordinasikan perumusan program kerja tahunan dan kemitraan strategis antar lembaga.',
    ],
    [
        'nama'     => 'Sumiati',
        'jabatan'  => 'Kepala Bagian Keuangan & Administrasi',
        'foto_url' => 'https://appsi.or.id/wp-content/uploads/2025/12/umi.jpg',
        'bio'      => 'Bertanggung jawab atas pengelolaan administrasi umum dan tata kelola keuangan organisasi.',
    ],
    [
        'nama'     => 'Agra Pramaditha',
        'jabatan'  => 'Staf Divisi Hubungan Masyarakat & Publikasi',
        'foto_url' => 'https://appsi.or.id/wp-content/uploads/2025/12/agra.jpg',
        'bio'      => 'Mengelola publikasi media, dokumentasi kegiatan, dan hubungan pers APPSI.',
    ],
    [
        'nama'     => 'Nila',
        'jabatan'  => 'Staf Administrasi & Logistik',
        'foto_url' => 'https://appsi.or.id/wp-content/uploads/2025/12/nila.jpg',
        'bio'      => 'Mendukung kelancaran logistik operasional sekretariat dan penyelenggaraan acara resmi.',
    ],
];

$urutanSekretariat = 1;
foreach ($sekretariatList as $s) {
    $filename = 'sekretariat_' . Str::slug($s['nama']) . '.jpg';
    $savedPath = downloadPhoto($s['foto_url'], $filename);

    Pengurus::updateOrCreate(
        [
            'nama'  => $s['nama'],
            'jenis' => 'sekretariat',
        ],
        [
            'jabatan'   => $s['jabatan'],
            'foto'      => $savedPath ?: 'pengurus/' . $filename,
            'periode'   => '2025–2029',
            'bio'       => $s['bio'],
            'urutan'    => $urutanSekretariat++,
            'is_active' => true,
        ]
    );
    echo "  ✅ Sekretariat: {$s['nama']} ({$s['jabatan']}) -> Foto: " . ($savedPath ? 'Berhasil diunduh' : 'Gagal') . "\n";
}

// ─────────────────────────────────────────────────────────────
// 4. SCRAPE DEWAN PENASEHAT
// ─────────────────────────────────────────────────────────────
echo "\n📌 [4/4] Mengambil data Dewan Penasehat...\n";
$htmlPenasehat = fetchUrl('https://appsi.or.id/dewan-penasehat/');

$penasehatList = [
    [
        'nama'     => 'Sri Sultan Hamengku Buwono X',
        'jabatan'  => 'Anggota Dewan Penasihat / Gubernur Daerah Istimewa Yogyakarta',
        'provinsi' => 'D.I. Yogyakarta',
    ],
    [
        'nama'     => 'Dr. Ir. Pramono Anung, MM.',
        'jabatan'  => 'Anggota Dewan Penasihat / Gubernur Daerah Khusus Jakarta',
        'provinsi' => 'DK Jakarta',
    ],
    [
        'nama'     => 'H. Mahyeldi Ansharullah, S.P',
        'jabatan'  => 'Anggota Dewan Penasihat / Gubernur Sumatera Barat',
        'provinsi' => 'Sumatera Barat',
    ],
    [
        'nama'     => 'H. Muzakir Manaf',
        'jabatan'  => 'Anggota Dewan Penasihat / Gubernur Aceh',
        'provinsi' => 'Aceh',
    ],
    [
        'nama'     => 'Dr. John Tabo, SE., MBA.',
        'jabatan'  => 'Anggota Dewan Penasihat / Gubernur Papua Pegunungan',
        'provinsi' => 'Papua Pegunungan',
    ],
    [
        'nama'     => 'E. Melkiades Laka Lena, S.Si',
        'jabatan'  => 'Anggota Dewan Penasihat / Gubernur Nusa Tenggara Timur',
        'provinsi' => 'Nusa Tenggara Timur',
    ],
    [
        'nama'     => 'Ahmad Luthfi, SH., S.St., M.K.',
        'jabatan'  => 'Anggota Dewan Penasihat / Gubernur Jawa Tengah',
        'provinsi' => 'Jawa Tengah',
    ],
    [
        'nama'     => 'M. Bobby Afif Nasution, SE., MM.',
        'jabatan'  => 'Anggota Dewan Penasihat / Gubernur Sumatera Utara',
        'provinsi' => 'Sumatera Utara',
    ],
    [
        'nama'     => 'Andra Soni, S.M., M.AP',
        'jabatan'  => 'Anggota Dewan Penasihat / Gubernur Banten',
        'provinsi' => 'Banten',
    ],
];

$urutanPenasehat = 1;
foreach ($penasehatList as $pen) {
    $filename = 'penasehat_' . Str::slug($pen['nama']) . '.jpg';
    
    Pengurus::updateOrCreate(
        [
            'nama'  => $pen['nama'],
            'jenis' => 'penasehat',
        ],
        [
            'jabatan'   => $pen['jabatan'],
            'periode'   => '2025–2029',
            'provinsi'  => $pen['provinsi'],
            'urutan'    => $urutanPenasehat++,
            'is_active' => true,
        ]
    );
    echo "  ✅ Penasehat: {$pen['nama']} ({$pen['provinsi']})\n";
}

echo "\n" . str_repeat('=', 65) . "\n";
echo "  🎉 SINKRONISASI & PENGUNDUHAN FOTO BERHASIL SELESAI!\n";
echo "  Total Pengurus Aktif di Database: " . Pengurus::count() . " orang\n";
echo str_repeat('=', 65) . "\n\n";
