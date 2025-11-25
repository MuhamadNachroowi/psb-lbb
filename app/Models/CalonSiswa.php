<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalonSiswa extends Model
{
    use HasFactory;

    // Tentukan nama tabel secara eksplisit
    protected $table = 'calon_siswa';

    protected $fillable = [
        'no_pendaftaran',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'asal_sekolah',
        'asrama',
        'nama_wali',
        'no_hp_wali',
        'jenis_kelamin',
        'metode_pembayaran',
        'status_pembayaran',
        'diskon',
        'total_biaya'
    ];

    public function programs()
    {
        return $this->belongsToMany(Program::class, 'pendaftaran_program', 'calon_siswa_id', 'program_id')
            ->withPivot('kelas_id')
            ->withTimestamps();
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'calon_siswa_id');
    }

    public function pendaftaranProgram()
    {
        return $this->hasMany(PendaftaranProgram::class, 'calon_siswa_id');
    }

    public static function generateNoPendaftaran()
    {
        $year = date('Y');
        $month = date('m');
        $lastStudent = self::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('id', 'desc')
            ->first();

        $number = $lastStudent ? intval(substr($lastStudent->no_pendaftaran, -4)) + 1 : 1;
        return 'LBB-' . $year . $month . '-' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}
