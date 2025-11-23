<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\RoleUser;

class RekamMedis extends Model
{
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

}
