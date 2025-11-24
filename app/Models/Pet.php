<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pet extends Model
{
    use SoftDeletes;

    protected $table = 'pet';
    protected $primaryKey = 'idpet';
    public $timestamps = true;

    protected $fillable = [
        'nama',
        'tanggal_lahir',
        'warna_tanda',
        'jenis_kelamin',
        'idpemilik',
        'idras_hewan'
    ];

    // Cast tanggal_lahir ke format date
    protected $casts = [
        'tanggal_lahir' => 'date'
    ];

    // Relationship dengan pemilik
    public function pemilik()
    {
        return $this->belongsTo(Pemilik::class, 'idpemilik', 'idpemilik');
    }

    // Relationship dengan user melalui pemilik
    public function user()
    {
        return $this->hasOneThrough(
            User::class,
            Pemilik::class,
            'idpemilik',
            'iduser',
            'idpemilik',
            'iduser'
        );
    }

    // Relationship dengan ras hewan
    public function rasHewan()
    {
        return $this->belongsTo(RasHewan::class, 'idras_hewan', 'idras_hewan');
    }

    // Alias untuk snake_case naming
    public function ras_hewan()
    {
        return $this->rasHewan();
    }

    // Relationship dengan jenis hewan melalui ras hewan
    public function jenisHewan()
    {
        return $this->hasOneThrough(
            JenisHewan::class,
            RasHewan::class,
            'idras_hewan',      // Foreign key on ras_hewan table
            'idjenis_hewan',    // Foreign key on jenis_hewan table
            'idras_hewan',      // Local key on pet table
            'idjenis_hewan'     // Local key on ras_hewan table
        );
    }

    // Alias untuk snake_case naming
    public function jenis_hewan()
    {
        return $this->jenisHewan();
    }

    // Relationship dengan rekam medis (through temu_dokter)
    public function rekamMedis()
    {
        return $this->hasManyThrough(
            RekamMedis::class,
            TemuDokter::class,
            'idpet',              // Foreign key on temu_dokter table
            'idreservasi_dokter', // Foreign key on rekam_medis table
            'idpet',              // Local key on pet table
            'idreservasi_dokter'  // Local key on temu_dokter table
        );
    }

    // Alias untuk snake_case naming
    public function rekam_medis()
    {
        return $this->rekamMedis();
    }

    // Relationship dengan temu dokter (appointment)
    public function temuDokter()
    {
        return $this->hasMany(TemuDokter::class, 'idpet', 'idpet');
    }

    // Alias untuk snake_case naming
    public function temu_dokter()
    {
        return $this->temuDokter();
    }

    /**
     * Accessor to provide legacy attribute `nama_pet` used in views.
     * Returns a friendly fallback when the name is empty.
     */
    public function getNamaPetAttribute()
    {
        $name = $this->attributes['nama'] ?? null;

        // Normalize empty string to null and provide a readable fallback
        if ($name === null || $name === '') {
            return 'Tidak diketahui';
        }

        return $name;
    }

    /**
     * Accessor to map `warna` used in views to `warna_tanda` column.
     */
    public function getWarnaAttribute()
    {
        return $this->attributes['warna_tanda'] ?? null;
    }

    /**
     * Accessor to display jenis_kelamin as readable text
     * J = Jantan, B = Betina
     */
    public function getJenisKelaminReadableAttribute()
    {
        return $this->jenis_kelamin === 'J' ? 'Jantan' : 'Betina';
    }

    /**
     * Readable age helper. Returns integer years or null if tanggal_lahir missing.
     */
    public function getAgeAttribute()
    {
        if (empty($this->tanggal_lahir)) {
            return null;
        }

        return \Carbon\Carbon::parse($this->tanggal_lahir)->age;
    }

    // Fungsi untuk mendapatkan umur dalam format yang lebih mudah dibaca
    public function getAgeReadableAttribute()
    {
        // Jika tanggal_lahir kosong, kembalikan null
        if (empty($this->tanggal_lahir)) {
            return null;
        }

        // Hitung selisih tanggal lahir dengan tanggal sekarang
        $dob = \Carbon\Carbon::parse($this->tanggal_lahir);
        $now = now();

        // Komputasi tahun
        $years = $dob->diffInYears($now);
        if ($years >= 1) {
            return $years . ' tahun';
        }

        // Untuk <1 tahun, hitung bulan dan hari
        // Gunakan floatDiffInMonths jika tersedia, jika tidak, perkiraan menggunakan days/30
        if (method_exists($dob, 'floatDiffInMonths')) {
            $monthsFloat = $dob->floatDiffInMonths($now);
        } else {
            $days = $dob->diffInDays($now);
            $monthsFloat = $days / 30.0;
        }

        // Bulatkan ke bulan terdekat
        $monthsRounded = (int) round($monthsFloat);
        if ($monthsRounded >= 1) {
            return $monthsRounded . ' bulan';
        }

        // Jika kurang dari 1 bulan, hitung hari
        $days = $dob->diffInDays($now);
        if ($days >= 1) {
            return $days . ' hari';
        }

        return '<1 hari';
    }
}
