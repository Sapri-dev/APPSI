<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesan extends Model
{
    protected $fillable = ['nama', 'email', 'subjek', 'pesan', 'status'];

    public function scopeBaru($query)
    {
        return $query->where('status', 'baru');
    }

    public function scopeDibaca($query)
    {
        return $query->where('status', 'dibaca');
    }

    public function markAsDibaca(): void
    {
        if ($this->status === 'baru') {
            $this->update(['status' => 'dibaca']);
        }
    }
}
