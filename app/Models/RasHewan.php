<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RasHewan extends Model
{
    use SoftDeletes;

    protected $table = 'ras_hewan';
    protected $primaryKey = 'idras_hewan';
    public $timestamps = false;

    protected $fillable = [
        'nama_ras',
        'idjenis_hewan'
    ];

    // Relationship dengan jenis hewan
    public function jenisHewan()
    {
        return $this->belongsTo(JenisHewan::class, 'idjenis_hewan', 'idjenis_hewan');
    }

    // Relationship dengan pet/hewan
    public function pets()
    {
        return $this->hasMany(Pet::class, 'idras_hewan', 'idras_hewan');
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by', 'iduser');
    }
}
