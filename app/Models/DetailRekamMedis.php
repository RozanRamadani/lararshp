<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailRekamMedis extends Model
{
    protected $table = 'detail_rekam_medis';
    protected $primaryKey = 'iddetail_rekam_medis';
    public $timestamps = false;

    protected $fillable = [
        'idrekam_medis',
        'idkode_tindakan_terapi',
        'keterangan',
    ];

    /**
     * Relation to RekamMedis
     */
    public function rekamMedis(): BelongsTo
    {
        return $this->belongsTo(RekamMedis::class, 'idrekam_medis', 'idrekam_medis');
    }

    /**
     * Relation to KodeTindakanTerapi
     */
    public function kodeTindakanTerapi(): BelongsTo
    {
        return $this->belongsTo(KodeTindakanTerapi::class, 'idkode_tindakan_terapi', 'idkode_tindakan_terapi');
    }
}
