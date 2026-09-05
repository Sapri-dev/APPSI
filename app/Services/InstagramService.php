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
            'type'      => 'p',
            'code'      => 'Dc0B6feieSa',
            'url'       => 'https://www.instagram.com/p/Dc0B6feieSa/',
            'embed_url' => 'https://www.instagram.com/p/Dc0B6feieSa/embed/',
        ],
        [
            'type'      => 'p',
            'code'      => 'DcvzLznCREB',
            'url'       => 'https://www.instagram.com/p/DcvzLznCREB/',
            'embed_url' => 'https://www.instagram.com/p/DcvzLznCREB/embed/',
        ],
        [
            'type'      => 'reel',
            'code'      => 'Dck-YwopjpA',
            'url'       => 'https://www.instagram.com/reel/Dck-YwopjpA/',
            'embed_url' => 'https://www.instagram.com/reel/Dck-YwopjpA/embed/',
        ],
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
    ];

    /**
     * Cari path binary Node.js yang tersedia di sistem (Windows / Linux)
     */
    public static function getNodeBinary(): string
    {
        $candidates = [
            'C:\\Program Files\\nodejs\\node.exe',
            'C:\\laragon\\bin\\nodejs\\node-v22\\node.exe',
            'C:\\laragon\\bin\\nodejs\\node\\node.exe',
            '/usr/bin/node',
            '/usr/local/bin/node',
        ];

        foreach ($candidates as $cand) {
            if (file_exists($cand)) {
                return $cand;
            }
        }

        return 'node';
    }

    /**
     * Jalankan scraper Puppeteer dengan environment yang aman untuk Windows / Linux.
     *
     * PENTING: Symfony Process dengan $env parameter akan MENGGANTIKAN (bukan merge)
     * seluruh environment proses induk. Pada Windows, Node.js v22+ memerlukan
     * SystemRoot dan windir agar BCryptGenRandom / CSPRNG dapat berjalan.
     * Solusi: ambil seluruh env saat ini via getenv(null) lalu override key Windows wajib.
     */
    public static function runScraper(): ?array
    {
        $scriptPath = base_path('resources/scripts/scrape_instagram.cjs');
        if (!file_exists($scriptPath)) {
            Log::warning('InstagramService: Script scraper tidak ditemukan di ' . $scriptPath);
            return null;
        }

        // Mulai dari seluruh environment proses PHP saat ini, lalu tambahkan/override
        // key Windows yang wajib ada agar Node.js bisa menginisialisasi CSPRNG.
        $currentEnv = getenv();           // ambil semua env aktif sebagai array
        if (!is_array($currentEnv)) {
            $currentEnv = [];
        }

        $systemRoot = getenv('SystemRoot') ?: getenv('SYSTEMROOT') ?: 'C:\\Windows';
        $windowsOverrides = [
            'SystemRoot'   => $systemRoot,
            'SYSTEMROOT'   => $systemRoot,
            'windir'       => getenv('windir') ?: $systemRoot,
            'PATH'         => getenv('PATH') ?: ('C:\\Windows\\system32;C:\\Windows;' . dirname(self::getNodeBinary())),
            'TEMP'         => getenv('TEMP') ?: 'C:\\Windows\\Temp',
            'TMP'          => getenv('TMP') ?: 'C:\\Windows\\Temp',
            'USERPROFILE'  => getenv('USERPROFILE') ?: 'C:\\Users\\Default',
            'LOCALAPPDATA' => getenv('LOCALAPPDATA') ?: '',
            'APPDATA'      => getenv('APPDATA') ?: '',
            'HOMEDRIVE'    => getenv('HOMEDRIVE') ?: 'C:',
            'HOMEPATH'     => getenv('HOMEPATH') ?: '\\Users\\Default',
            'COMSPEC'      => getenv('COMSPEC') ?: 'C:\\Windows\\system32\\cmd.exe',
        ];

        // Merge: env saat ini sebagai base, override dengan key Windows wajib
        $env = array_merge($currentEnv, $windowsOverrides);

        try {
            $nodeBinary = self::getNodeBinary();
            Log::info('InstagramService: Menjalankan scraper dengan node=' . $nodeBinary);

            $process = new Process([$nodeBinary, $scriptPath], base_path(), $env);
            $process->setTimeout(60);
            $process->run();

            if ($process->isSuccessful()) {
                $output = trim($process->getOutput());
                $data = json_decode($output, true);
                if (!empty($data['status']) && $data['status'] === 'success' && !empty($data['posts'])) {
                    Log::info('InstagramService: Berhasil mendapatkan ' . count($data['posts']) . ' posts.');
                    return $data['posts'];
                }
                Log::warning('InstagramService: Output scraper tidak valid: ' . substr($output, 0, 500));
            } else {
                $exitCode = $process->getExitCode();
                $errOut   = $process->getErrorOutput() ?: $process->getOutput();
                Log::warning("InstagramService: Scraper gagal (exit={$exitCode}): " . substr($errOut, 0, 500));
            }
        } catch (\Throwable $e) {
            Log::error('InstagramService exception: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Ambil postingan terbaru Instagram APPSI secara otomatis (Cache 6 jam)
     */
    public static function getLatestPosts(int $limit = 4): array
    {
        $posts = Cache::remember('appsi_instagram_latest_posts_auto', 3600 * 6, function () {
            $scraped = self::runScraper();
            return $scraped ?: self::$fallbackPosts;
        });

        return array_slice($posts, 0, $limit);
    }
}
