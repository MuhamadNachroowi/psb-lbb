<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoDiskon extends Model
{
    use HasFactory;

    protected $table = 'promo_diskon';

    protected $fillable = [
        'nama_promo',
        'deskripsi',
        'jenis_diskon',
        'nilai_diskon',
        'tanggal_mulai',
        'tanggal_selesai',
        'kuota'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];
}
