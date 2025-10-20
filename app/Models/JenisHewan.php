<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisHewan extends Model
{
    protected $table = 'jenis_hewan';
    protected $primaryKey = 'idjenis_hewan';
    public $timestamps = false;
    protected $fillable = ['nama_jenis_hewan'];

    // Relationship dengan ras hewan
    public function rasHewan()
    {
        return $this->hasMany(RasHewan::class, 'idjenis_hewan', 'idjenis_hewan');
    }

    // Relationship dengan pet/hewan melalui ras_hewan
    public function pets()
    {
        return $this->hasManyThrough(
            Pet::class,           // Final model
            RasHewan::class,      // Intermediate model
            'idjenis_hewan',      // Foreign key on ras_hewan table
            'idras_hewan',        // Foreign key on pet table
            'idjenis_hewan',      // Local key on jenis_hewan table
            'idras_hewan'         // Local key on ras_hewan table
        );
    }
}
