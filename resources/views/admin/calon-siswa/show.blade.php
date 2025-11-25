@extends('layouts.admin')

@section('title', 'Detail Calon Siswa - ' . $calonSiswa->nama)

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Calon Siswa</h1>
        <a href="{{ route('admin.calon-siswa') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Data Pribadi</h6>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <td><strong>No. Pendaftaran</strong></td>
                            <td>{{ $calonSiswa->no_pendaftaran }}</td>
                        </tr>
                        <tr>
                            <td><strong>Nama Lengkap</strong></td>
                            <td>{{ $calonSiswa->nama }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tempat, Tanggal Lahir</strong></td>
                            <td>{{ $calonSiswa->tempat_lahir }}, {{ \Carbon\Carbon::parse($calonSiswa->tanggal_lahir)->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Jenis Kelamin</strong></td>
                            <td>{{ $calonSiswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Alamat</strong></td>
                            <td>{{ $calonSiswa->alamat }}</td>
                        </tr>
                        <tr>
                            <td><strong>Asal Sekolah</strong></td>
                            <td>{{ $calonSiswa->asal_sekolah }}</td>
                        </tr>
                        <tr>
                            <td><strong>Asrama</strong></td>
                            <td>{{ $calonSiswa->asrama }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Data Wali</h6>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
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

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Pembayaran</h6>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
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
                                    <span class="badge bg-danger">Pending</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Total Biaya</strong></td>
                            <td class="fw-bold">Rp {{ number_format($calonSiswa->total_biaya, 0, ',', '.') }}</td>
                        </tr>
                        @if($calonSiswa->diskon > 0)
                        <tr>
                            <td><strong>Diskon</strong></td>
                            <td class="text-success">Rp {{ number_format($calonSiswa->diskon, 0, ',', '.') }}</td>
                        </tr>
                        @endif
                    </table>

                    <!-- Form Update Status Pembayaran -->
                    <form action="{{ route('admin.calon-siswa.status', $calonSiswa->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="status_pembayaran" class="form-label">Update Status Pembayaran</label>
                            <select name="status_pembayaran" id="status_pembayaran" class="form-select">
                                <option value="pending" {{ $calonSiswa->status_pembayaran == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="angsur" {{ $calonSiswa->status_pembayaran == 'angsur' ? 'selected' : '' }}>Angsur</option>
                                <option value="lunas" {{ $calonSiswa->status_pembayaran == 'lunas' ? 'selected' : '' }}>Lunas</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Status</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Program yang Dipilih</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Program</th>
                            <th>Kelas</th>
                            <th>Jenis Kelamin</th>
                            <th>Biaya</th>
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
                            <td>Rp {{ number_format($program->biaya, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Riwayat Pembayaran -->
    @if($calonSiswa->pembayaran->count() > 0)
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Riwayat Pembayaran</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jumlah</th>
                            <th>Metode</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($calonSiswa->pembayaran as $pembayaran)
                        <tr>
                            <td>{{ $pembayaran->created_at->format('d/m/Y H:i') }}</td>
                            <td>Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</td>
                            <td>{{ $pembayaran->metode_pembayaran }}</td>
                            <td>
                                @if($pembayaran->status == 'success')
                                    <span class="badge bg-success">Success</span>
                                @elseif($pembayaran->status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @else
                                    <span class="badge bg-danger">Failed</span>
                                @endif
                            </td>
                            <td>{{ $pembayaran->keterangan }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection