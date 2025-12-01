<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\RoleUser;

class TemuDokter extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'temu_dokter';
    protected $primaryKey = 'idreservasi_dokter';
    public $timestamps = false;

    protected $fillable = [
        'no_urut',
        'waktu_daftar',
        'status',
        'idpet',
        'idrole_user',
    ];

    protected $casts = [
        'waktu_daftar' => 'datetime',
        'no_urut' => 'integer',
    ];

    /**
     * Status constants - Workflow
     */
    const STATUS_MENUNGGU = '0';      // Baru daftar, belum dipanggil
    const STATUS_CHECKIN = '1';       // Check-in oleh perawat, rekam medis dibuat
    const STATUS_PEMERIKSAAN = '2';   // Sedang diperiksa dokter
    const STATUS_TREATMENT = '3';     // Perawat melakukan treatment sesuai instruksi dokter
    const STATUS_SELESAI = '4';       // Selesai semua treatment
    const STATUS_BATAL = '5';         // Dibatalkan

    /**
     * Get status label
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            self::STATUS_MENUNGGU => 'Menunggu',
            self::STATUS_CHECKIN => 'Check-in',
            self::STATUS_PEMERIKSAAN => 'Pemeriksaan',
            self::STATUS_TREATMENT => 'Treatment',
            self::STATUS_SELESAI => 'Selesai',
            self::STATUS_BATAL => 'Batal',
            default => 'Tidak Diketahui',
        };
    }

    /**
     * Get status color for badge
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            self::STATUS_MENUNGGU => 'yellow',
            self::STATUS_CHECKIN => 'blue',
            self::STATUS_PEMERIKSAAN => 'purple',
            self::STATUS_TREATMENT => 'indigo',
            self::STATUS_SELESAI => 'green',
            self::STATUS_BATAL => 'red',
            default => 'gray',
        };
    }

    /**
     * Check if appointment can be checked in by perawat
     */
    public function canCheckIn(): bool
    {
        return $this->status === self::STATUS_MENUNGGU;
    }

    /**
     * Check if appointment can be examined by dokter
     */
    public function canExamine(): bool
    {
        return $this->status === self::STATUS_CHECKIN;
    }

    /**
     * Check if appointment is completed
     */
    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_SELESAI;
    }

    /**
     * Relasi ke Pet
     */
    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class, 'idpet', 'idpet');
    }

    /**
     * Relasi ke User (dokter/perawat yang menangani)
     */
    public function roleUser(): BelongsTo
    {
        // `temu_dokter.idrole_user` references `role_user.idrole_user` in the schema
        return $this->belongsTo(RoleUser::class, 'idrole_user', 'idrole_user');
    }

    /**
     * Relasi ke RekamMedis
     */
    public function rekamMedis()
    {
        return $this->hasOne(RekamMedis::class, 'idreservasi_dokter', 'idreservasi_dokter');
    }

    /**
     * Scope: Filter by status
     */
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope: Filter by today
     */
    public function scopeToday($query)
    {
        return $query->whereDate('waktu_daftar', today());
    }

    /**
     * Scope: Upcoming appointments (belum selesai/batal)
     */
    public function scopeUpcoming($query)
    {
        return $query->whereIn('status', [
            self::STATUS_MENUNGGU,
            self::STATUS_CHECKIN,
            self::STATUS_PEMERIKSAAN,
            self::STATUS_TREATMENT
        ]);
    }

    /**
     * Scope: For specific pet
     */
    public function scopeForPet($query, int $idpet)
    {
        return $query->where('idpet', $idpet);
    }
}
