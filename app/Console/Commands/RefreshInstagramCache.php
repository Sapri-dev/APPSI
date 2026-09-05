<?php

namespace App\Console\Commands;

use App\Services\InstagramService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;

class RefreshInstagramCache extends Command
{
    protected $signature   = 'instagram:refresh';
    protected $description = 'Refresh cache postingan terbaru Instagram APPSI (@appsi.or.id)';

    public function handle(): int
    {
        $this->info('🔄 Menjalankan scraper Instagram APPSI...');

        $posts = InstagramService::runScraper();

        if (empty($posts)) {
            $this->error('Gagal mengambil data dari scraper Instagram. Cek storage/logs/laravel.log.');
            return self::FAILURE;
        }

        // Simpan ke cache (6 jam)
        Cache::put('appsi_instagram_latest_posts_auto', $posts, 3600 * 6);

        $count = count($posts);
        $this->info("✅ Berhasil memperbarui {$count} postingan Instagram ke cache.");
        $this->table(
            ['Tipe', 'Kode', 'URL'],
            collect(array_slice($posts, 0, 5))->map(fn($p) => [
                strtoupper($p['type']), $p['code'], $p['url']
            ])->toArray()
        );

        return self::SUCCESS;
    }
}
