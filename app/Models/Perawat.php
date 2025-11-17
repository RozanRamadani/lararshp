<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Perawat extends Model
{
    protected $table = 'perawat';
    protected $primaryKey = 'id_perawat';
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'alamat',
        'no_hp',
        'jenis_kelamin',
        'pendidikan',
    ];

    /**
     * Relasi ke User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'iduser');
    }
}
