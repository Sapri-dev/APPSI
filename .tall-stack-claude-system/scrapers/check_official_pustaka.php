<?php
require __DIR__ . '/vendor/autoload.php';

function fetch($url) {
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
    $res = curl_exec($ch);
    curl_close($ch);
    return $res;
}

// Let's check homepage or pustaka pages
$urls = [
    'https://appsi.or.id/',
    'https://appsi.or.id/pustaka/',
    'https://appsi.or.id/undang-undang/',
    'https://appsi.or.id/ad-art/',
    'https://appsi.or.id/rekomendasi/',
    'https://appsi.or.id/sk/',
    'https://appsi.or.id/berita-acara/',
    'https://appsi.or.id/data-bps/',
];

foreach ($urls as $url) {
    $html = fetch($url);
    echo "=== URL: $url (length: " . strlen($html) . ") ===\n";
    if ($html) {
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        libxml_clear_errors();
        $xpath = new DOMXPath($dom);

        // Find elements, images, titles, tables, cards
        foreach ($xpath->query('//h1|//h2|//h3|//h4|//div[contains(@class, "elementor")]//a') as $el) {
            $t = trim($el->textContent);
            if (strlen($t) > 3 && strlen($t) < 120) {
                if (str_contains($t, 'BPS') || str_contains($t, 'Undang') || str_contains($t, 'AD/ART') || str_contains($t, 'Pustaka') || str_contains($t, 'Buku') || str_contains($t, 'Dalam Angka')) {
                    echo "  [{$el->nodeName}] $t\n";
                }
            }
        }
    }
}
