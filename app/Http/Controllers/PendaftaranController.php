<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CalonSiswa;
use App\Models\Program;
use App\Models\Kelas;
use App\Models\PendaftaranProgram;
use App\Models\PromoDiskon;

class PendaftaranController extends Controller
{
    public function create()
    {
        $programs = Program::with(['kelas' => function ($query) {
            $query->where('kuota', '>', 0);
        }])->get();

        $promo = PromoDiskon::where('tanggal_mulai', '<=', now())
            ->where('tanggal_selesai', '>=', now())
            ->get();

        return view('pendaftaran.form', compact('programs', 'promo'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'asal_sekolah' => 'required|string|max:255',
            'asrama' => 'required|string|max:255',
            'nama_wali' => 'required|string|max:255',
            'no_hp_wali' => 'required|string|max:15',
            'jenis_kelamin' => 'required|in:L,P',
            'program_id' => 'required|array|min:1|max:2',
            'program_id.*' => 'exists:programs,id',
            'kelas_id' => 'required|array',
            'kelas_id.*' => 'exists:kelas,id',
            'metode_pembayaran' => 'required|in:lunas,angsur,boking'
        ]);

        // Cek kuota program
        foreach ($request->program_id as $programId) {
            $program = Program::find($programId);
            if ($program->kuota_tersedia <= 0) {
                return back()->withErrors(['error' => 'Kuota program ' . $program->nama_program . ' sudah penuh']);
            }
        }

        // Generate nomor pendaftaran
        $noPendaftaran = CalonSiswa::generateNoPendaftaran();

        // Hitung total biaya
        $totalBiaya = 0;
        foreach ($request->program_id as $programId) {
            $program = Program::find($programId);
            $totalBiaya += $program->biaya;
        }

        // Apply diskon jika ada
        $diskon = 0;
        $promoAktif = PromoDiskon::where('tanggal_mulai', '<=', now())
            ->where('tanggal_selesai', '>=', now())
            ->first();

        if ($promoAktif) {
            if ($promoAktif->jenis_diskon == 'persentase') {
                $diskon = ($totalBiaya * $promoAktif->nilai_diskon) / 100;
            } else {
                $diskon = $promoAktif->nilai_diskon;
            }
            $totalBiaya -= $diskon;
        }

        // Simpan data calon siswa
        $calonSiswa = CalonSiswa::create([
            'no_pendaftaran' => $noPendaftaran,
            'nama' => $request->nama,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'asal_sekolah' => $request->asal_sekolah,
            'asrama' => $request->asrama,
            'nama_wali' => $request->nama_wali,
            'no_hp_wali' => $request->no_hp_wali,
            'jenis_kelamin' => $request->jenis_kelamin,
            'metode_pembayaran' => $request->metode_pembayaran,
            'total_biaya' => $totalBiaya,
            'diskon' => $diskon
        ]);

        // Simpan program yang dipilih
        foreach ($request->program_id as $index => $programId) {
            PendaftaranProgram::create([
                'calon_siswa_id' => $calonSiswa->id,
                'program_id' => $programId,
                'kelas_id' => $request->kelas_id[$index]
            ]);
        }

        return redirect()->route('pendaftaran.success', $calonSiswa->no_pendaftaran);
    }

    public function success($noPendaftaran)
    {
        $calonSiswa = CalonSiswa::with(['programs.kelas', 'pendaftaranProgram'])
            ->where('no_pendaftaran', $noPendaftaran)
            ->firstOrFail();

        return view('pendaftaran.success', compact('calonSiswa'));
    }

    public function cetakBukti($noPendaftaran)
    {
        $calonSiswa = CalonSiswa::with(['programs.kelas', 'pendaftaranProgram'])
            ->where('no_pendaftaran', $noPendaftaran)
            ->firstOrFail();

        return view('pendaftaran.cetak', compact('calonSiswa'));
    }
}
