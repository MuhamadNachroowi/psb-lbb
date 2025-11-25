<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Calon Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>DATA SISWA</h1>
            <div>
                <a href="{{ route('admin.calon-siswa.export', ['type' => 'xlsx']) }}" class="btn btn-success">
                    📊 Export Excel
                </a>
            </div>
        </div>

        <!-- FILTER SECTION -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">FILTER DATA SISWA</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ url('/admin/calon-siswa') }}">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label"><strong>NOMOR INDUK</strong></label>
                                <input type="text" class="form-control" name="nomor_induk" value="{{ request('nomor_induk') }}" placeholder="Ketikkan disini...">
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label"><strong>STATUS BAYAR</strong></label>
                                <select class="form-control" name="status_bayar">
                                    <option value="">SEMUA STATUS</option>
                                    <option value="LUNAS" {{ request('status_bayar') == 'LUNAS' ? 'selected' : '' }}>LUNAS</option>
                                    <option value="BELUM LUNAS" {{ request('status_bayar') == 'BELUM LUNAS' ? 'selected' : '' }}>BELUM LUNAS</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label"><strong>DARI TANGGAL</strong></label>
                                <input type="date" class="form-control" name="dari_tanggal" value="{{ request('dari_tanggal') }}">
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label"><strong>SAMPAI TANGGAL</strong></label>
                                <input type="date" class="form-control" name="sampai_tanggal" value="{{ request('sampai_tanggal') }}">
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">TERAPKAN FILTER</button>
                        <a href="{{ url('/admin/calon-siswa') }}" class="btn btn-secondary">HAPUS FILTER</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- TABLE DATA SISWA -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">DAFTAR SISWA ({{ $siswa->count() }} siswa)</h5>
                <a href="{{ route('admin.calon-siswa.export', ['type' => 'xlsx']) }}" class="btn btn-success btn-sm">
                    📊 Export Excel
                </a>
            </div>
            <div class="card-body">
                @if($siswa->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>NOMOR INDUK</th>
                                    <th>NAMA LENGKAP</th>
                                    <th>JENIS KELAMIN</th>
                                    <th>ASAL SEKOLAH</th>
                                    <th>ASRAMA</th>
                                    <th>PROGRAM</th>
                                    <th>KELAS</th>
                                    <th>STATUS BAYAR</th>
                                    <th>AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($siswa as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nomor_induk ?? '-' }}</td>
                                    <td>{{ $item->nama_lengkap ?? '-' }}</td>
                                    <td>{{ $item->jenis_kelamin ?? '-' }}</td>
                                    <td>{{ $item->asal_sekolah ?? '-' }}</td>
                                    <td>{{ $item->asrama ?? '-' }}</td>
                                    <td>{{ $item->program ?? '-' }}</td>
                                    <td>{{ $item->kelas ?? '-' }}</td>
                                    <td>
                                        <span class="badge {{ $item->status_bayar == 'LUNAS' ? 'bg-success' : 'bg-warning' }}">
                                            {{ $item->status_bayar ?? 'BELUM BAYAR' }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-primary">Detail</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <p class="text-muted">Tidak ada data siswa ditemukan.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>