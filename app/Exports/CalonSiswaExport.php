<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CalonSiswaExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data->map(function ($item, $key) {
            return [
                'no' => $key + 1,
                'nomor_induk' => $item->nomor_induk,
                'nama_lengkap' => $item->nama_lengkap,
                'jenis_kelamin' => $item->jenis_kelamin,
                'asal_sekolah' => $item->asal_sekolah,
                'asrama' => $item->asrama,
                'program' => $item->program,
                'kelas' => $item->kelas,
                'status_bayar' => $item->status_bayar,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'NO',
            'NOMOR INDUK',
            'NAMA LENGKAP',
            'JENIS KELAMIN',
            'ASAL SEKOLAH',
            'ASRAMA',
            'PROGRAM',
            'KELAS',
            'STATUS BAYAR'
        ];
    }
}
