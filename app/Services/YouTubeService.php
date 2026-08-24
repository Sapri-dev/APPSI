<?php

namespace App\Services;

use App\Models\Pengaturan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class YouTubeService
{
    /**
     * Fallback video default jika request gagal/offline
     */
    protected static array $fallbackVideo = [
        'id'        => 'IkTBVVKkpus',
        'title'     => 'Pra Rakernas APPSI Tahun 2023 dan Serah Terima jabatan Ketua Umum APPSI',
        'author'    => 'Asosiasi Pemerintah Provinsi Seluruh Indonesia',
        'thumbnail' => 'https://img.youtube.com/vi/IkTBVVKkpus/sddefault.jpg',
        'url'       => 'https://www.youtube.com/watch?v=IkTBVVKkpus',
    ];

    /**
     * Ambil URL channel YouTube dari pengaturan / default
     */
    public static function getChannelUrl(): string
    {
        $url = Pengaturan::get('youtube', 'https://www.youtube.com/@OfficialAPPSI');
        $url = rtrim($url, '/');
        return str_ends_with($url, '/videos') ? $url : $url . '/videos';
    }

    /**
     * Ambil video terbaru dari channel YouTube APPSI secara otomatis (Cache 3 jam)
     */
    public static function getLatestVideo(): array
    {
        return Cache::remember('appsi_youtube_latest_video_auto', 3600 * 3, function () {
            try {
                $channelUrl = self::getChannelUrl();
                $response = Http::timeout(8)
                    ->withHeaders([
                        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                        'Accept-Language' => 'id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7',
                    ])
                    ->get($channelUrl);

                if (!$response->successful()) {
                    return self::$fallbackVideo;
                }

                $html = $response->body();
                if (preg_match('/"videoId":"([a-zA-Z0-9_-]{11})"/i', $html, $m)) {
                    $videoId = $m[1];
                    $info = self::getVideoInfo($videoId);

                    if ($info && !empty($info['title'])) {
                        return [
                            'id'        => $videoId,
                            'title'     => $info['title'],
                            'author'    => $info['author_name'] ?? 'Asosiasi Pemerintah Provinsi Seluruh Indonesia',
                            'thumbnail' => "https://img.youtube.com/vi/{$videoId}/sddefault.jpg",
                            'url'       => "https://www.youtube.com/watch?v={$videoId}",
                        ];
                    }
                }

                return self::$fallbackVideo;
            } catch (\Throwable $e) {
                Log::warning('Gagal sinkronisasi YouTube APPSI: ' . $e->getMessage());
                return self::$fallbackVideo;
            }
        });
    }

    /**
     * Ambil metadata video lewat YouTube oEmbed resmi
     */
    protected static function getVideoInfo(string $videoId): ?array
    {
        try {
            $url = "https://www.youtube.com/oembed?url=https://www.youtube.com/watch?v={$videoId}&format=json";
            $res = Http::timeout(5)->get($url);
            if ($res->successful()) {
                return $res->json();
            }
        } catch (\Throwable $e) {
            // Abaikan dan gunakan fallback
        }
        return null;
    }
}
