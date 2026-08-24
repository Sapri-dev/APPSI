<?php

/**
 * Scraper Berita & Siaran Pers APPSI
 * Sumber: https://appsi.or.id/wp-json/wp/v2/posts & https://appsi.or.id/berita-siaran-pers-terkini/
 * 
 * Penggunaan:
 *   php .tall-stack-claude-system/scrapers/scrape_berita.php
 */

require __DIR__ . '/../../vendor/autoload.php';
$app = require_once __DIR__ . '/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Berita;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

echo "\n" . str_repeat('=', 65) . "\n";
echo "  📰 SCRAPER BERITA & SIARAN PERS RESMI APPSI (appsi.or.id)\n";
echo str_repeat('=', 65) . "\n\n";

$storageDir = storage_path('app/public/berita');
if (!File::exists($storageDir)) {
    File::makeDirectory($storageDir, 0755, true);
}
$publicStorageDir = public_path('storage/berita');
if (!File::exists($publicStorageDir)) {
    File::makeDirectory($publicStorageDir, 0755, true);
}

// 1. Ambil Kategori Resmi dari WordPress API
echo "📌 Mengambil kategori resmi dari appsi.or.id...\n";
$ch = curl_init('https://appsi.or.id/wp-json/wp/v2/categories?per_page=100');
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false,
    CURLOPT_TIMEOUT        => 20,
]);
$catRes = curl_exec($ch);
curl_close($ch);
$cats = json_decode($catRes, true) ?: [];
$catMap = [];
foreach ($cats as $c) {
    $catMap[$c['id']] = $c['name'];
}

// 2. Ambil seluruh Postingan Berita dari WordPress REST API
echo "📌 Mengambil seluruh artikel berita dari REST API...\n";
$ch2 = curl_init('https://appsi.or.id/wp-json/wp/v2/posts?per_page=100&_embed=1');
curl_setopt_array($ch2, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false,
    CURLOPT_TIMEOUT        => 30,
]);
$postsRes = curl_exec($ch2);
curl_close($ch2);
$posts = json_decode($postsRes, true) ?: [];

echo "  Ditemukan " . count($posts) . " artikel resmi.\n\n";

$count = 0;
foreach ($posts as $idx => $p) {
    $postId = $p['id'];
    $rawTitle = html_entity_decode(strip_tags($p['title']['rendered'] ?? ''));
    $rawContent = $p['content']['rendered'] ?? '';
    $rawExcerpt = html_entity_decode(strip_tags($p['excerpt']['rendered'] ?? ''));
    $date = date('Y-m-d H:i:s', strtotime($p['date'] ?? now()));

    // Tentukan Kategori Resmi (Berita, Munas, Rapat Kerja Nasional, dll.)
    $categoryName = 'Berita';
    if (!empty($p['categories'])) {
        foreach ($p['categories'] as $catId) {
            if (isset($catMap[$catId]) && $catMap[$catId] !== 'Uncategorized') {
                $categoryName = $catMap[$catId];
                break;
            }
        }
    }

    // Featured Image
    $featuredImgUrl = null;
    if (isset($p['_embedded']['wp:featuredmedia'][0]['source_url'])) {
        $featuredImgUrl = $p['_embedded']['wp:featuredmedia'][0]['source_url'];
    }

    // Unduh gambar thumbnail
    $savedImage = null;
    if (!empty($featuredImgUrl)) {
        $ext = pathinfo(parse_url($featuredImgUrl, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg';
        $filename = 'berita_' . $postId . '_' . Str::slug(substr($rawTitle, 0, 30)) . '.' . $ext;
        $storagePath = storage_path('app/public/berita/' . $filename);
        $publicPath  = public_path('storage/berita/' . $filename);

        if (!File::exists($publicPath)) {
            $chImg = curl_init($featuredImgUrl);
            curl_setopt_array($chImg, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_TIMEOUT        => 20,
            ]);
            $imgData = curl_exec($chImg);
            curl_close($chImg);
            if (!empty($imgData)) {
                File::put($storagePath, $imgData);
                File::put($publicPath, $imgData);
                $savedImage = 'berita/' . $filename;
            }
        } else {
            $savedImage = 'berita/' . $filename;
        }
    }

    $slug = Str::slug($rawTitle);
    $existing = Berita::where('slug', $slug)->first();
    if (!$existing) {
        $existing = Berita::where('id', $idx + 1)->first();
    }

    $updateData = [
        'judul'             => $rawTitle,
        'slug'              => $slug,
        'ringkasan'         => Str::limit(trim($rawExcerpt), 250),
        'konten'            => $rawContent ?: '<p>' . nl2br(trim($rawExcerpt)) . '</p>',
        'kategori'          => $categoryName,
        'tanggal_publikasi' => $date,
        'is_published'      => true,
    ];
    if ($savedImage) {
        $updateData['gambar'] = $savedImage;
    }

    if ($existing) {
        $existing->update($updateData);
    } else {
        Berita::create(array_merge($updateData, ['views' => rand(60, 300)]));
    }

    $count++;
    echo "  ✅ [$count] [{$categoryName}] " . Str::limit($rawTitle, 65) . "\n";
}

echo "\n" . str_repeat('=', 65) . "\n";
echo "  🎉 Selesai! Berhasil mensinkronkan $count berita resmi & kategori ke database.\n";
echo str_repeat('=', 65) . "\n\n";
