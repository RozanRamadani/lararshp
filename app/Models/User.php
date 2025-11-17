<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $table = 'user';
    protected $primaryKey = 'iduser';
    public $timestamps = false; // Disable Laravel timestamps if table doesn't have created_at/updated_at
    protected $fillable = [
        'nama',
        'email',
        'password',
        'no_wa',
        'kota',
        'idrole',
    ];

    // Aksesor dan Mutator untuk nama
    public function getNameAttribute()
    {
        return $this->attributes['nama'] ?? null;
    }

    // Mutator untuk nama
    public function setNameAttribute($value)
    {
        $this->attributes['nama'] = $value;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationship dengan pemilik
    public function pemilik() {
        return $this->hasOne(Pemilik::class, 'iduser', 'iduser');
    }

    // Relationship dengan dokter
    public function dokter() {
        return $this->hasOne(Dokter::class, 'id_user', 'iduser');
    }

    // Relationship dengan perawat
    public function perawat() {
        return $this->hasOne(Perawat::class, 'id_user', 'iduser');
    }

    // Relationship dengan pet/hewan melalui pemilik
    public function pets()
    {
        return $this->hasManyThrough(
            Pet::class,
            Pemilik::class,
            'iduser',
            'idpemilik',
            'iduser',
            'idpemilik'
        );
    }

    // Relationship dengan role melalui tabel pivot role_user
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'iduser', 'idrole')
                    ->withPivot('status');
    }

    // Cek apakah user memiliki role tertentu (aktif)
    public function hasRole(string $roleName): bool
    {
        return $this->roles()
            ->where('nama_role', $roleName)
            ->wherePivot('status', 1) // hanya role yang aktif
            ->exists();
    }

    // Cek apakah user memiliki salah satu dari beberapa role (aktif)
    public function hasAnyRole(array $roleNames): bool
    {
        return $this->roles()
            ->whereIn('nama_role', $roleNames)
            ->wherePivot('status', 1) // hanya role yang aktif
            ->exists();
    }

    // Cek apakah user memiliki semua role yang disebutkan (aktif)
    public function hasAllRoles(array $roleNames): bool
    {
        $userRoles = $this->roles()
            ->whereIn('nama_role', $roleNames)
            ->wherePivot('status', 1)
            ->pluck('nama_role')
            ->toArray();

        return count($userRoles) === count($roleNames);
    }

    // Ambil nama role pertama yang aktif
    public function getPrimaryRoleName(): ?string
    {
        $role = $this->roles()
            ->wherePivot('status', 1)
            ->first();

        return $role ? $role->nama_role : null;
    }

    // Ambil semua nama role yang aktif
    public function getActiveRoleNames(): array
    {
        return $this->roles()
            ->wherePivot('status', 1)
            ->pluck('nama_role')
            ->toArray();
    }
}
