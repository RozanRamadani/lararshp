<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    protected $table = 'pet';
    protected $primaryKey = 'idpet';
    public $timestamps = false;
    
    protected $fillable = [
        'nama',
        'tanggal_lahir',
        'warna_tanda',
        'jenis_kelamin',
        'idpemilik',
        'idras_hewan'
    ];

    // Cast tanggal_lahir ke format date
    protected $casts = [
        'tanggal_lahir' => 'date'
    ];

    // Relationship dengan pemilik
    public function pemilik()
    {
        return $this->belongsTo(Pemilik::class, 'idpemilik', 'idpemilik');
    }

    // Relationship dengan user melalui pemilik
    public function user()
    {
        return $this->hasOneThrough(
            User::class,        
            Pemilik::class,    
            'idpemilik',        
            'iduser',           
            'idpemilik',        
            'iduser'            
        );
    }

    // Relationship dengan ras hewan
    public function rasHewan()
    {
        return $this->belongsTo(RasHewan::class, 'idras_hewan', 'idras_hewan');
    }

    // Alias untuk snake_case naming
    public function ras_hewan()
    {
        return $this->rasHewan();
    }

    // Relationship dengan jenis hewan melalui ras hewan
    public function jenisHewan()
    {
        return $this->hasOneThrough(
            JenisHewan::class,
            RasHewan::class,
            'idras_hewan',      // Foreign key on ras_hewan table
            'idjenis_hewan',    // Foreign key on jenis_hewan table
            'idras_hewan',      // Local key on pet table
            'idjenis_hewan'     // Local key on ras_hewan table
        );
    }

    // Alias untuk snake_case naming
    public function jenis_hewan()
    {
        return $this->jenisHewan();
    }

    // Relationship dengan rekam medis
    public function rekamMedis()
    {
        return $this->hasMany(RekamMedis::class, 'idpet', 'idpet');
    }

    // Alias untuk snake_case naming
    public function rekam_medis()
    {
        return $this->rekamMedis();
    }
}