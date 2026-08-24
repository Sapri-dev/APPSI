<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Pengurus extends Model
{
    protected $table = 'pengurus';

    protected $fillable = [
        'nama',
        'jabatan',
        'foto',
        'jenis',
        'periode',
        'provinsi',
        'bio',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Scope per jenis
    public function scopePengurus($query)
    {
        return $query->where('jenis', 'pengurus')->where('is_active', true)->orderBy('urutan');
    }

    public function scopePenasehat($query)
    {
        return $query->where('jenis', 'penasehat')->where('is_active', true)->orderBy('urutan');
    }

    public function scopePakar($query)
    {
        return $query->where('jenis', 'pakar')->where('is_active', true)->orderBy('urutan');
    }

    public function scopeSekretariat($query)
    {
        return $query->where('jenis', 'sekretariat')->where('is_active', true)->orderBy('urutan');
    }

    // Accessor URL foto
    protected function fotoUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->foto
                ? asset('storage/' . $this->foto)
                : asset('images/placeholder-avatar.png'),
        );
    }

    // Label jenis yang ramah
    public function getLabelJenisAttribute(): string
    {
        return match($this->jenis) {
            'pengurus'   => 'Dewan Pengurus',
            'penasehat'  => 'Dewan Penasehat',
            'pakar'      => 'Dewan Pakar',
            'sekretariat'=> 'Sekretariat',
            default      => $this->jenis,
        };
    }
}
