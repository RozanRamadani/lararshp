<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\RoleUser;

class TemuDokter extends Model
{
    use HasFactory;

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
     * Status constants
     */
    const STATUS_MENUNGGU = '0';
    const STATUS_DALAM_PROSES = '1';
    const STATUS_SELESAI = '2';
    const STATUS_BATAL = '3';

    /**
     * Get status label
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            self::STATUS_MENUNGGU => 'Menunggu',
            self::STATUS_DALAM_PROSES => 'Dalam Proses',
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
            self::STATUS_DALAM_PROSES => 'blue',
            self::STATUS_SELESAI => 'green',
            self::STATUS_BATAL => 'red',
            default => 'gray',
        };
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
        return $query->whereIn('status', [self::STATUS_MENUNGGU, self::STATUS_DALAM_PROSES]);
    }

    /**
     * Scope: For specific pet
     */
    public function scopeForPet($query, int $idpet)
    {
        return $query->where('idpet', $idpet);
    }
}
