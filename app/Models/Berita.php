<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class Berita extends Model
{
    protected $table = 'berita';

    protected $fillable = [
        'judul',
        'slug',
        'ringkasan',
        'konten',
        'gambar',
        'kategori',
        'tanggal_publikasi',
        'is_published',
        'views',
    ];

    protected $casts = [
        'tanggal_publikasi' => 'date',
        'is_published' => 'boolean',
    ];

    // Auto-generate slug saat judul diisi
    protected static function booted(): void
    {
        static::creating(function ($berita) {
            if (empty($berita->slug)) {
                $berita->slug = Str::slug($berita->judul);
            }
        });
    }

    // Scope untuk yang sudah dipublikasikan
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                     ->orderBy('tanggal_publikasi', 'desc');
    }

    // Accessor URL gambar
    protected function gambarUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->gambar
                ? asset('storage/' . $this->gambar)
                : asset('images/placeholder-berita.jpg'),
        );
    }

    // Tambah view count
    public function incrementViews(): void
    {
        $this->increment('views');
    }
}
