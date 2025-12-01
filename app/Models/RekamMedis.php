<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\RoleUser;

class RekamMedis extends Model
{
    use SoftDeletes;

    protected $table = 'rekam_medis';
    protected $primaryKey = 'idrekam_medis';
    // The `rekam_medis` table in the SQL dump contains only a subset of fields.
    // Keep timestamps disabled to avoid Eloquent expecting `updated_at`.
    public $timestamps = false;

    // Fillable columns should reflect the actual DB columns (see database dump)
    protected $fillable = [
        'idreservasi_dokter',
        'anamesis',
        'temuan_klinis',
        'diagnosa',
        'dokter_pemeriksa',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'idrekam_medis';
    }

    /**
     * Relation to the `temu_dokter` (reservation) record.
     * `rekam_medis.idreservasi_dokter` -> `temu_dokter.idreservasi_dokter`.
     */
    public function temuDokter(): BelongsTo
    {
        return $this->belongsTo(TemuDokter::class, 'idreservasi_dokter', 'idreservasi_dokter');
    }

    /**
     * Relation to detail rekam medis (treatments/procedures)
     */
    public function details()
    {
        return $this->hasMany(DetailRekamMedis::class, 'idrekam_medis', 'idrekam_medis');
    }

    /**
     * Alias for details relation (for consistency with views)
     */
    public function detailRekamMedis()
    {
        return $this->details();
    }

    /**
     * Accessor for "tanggal_kunjungan" convenience attribute.
     * rekam_medis doesn't have a dedicated tanggal_kunjungan column in the dump,
     * so fallback to `created_at` which exists.
     */
    public function getTanggalKunjunganAttribute()
    {
        return $this->created_at;
    }
    /**
     * Backwards-compatible accessors for view/older attribute names.
     * These map the view-expected property names to the real DB columns.
     */
    public function getAnamnesaAttribute()
    {
        return $this->anamesis;
    }

    public function getPemeriksaanFisikAttribute()
    {
        return $this->temuan_klinis;
    }

    public function getDiagnosisAttribute()
    {
        return $this->diagnosa;
    }

    public function getCatatanAttribute()
    {
        return $this->attributes['catatan'] ?? null;
    }

    public function getResepObatAttribute()
    {
        return $this->attributes['resep_obat'] ?? null;
    }

    /**
     * Convenience accessors that surface related data for views.
     */
    public function getPetAttribute()
    {
        return $this->temuDokter?->pet ?? null;
    }

    public function getOwnerAttribute()
    {
        $pet = $this->pet;
        return $pet?->pemilik ?? null;
    }

    public function getDokterAttribute()
    {
        // Prefer temuDokter->roleUser -> user
        if ($this->temuDokter && $this->temuDokter->roleUser) {
            return $this->temuDokter->roleUser->user ?? $this->temuDokter->roleUser;
        }

        // Fallback: dokter_pemeriksa references role_user.idrole_user (per schema)
        if (!empty($this->dokter_pemeriksa)) {
            $ru = RoleUser::find($this->dokter_pemeriksa);
            return $ru?->user ?? $ru;
        }

        return null;
    }

    public function getPerawatAttribute()
    {
        // No dedicated perawat column in `rekam_medis` in the current schema.
        // If needed, this can map via `temuDokter` or `role_user` later.
        return null;
    }

    /**
     * Provide status label derived from related temuDokter->status
     */
    public function getStatusLabelAttribute(): string
    {
        return $this->temuDokter?->status_label ?? 'Tidak Diketahui';
    }

    /**
     * Provide status color derived from related temuDokter->status_color
     */
    public function getStatusColorAttribute(): string
    {
        return $this->temuDokter?->status_color ?? 'gray';
    }

    /**
     * Parse vital signs from anamesis field
     * Expected format: "Keluhan: xxx | Suhu: 38.5°C | Berat: 5.2kg | Detak Jantung: 120bpm"
     *
     * @return array ['keluhan' => '', 'suhu' => '', 'berat_badan' => '', 'detak_jantung' => '']
     */
    public function parseVitalSigns(): array
    {
        $vitalSigns = [
            'keluhan' => '',
            'suhu' => '',
            'berat_badan' => '',
            'detak_jantung' => ''
        ];

        if (empty($this->anamesis)) {
            return $vitalSigns;
        }

        // Split by pipe separator
        $parts = explode('|', $this->anamesis);

        foreach ($parts as $part) {
            $part = trim($part);

            if (str_starts_with($part, 'Keluhan:')) {
                $vitalSigns['keluhan'] = trim(str_replace('Keluhan:', '', $part));
            } elseif (str_starts_with($part, 'Suhu:')) {
                $vitalSigns['suhu'] = trim(str_replace('Suhu:', '', $part));
            } elseif (str_starts_with($part, 'Berat:')) {
                $vitalSigns['berat_badan'] = trim(str_replace('Berat:', '', $part));
            } elseif (str_starts_with($part, 'Detak Jantung:')) {
                $vitalSigns['detak_jantung'] = trim(str_replace('Detak Jantung:', '', $part));
            }
        }

        return $vitalSigns;
    }

    /**
     * Get formatted vital signs for display
     *
     * @return string
     */
    public function getFormattedVitalSignsAttribute(): string
    {
        $vital = $this->parseVitalSigns();

        $parts = [];
        if (!empty($vital['suhu'])) $parts[] = "Suhu: {$vital['suhu']}";
        if (!empty($vital['berat_badan'])) $parts[] = "Berat: {$vital['berat_badan']}";
        if (!empty($vital['detak_jantung'])) $parts[] = "Detak Jantung: {$vital['detak_jantung']}";

        return implode(' | ', $parts);
    }

    /**
     * Get total biaya from all detail_rekam_medis records
     *
     * @return float
     */
    public function getTotalBiayaAttribute(): float
    {
        $total = 0;

        foreach ($this->details as $detail) {
            // Parse biaya from detail field
            // Expected format: "Tindakan: xxx | Biaya: Rp 150,000"
            if (!empty($detail->detail)) {
                preg_match('/Biaya:\s*Rp\s*([\d,]+)/', $detail->detail, $matches);
                if (isset($matches[1])) {
                    // Remove comma and convert to float
                    $biaya = (float) str_replace(',', '', $matches[1]);
                    $total += $biaya;
                }
            }
        }

        return $total;
    }

    /**
     * Get formatted total biaya
     *
     * @return string
     */
    public function getFormattedTotalBiayaAttribute(): string
    {
        return 'Rp ' . number_format($this->total_biaya, 0, ',', '.');
    }

    /**
     * Format vital signs string for saving to database
     *
     * @param array $data ['keluhan' => '', 'suhu' => '', 'berat_badan' => '', 'detak_jantung' => '']
     * @return string
     */
    public static function formatVitalSigns(array $data): string
    {
        $parts = [];

        if (!empty($data['keluhan'])) {
            $parts[] = "Keluhan: {$data['keluhan']}";
        }
        if (!empty($data['suhu'])) {
            $parts[] = "Suhu: {$data['suhu']}";
        }
        if (!empty($data['berat_badan'])) {
            $parts[] = "Berat: {$data['berat_badan']}";
        }
        if (!empty($data['detak_jantung'])) {
            $parts[] = "Detak Jantung: {$data['detak_jantung']}";
        }

        return implode(' | ', $parts);
    }

}
