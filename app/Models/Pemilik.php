<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pemilik extends Model
{
    use SoftDeletes;

    protected $table = 'pemilik';
    protected $primaryKey = 'idpemilik';
    public $timestamps = true;
    protected $fillable = ['no_wa', 'alamat', 'iduser'];

    // Relationship dengan user
    public function user() {
        return $this->belongsTo(User::class, 'iduser', 'iduser');
    }

    // Relationship dengan pet/hewan jika ada tabel pet
    public function pets()
    {
        return $this->hasMany(Pet::class, 'idpemilik', 'idpemilik');
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by', 'iduser');
    }
}
