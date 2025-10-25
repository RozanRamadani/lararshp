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
        'nama',  // Field name in custom table is 'nama', not 'name'
        'email',
        'password',
    ];

    // Add accessor to map 'nama' field to 'name' attribute for Laravel compatibility
    public function getNameAttribute()
    {
        return $this->attributes['nama'];
    }

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

    public function pemilik() {
        return $this->hasOne(Pemilik::class, 'iduser', 'iduser');
    }

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

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'iduser', 'idrole')
                    ->withPivot('status');
    }
}
