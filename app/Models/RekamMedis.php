<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RekamMedis extends Model
{
    protected $table = 'rekam_medis';
    protected $primaryKey = 'idrekam_medis';
    public $timestamps = true; // Enable timestamps (created_at, updated_at)

    protected $fillable = [
        'idpet',
        'iddokter',
        'idperawat',
        // 'tanggal_kunjungan', // TODO: Verify if this column exists in DB
        'anamnesa',
        'pemeriksaan_fisik',
        'suhu',
        'berat_badan',
        'diagnosis',
        'tindakan',
        'resep_obat',
        'catatan',
        'status',
        'tanggal_kontrol',
    ];

    protected $casts = [
        // 'tanggal_kunjungan' => 'date', // TODO: Verify if this column exists in DB
        'tanggal_kontrol' => 'date',
        'suhu' => 'decimal:2',
        'berat_badan' => 'integer',
    ];

    /**
     * Get the pet that owns the rekam medis.
     */
    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class, 'idpet', 'idpet');
    }

    /**
     * Get the dokter (user) for this rekam medis.
     */
    public function dokter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'iddokter', 'iduser');
    }

    /**
     * Get the perawat (user) for this rekam medis.
     */
    public function perawat(): BelongsTo
    {
        return $this->belongsTo(User::class, 'idperawat', 'iduser');
    }

    /**
     * Get status label with color
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'menunggu' => 'Menunggu',
            'dalam_perawatan' => 'Dalam Perawatan',
            'selesai' => 'Selesai',
            'rujukan' => 'Rujukan',
            default => 'Unknown',
        };
    }

    /**
     * Get status color for badge
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'menunggu' => 'yellow',
            'dalam_perawatan' => 'blue',
            'selesai' => 'green',
            'rujukan' => 'red',
            default => 'gray',
        };
    }

    /**
     * Accessor for tanggal_kunjungan - fallback to created_at
     * This is a temporary solution until the actual column is confirmed
     */
    public function getTanggalKunjunganAttribute()
    {
        // If the column exists in DB, return it
        if (isset($this->attributes['tanggal_kunjungan'])) {
            return \Carbon\Carbon::parse($this->attributes['tanggal_kunjungan']);
        }

        // Fallback to created_at timestamp
        return $this->created_at;
    }
}
