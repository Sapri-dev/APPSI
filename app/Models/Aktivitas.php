<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Aktivitas extends Model
{
    protected $table = 'aktivitas';

    protected $fillable = [
        'user_id',
        'user_name',
        'action',
        'module',
        'description',
        'ip_address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Helper statis untuk mencatat aktivitas admin secara otomatis.
     */
    public static function log(string $action, string $module, string $description): self
    {
        $user = Auth::user();

        return static::create([
            'user_id'     => $user?->id,
            'user_name'   => $user?->name ?? 'Sistem',
            'action'      => $action,
            'module'      => $module,
            'description' => $description,
            'ip_address'  => request()->ip(),
        ]);
    }
}
