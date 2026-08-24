<?php

/**
 * Master Scraper Runner — APPSI Synchronization Suite
 * 
 * Penggunaan:
 *   php .tall-stack-claude-system/scrapers/run_all.php
 */

echo "\n" . str_repeat('=', 65) . "\n";
echo "  🚀 MASTER SCRAPER & SINKRONISASI DATA APPSI.OR.ID\n";
echo str_repeat('=', 65) . "\n\n";

$scrapers = [
    '1' => [
        'name' => 'Pengurus & Dewan (Pakar, Pengurus, Penasehat, Sekretariat) + Unduh Foto',
        'file' => __DIR__ . '/scrape_pengurus.php',
    ],
    '2' => [
        'name' => 'Pustaka & Dokumen Regulasi (Data BPS, AD/ART, UU, SK, Rekomendasi)',
        'file' => __DIR__ . '/scrape_pustaka.php',
    ],
    '3' => [
        'name' => 'Berita & Siaran Pers Terkini + Unduh Gambar',
        'file' => __DIR__ . '/scrape_berita.php',
    ],
    '4' => [
        'name' => '38 Provinsi & Lambang Daerah',
        'file' => __DIR__ . '/scrape_provinsi.php',
    ],
];

echo "Pilih tugas scraping yang ingin dijalankan:\n";
foreach ($scrapers as $num => $s) {
    echo "  [$num] {$s['name']}\n";
}
echo "  [A] Jalankan SEMUA scraper secara berurutan\n";
echo "  [Q] Keluar\n\n";

echo "Masukkan pilihan Anda [1/2/3/A/Q] (default: A): ";
$choice = trim(fgets(STDIN));
if (empty($choice)) $choice = 'A';

$choice = strtoupper($choice);

if ($choice === 'Q') {
    echo "Dibatalkan.\n";
    exit(0);
}

if ($choice === 'A') {
    foreach ($scrapers as $num => $s) {
        echo "\n>>> Menjalankan Scraper [$num]: {$s['name']}...\n";
        include $s['file'];
    }
} elseif (isset($scrapers[$choice])) {
    echo "\n>>> Menjalankan Scraper [$choice]: {$scrapers[$choice]['name']}...\n";
    include $scrapers[$choice]['file'];
} else {
    echo "Pilihan tidak valid.\n";
}
