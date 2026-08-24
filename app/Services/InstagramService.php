<?php

namespace App\Services;

use App\Models\Pengaturan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;

class InstagramService
{
    /**
     * Fallback posts resmi APPSI jika server scraper offline/pertama kali dimuat
     */
    protected static array $fallbackPosts = [
        [
            'type'      => 'reel',
            'code'      => 'DbU3AhWJEjz',
            'url'       => 'https://www.instagram.com/reel/DbU3AhWJEjz/',
            'embed_url' => 'https://www.instagram.com/reel/DbU3AhWJEjz/embed/',
        ],
        [
            'type'      => 'p',
            'code'      => 'DbN6NMzCR1G',
            'url'       => 'https://www.instagram.com/p/DbN6NMzCR1G/',
            'embed_url' => 'https://www.instagram.com/p/DbN6NMzCR1G/embed/',
        ],
        [
            'type'      => 'reel',
            'code'      => 'Da-c4xjJ6DA',
            'url'       => 'https://www.instagram.com/reel/Da-c4xjJ6DA/',
            'embed_url' => 'https://www.instagram.com/reel/Da-c4xjJ6DA/embed/',
        ],
        [
            'type'      => 'p',
            'code'      => 'Dac0xbvp4fo',
            'url'       => 'https://www.instagram.com/p/Dac0xbvp4fo/',
            'embed_url' => 'https://www.instagram.com/p/Dac0xbvp4fo/embed/',
        ],
    ];

    /**
     * Ambil postingan terbaru Instagram APPSI secara otomatis (Cache 6 jam)
     */
    public static function getLatestPosts(int $limit = 4): array
    {
        $posts = Cache::remember('appsi_instagram_latest_posts_auto', 3600 * 6, function () {
            try {
                $scriptPath = base_path('resources/scripts/scrape_instagram.cjs');
                if (!file_exists($scriptPath)) {
                    return self::$fallbackPosts;
                }

                $process = new Process(['node', $scriptPath]);
                $process->setTimeout(30);
                $process->run();

                if ($process->isSuccessful()) {
                    $output = trim($process->getOutput());
                    $data = json_decode($output, true);
                    if (!empty($data['status']) && $data['status'] === 'success' && !empty($data['posts'])) {
                        return $data['posts'];
                    }
                }
            } catch (\Throwable $e) {
                Log::warning('Gagal sinkronisasi Instagram APPSI: ' . $e->getMessage());
            }

            return self::$fallbackPosts;
        });

        return array_slice($posts, 0, $limit);
    }
}
