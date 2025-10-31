<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisHewan extends Model
{
    protected $table = 'jenis_hewan';
    protected $primaryKey = 'idjenis_hewan';
    public $timestamps = false;
    protected $fillable = ['nama_jenis_hewan'];

    // Fungsi aksesor untuk mendapatkan nama jenis hewan
    public function getNamaJenisAttribute()
    {
        return $this->attributes['nama_jenis_hewan'] ?? null;
    }

    // Relationship dengan ras hewan
    public function rasHewan()
    {
        return $this->hasMany(RasHewan::class, 'idjenis_hewan', 'idjenis_hewan');
    }

    // Relationship dengan pet/hewan melalui ras_hewan
    public function pets()
    {
        return $this->hasManyThrough(
            Pet::class,          
            RasHewan::class,      
            'idjenis_hewan',      
            'idras_hewan',        
            'idjenis_hewan',      
            'idras_hewan'  
        );
    }
}
