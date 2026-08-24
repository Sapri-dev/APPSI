<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Pengaturan extends Model
{
    protected $table = 'pengaturan';

    protected $fillable = ['kunci', 'nilai'];

    /**
     * Ambil nilai pengaturan berdasarkan kunci.
     * Menggunakan cache 60 menit untuk performa.
     */
    public static function get(string $kunci, ?string $default = null): ?string
    {
        return Cache::remember("pengaturan_{$kunci}", 3600, function () use ($kunci, $default) {
            $row = static::where('kunci', $kunci)->first();
            return $row ? $row->nilai : $default;
        });
    }

    /**
     * Simpan/update nilai pengaturan dan hapus cache.
     */
    public static function set(string $kunci, ?string $nilai): void
    {
        static::updateOrCreate(['kunci' => $kunci], ['nilai' => $nilai]);
        Cache::forget("pengaturan_{$kunci}");
    }
}
