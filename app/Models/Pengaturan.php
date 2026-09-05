<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

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

    /**
     * URL Logo Utama Website (Horizontal).
     */
    public static function logo(): string
    {
        $custom = static::get('logo_utama');
        if ($custom && Storage::disk('public')->exists($custom)) {
            return asset('storage/' . $custom);
        }
        return asset('images/Logo-appsi.png');
    }

    /**
     * URL Logo Emblem / Favicon Website (Kotak/Simbol).
     */
    public static function emblem(): string
    {
        $custom = static::get('logo_emblem');
        if ($custom && Storage::disk('public')->exists($custom)) {
            return asset('storage/' . $custom);
        }
        return asset('images/Logo-appsi-emblem.png');
    }
}
