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
        'detail',
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

    /**
     * Parse tindakan and biaya from detail field
     * Expected format: "Tindakan: xxx | Biaya: Rp 150,000"
     *
     * @return array ['tindakan' => '', 'biaya' => 0]
     */
    public function parseTindakanBiaya(): array
    {
        $result = [
            'tindakan' => '',
            'biaya' => 0
        ];

        if (empty($this->detail)) {
            return $result;
        }

        // Split by pipe separator
        $parts = explode('|', $this->detail);

        foreach ($parts as $part) {
            $part = trim($part);

            if (str_starts_with($part, 'Tindakan:')) {
                $result['tindakan'] = trim(str_replace('Tindakan:', '', $part));
            } elseif (str_starts_with($part, 'Biaya:')) {
                // Extract number from "Biaya: Rp 150,000"
                preg_match('/Rp\s*([\d,]+)/', $part, $matches);
                if (isset($matches[1])) {
                    $result['biaya'] = (float) str_replace(',', '', $matches[1]);
                }
            }
        }

        return $result;
    }

    /**
     * Get biaya as float
     *
     * @return float
     */
    public function getBiayaAttribute(): float
    {
        $parsed = $this->parseTindakanBiaya();
        return $parsed['biaya'];
    }

    /**
     * Get formatted biaya
     *
     * @return string
     */
    public function getFormattedBiayaAttribute(): string
    {
        return 'Rp ' . number_format($this->biaya, 0, ',', '.');
    }

    /**
     * Get tindakan text only
     *
     * @return string
     */
    public function getTindakanAttribute(): string
    {
        $parsed = $this->parseTindakanBiaya();
        return $parsed['tindakan'];
    }

    /**
     * Format tindakan and biaya string for saving to database
     *
     * @param string $tindakan
     * @param float $biaya
     * @return string
     */
    public static function formatTindakanBiaya(string $tindakan, float $biaya): string
    {
        $formattedBiaya = number_format($biaya, 0, ',', '.');
        return "Tindakan: {$tindakan} | Biaya: Rp {$formattedBiaya}";
    }
}
