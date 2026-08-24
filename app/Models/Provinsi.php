<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Provinsi extends Model
{
    protected $table = 'provinsi';

    protected $fillable = [
        'nama',
        'ibu_kota',
        'gubernur',
        'lambang',
        'pulau',
        'urutan',
        'website',
    ];

    // Accessor URL lambang
    protected function lambangUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->lambang
                ? asset('storage/' . $this->lambang)
                : asset('images/placeholder-lambang.png'),
        );
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan')->orderBy('nama');
    }
}
