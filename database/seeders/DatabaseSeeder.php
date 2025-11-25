<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Program;
use App\Models\Kelas; // Pastikan ini di-import
use App\Models\Article;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create admin users
        User::create([
            'name' => 'Operator LBB',
            'email' => 'operator@lbbdarululum.com',
            'password' => Hash::make('password123'),
            'role' => 'operator'
        ]);

        User::create([
            'name' => 'Keuangan LBB',
            'email' => 'keuangan@lbbdarululum.com',
            'password' => Hash::make('password123'),
            'role' => 'keuangan'
        ]);

        // Create sample programs
        $programs = [
            [
                'nama_program' => 'Program Reguler SD',
                'jenis_kelamin' => 'L',
                'kuota' => 25,
                'biaya' => 500000
            ],
            [
                'nama_program' => 'Program Reguler SD',
                'jenis_kelamin' => 'P',
                'kuota' => 25,
                'biaya' => 500000
            ],
            [
                'nama_program' => 'Program Intensif SMP',
                'jenis_kelamin' => 'L',
                'kuota' => 25,
                'biaya' => 750000
            ],
            [
                'nama_program' => 'Program Intensif SMP',
                'jenis_kelamin' => 'P',
                'kuota' => 25,
                'biaya' => 750000
            ],
            [
                'nama_program' => 'Program Persiapan UN SMA',
                'jenis_kelamin' => 'L',
                'kuota' => 25,
                'biaya' => 1000000
            ],
            [
                'nama_program' => 'Program Persiapan UN SMA',
                'jenis_kelamin' => 'P',
                'kuota' => 25,
                'biaya' => 1000000
            ]
        ];

        foreach ($programs as $program) {
            $newProgram = Program::create($program);

            // Create classes for each program
            for ($i = 1; $i <= 3; $i++) {
                Kelas::create([
                    'program_id' => $newProgram->id,
                    'nama_kelas' => 'Kelas ' . $i, // Diperbaiki dari 'name_kelas' menjadi 'nama_kelas'
                    'kuota' => 25
                ]);
            }
        }

        // Create sample articles
        Article::create([
            'judul' => 'Selamat Datang di LBB Darul Ulum Jombang',
            'konten' => '<p>LBB Darul Ulum Jombang merupakan lembaga bimbingan belajar yang berkomitmen untuk mencetak generasi yang cerdas dan berakhlak mulia.</p>',
            'jenis' => 'profil',
            'gambar' => null
        ]);

        Article::create([
            'judul' => 'Pendaftaran Tahun Ajaran 2024/2025 Dibuka',
            'konten' => '<p>Segera daftarkan putra-putri Anda untuk tahun ajaran baru 2024/2025. Dapatkan promo spesial untuk pendaftaran bulan ini!</p>',
            'jenis' => 'pengumuman',
            'gambar' => null
        ]);
    }
}
