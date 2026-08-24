<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Pustaka extends Model
{
    protected $table = 'pustaka';

    protected $fillable = [
        'judul',
        'file',
        'file_url',
        'kategori',
        'tahun',
        'deskripsi',
        'unduhan',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    // Scope published per kategori
    public function scopePublished($query)
    {
        return $query->where('is_published', true)->orderBy('tahun', 'desc')->orderBy('judul');
    }

    public function scopeByKategori($query, string $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    // Accessor URL file (prioritas storage, fallback ke url eksternal)
    protected function fileDownloadUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->file
                ? asset('storage/' . $this->file)
                : $this->file_url,
        );
    }

    // Label kategori yang ramah
    public function getLabelKategoriAttribute(): string
    {
        return match($this->kategori) {
            'uu'          => 'Undang-Undang',
            'adart'       => 'AD/ART',
            'rekomendasi' => 'Rekomendasi',
            'sk'          => 'Surat Keputusan',
            'berita_acara'=> 'Berita Acara',
            'data_bps'    => 'Data BPS',
            default       => $this->kategori,
        };
    }
}
