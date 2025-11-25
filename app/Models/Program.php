<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $table = 'programs';

    protected $fillable = [
        'nama_program',
        'jenis_kelamin',
        'kuota',
        'biaya'
    ];

    protected $appends = ['kuota_tersedia'];

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'program_id');
    }

    public function calonSiswa()
    {
        return $this->belongsToMany(CalonSiswa::class, 'pendaftaran_program', 'program_id', 'calon_siswa_id')
            ->withPivot('kelas_id')
            ->withTimestamps();
    }

    public function getKuotaTersediaAttribute()
    {
        $terdaftar = $this->calonSiswa()->count();
        return $this->kuota - $terdaftar;
    }
}
