<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Berhasil - LBB Darul Ulum Jombang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .success-card {
            border-left: 5px solid #28a745;
        }
        .print-btn {
            transition: all 0.3s;
        }
        .print-btn:hover {
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card success-card shadow">
                    <div class="card-header bg-white text-center py-4">
                        <i class="fas fa-check-circle text-success fa-4x mb-3"></i>
                        <h2 class="text-success">Pendaftaran Berhasil!</h2>
                        <p class="text-muted mb-0">Terima kasih telah mendaftar di LBB Darul Ulum Jombang</p>
                    </div>
                    <div class="card-body p-4">
                        <!-- Informasi Calon Siswa -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5 class="mb-3">Data Calon Siswa</h5>
                                <table class="table table-sm">
                                    <tr>
                                        <td><strong>No. Pendaftaran</strong></td>
                                        <td>{{ $calonSiswa->no_pendaftaran }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Nama</strong></td>
                                        <td>{{ $calonSiswa->nama }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>TTL</strong></td>
                                        <td>{{ $calonSiswa->tempat_lahir }}, {{ \Carbon\Carbon::parse($calonSiswa->tanggal_lahir)->format('d/m/Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Asal Sekolah</strong></td>
                                        <td>{{ $calonSiswa->asal_sekolah }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h5 class="mb-3">Data Wali</h5>
                                <table class="table table-sm">
                                    <tr>
                                        <td><strong>Nama Wali</strong></td>
                                        <td>{{ $calonSiswa->nama_wali }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>No. HP Wali</strong></td>
                                        <td>{{ $calonSiswa->no_hp_wali }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Asrama</strong></td>
                                        <td>{{ $calonSiswa->asrama }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- Program yang Dipilih -->
                        <div class="mb-4">
                            <h5 class="mb-3">Program yang Dipilih</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Program</th>
                                            <th>Kelas</th>
                                            <th>Jenis Kelamin</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($calonSiswa->programs as $program)
                                        <tr>
                                            <td>{{ $program->nama_program }}</td>
                                            <td>
                                                @foreach($program->kelas as $kelas)
                                                    @if($kelas->id == $program->pivot->kelas_id)
                                                        {{ $kelas->nama_kelas }}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>{{ $program->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Informasi Pembayaran -->
                        <div class="mb-4">
                            <h5 class="mb-3">Informasi Pembayaran</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-sm">
                                        <tr>
                                            <td><strong>Metode Pembayaran</strong></td>
                                            <td>
                                                @if($calonSiswa->metode_pembayaran == 'lunas')
                                                    <span class="badge bg-success">Lunas di Awal</span>
                                                @elseif($calonSiswa->metode_pembayaran == 'angsur')
                                                    <span class="badge bg-warning">Angsuran</span>
                                                @else
                                                    <span class="badge bg-info">Booking</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Status Pembayaran</strong></td>
                                            <td>
                                                @if($calonSiswa->status_pembayaran == 'lunas')
                                                    <span class="badge bg-success">Lunas</span>
                                                @elseif($calonSiswa->status_pembayaran == 'angsur')
                                                    <span class="badge bg-warning">Angsur</span>
                                                @else
                                                    <span class="badge bg-secondary">Pending</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-sm">
                                        <tr>
                                            <td><strong>Total Biaya</strong></td>
                                            <td class="fw-bold">Rp {{ number_format($calonSiswa->total_biaya, 0, ',', '.') }}</td>
                                        </tr>
                                        @if($calonSiswa->diskon > 0)
                                        <tr>
                                            <td><strong>Diskon</strong></td>
                                            <td class="text-success">- Rp {{ number_format($calonSiswa->diskon, 0, ',', '.') }}</td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Instruksi Selanjutnya -->
                        <div class="alert alert-info">
                            <h6><i class="fas fa-info-circle me-2"></i>Instruksi Selanjutnya:</h6>
                            <ul class="mb-0">
                                <li>Simpan nomor pendaftaran <strong>{{ $calonSiswa->no_pendaftaran }}</strong> untuk keperluan selanjutnya</li>
                                <li>Cetak bukti pendaftaran dengan menekan tombol di bawah</li>
                                <li>Hubungi admin untuk informasi lebih lanjut mengenai pembayaran</li>
                                <li>Nomor pendaftaran ini akan menjadi NIS (Nomor Induk Siswa) Anda</li>
                            </ul>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                            <a href="{{ route('pendaftaran.cetak', $calonSiswa->no_pendaftaran) }}" target="_blank" class="btn btn-primary print-btn">
                                <i class="fas fa-print me-2"></i>Cetak Bukti Pendaftaran
                            </a>
                            <a href="{{ url('/') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-home me-2"></i>Kembali ke Beranda
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>