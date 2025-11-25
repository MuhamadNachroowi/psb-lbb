<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';

    protected $fillable = [
        'program_id',
        'nama_kelas',
        'kuota'
    ];

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function calonSiswa()
    {
        return $this->belongsToMany(CalonSiswa::class, 'pendaftaran_program', 'kelas_id', 'calon_siswa_id');
    }
}
