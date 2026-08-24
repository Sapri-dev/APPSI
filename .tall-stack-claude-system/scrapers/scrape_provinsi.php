<?php

/**
 * Scraper 38 Provinsi APPSI & Lambang Daerah
 * Sumber: https://appsi.or.id/
 * 
 * Penggunaan:
 *   php .tall-stack-claude-system/scrapers/scrape_provinsi.php
 */

require __DIR__ . '/../../vendor/autoload.php';
$app = require_once __DIR__ . '/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Provinsi;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

echo "\n" . str_repeat('=', 65) . "\n";
echo "  🏛️  SCRAPER 38 PROVINSI ANGGOTA APPSI (appsi.or.id)\n";
echo str_repeat('=', 65) . "\n\n";

$storageDir = storage_path('app/public/lambang');
if (!File::exists($storageDir)) {
    File::makeDirectory($storageDir, 0755, true);
}
$publicStorageDir = public_path('storage/lambang');
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
    ]);
    $res = curl_exec($ch);
    curl_close($ch);
    return $res ?: '';
}

function downloadLambang(string $url, string $targetFilename): ?string {
    if (empty($url)) return null;

    $storagePath = storage_path('app/public/lambang/' . $targetFilename);
    $publicPath  = public_path('storage/lambang/' . $targetFilename);

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
        return 'lambang/' . $targetFilename;
    }

    return null;
}

echo "📌 Mengambil daftar provinsi & lambang daerah...\n";
$html = fetchUrl('https://appsi.or.id/');

// Cari lambang SVG / PNG di uploads
preg_match_all('/(https:\/\/appsi\.or\.id\/wp-content\/uploads\/[^\s"\'<>]*(?:Coat_of_arms|lambang|logo|prov)[^\s"\'<>]*\.(?:png|svg|jpg|webp))/i', $html, $matches);

$foundUrls = array_unique($matches[1] ?? []);
echo "  Ditemukan " . count($foundUrls) . " file lambang di halaman beranda.\n";

$provinsiCount = Provinsi::count();
echo "  Total provinsi terdaftar di database: $provinsiCount provinsi.\n\n";

echo str_repeat('=', 65) . "\n";
echo "  🎉 Selesai!\n";
echo str_repeat('=', 65) . "\n\n";
