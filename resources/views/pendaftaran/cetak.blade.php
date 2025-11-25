<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Bukti Pendaftaran - {{ $calonSiswa->no_pendaftaran }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                font-size: 12px;
            }
            .card {
                border: 1px solid #000 !important;
            }
        }
        .header-print {
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .table-print {
            width: 100%;
            border-collapse: collapse;
        }
        .table-print th, .table-print td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }
        .table-print th {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header-print text-center">
            <h3>LBB DARUL ULUM JOMBANG</h3>
            <p>Jl. Contoh No. 123, Jombang - Telp: (0321) 123456</p>
            <h4>BUKTI PENDAFTARAN</h4>
        </div>

        <!-- Informasi Calon Siswa -->
        <div class="row mb-3">
            <div class="col-md-6">
                <table class="table table-sm table-bordered">
                    <tr>
                        <td><strong>No. Pendaftaran</strong></td>
                        <td>{{ $calonSiswa->no_pendaftaran }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Daftar</strong></td>
                        <td>{{ $calonSiswa->created_at->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Nama Lengkap</strong></td>
                        <td>{{ $calonSiswa->nama }}</td>
                    </tr>
                    <tr>
                        <td><strong>TTL</strong></td>
                        <td>{{ $calonSiswa->tempat_lahir }}, {{ \Carbon\Carbon::parse($calonSiswa->tanggal_lahir)->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Jenis Kelamin</strong></td>
                        <td>{{ $calonSiswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-sm table-bordered">
                    <tr>
                        <td><strong>Asal Sekolah</strong></td>
                        <td>{{ $calonSiswa->asal_sekolah }}</td>
                    </tr>
                    <tr>
                        <td><strong>Asrama</strong></td>
                        <td>{{ $calonSiswa->asrama }}</td>
                    </tr>
                    <tr>
                        <td><strong>Nama Wali</strong></td>
                        <td>{{ $calonSiswa->nama_wali }}</td>
                    </tr>
                    <tr>
                        <td><strong>No. HP Wali</strong></td>
                        <td>{{ $calonSiswa->no_hp_wali }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Program yang Dipilih -->
        <div class="mb-3">
            <h5>Program yang Dipilih</h5>
            <table class="table table-sm table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Program</th>
                        <th>Kelas</th>
                        <th>Jenis Kelamin</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($calonSiswa->programs as $index => $program)
                    <tr>
                        <td>{{ $index + 1 }}</td>
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

        <!-- Informasi Pembayaran -->
        <div class="mb-3">
            <h5>Informasi Pembayaran</h5>
            <table class="table table-sm table-bordered">
                <tr>
                    <td><strong>Metode Pembayaran</strong></td>
                    <td>
                        @if($calonSiswa->metode_pembayaran == 'lunas')
                            Lunas di Awal
                        @elseif($calonSiswa->metode_pembayaran == 'angsur')
                            Angsuran
                        @else
                            Booking (Bayar Nanti)
                        @endif
                    </td>
                </tr>
                <tr>
                    <td><strong>Status Pembayaran</strong></td>
                    <td>
                        @if($calonSiswa->status_pembayaran == 'lunas')
                            LUNAS
                        @elseif($calonSiswa->status_pembayaran == 'angsur')
                            ANGSURAN
                        @else
                            MENUNGGU PEMBAYARAN
                        @endif
                    </td>
                </tr>
                <tr>
                    <td><strong>Total Biaya</strong></td>
                    <td><strong>Rp {{ number_format($calonSiswa->total_biaya, 0, ',', '.') }}</strong></td>
                </tr>
                @if($calonSiswa->diskon > 0)
                <tr>
                    <td><strong>Diskon</strong></td>
                    <td class="text-success">Rp {{ number_format($calonSiswa->diskon, 0, ',', '.') }}</td>
                </tr>
                @endif
            </table>
        </div>

        <!-- Keterangan -->
        <div class="alert alert-warning">
            <h6>Keterangan:</h6>
            <ul class="mb-0">
                <li>Bukti pendaftaran ini sah sebagai tanda bukti pendaftaran</li>
                <li>Nomor pendaftaran <strong>{{ $calonSiswa->no_pendaftaran }}</strong> akan menjadi NIS</li>
                <li>Simpan bukti ini untuk keperluan administrasi selanjutnya</li>
                <li>Hubungi admin untuk informasi lebih lanjut</li>
            </ul>
        </div>

        <!-- Tanda Tangan -->
        <div class="row mt-4">
            <div class="col-md-6 text-center">
                <p>Hormat Kami,</p>
                <br><br><br>
                <p><strong>Admin LBB Darul Ulum</strong></p>
            </div>
            <div class="col-md-6 text-center">
                <p>Jombang, {{ date('d F Y') }}</p>
                <br><br><br>
                <p><strong>{{ $calonSiswa->nama }}</strong></p>
            </div>
        </div>

        <!-- Print Button -->
        <div class="no-print text-center mt-4">
            <button onclick="window.print()" class="btn btn-primary">
                <i class="fas fa-print me-2"></i>Cetak
            </button>
            <a href="{{ route('pendaftaran.success', $calonSiswa->no_pendaftaran) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <script>
        // Auto print ketika halaman dimuat
        window.onload = function() {
            // Optional: auto print
            // window.print();
        };
    </script>
</body>
</html>