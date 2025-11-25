@extends('layouts.admin')

@section('title', 'Manajemen Program & Kelas')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Program & Kelas</h1>
        <a href="{{ route('admin.program.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Program
        </a>
    </div>

    <!-- Statistik Program -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Program</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $programs->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Program Tersedia</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $programs->where('kuota_tersedia', '>', 0)->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Program Penuh</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $programs->where('kuota_tersedia', '<=', 0)->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Kelas</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $programs->sum(function($program) { return $program->kelas->count(); }) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @foreach($programs as $program)
        <div class="col-lg-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-book me-2"></i>{{ $program->nama_program }}
                    </h6>
                    <div class="btn-group">
                        <a href="{{ route('admin.program.edit', $program->id) }}" class="btn btn-sm btn-warning" title="Edit Program">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="{{ route('admin.kelas.create', $program->id) }}" class="btn btn-sm btn-success" title="Tambah Kelas">
                            <i class="fas fa-plus"></i> Kelas
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Informasi Program -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-venus-mars text-primary me-2"></i>
                                <strong>Jenis Kelamin:</strong>
                                <span class="badge bg-{{ $program->jenis_kelamin == 'L' ? 'primary' : 'danger' }} ms-2">
                                    {{ $program->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                </span>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-users text-info me-2"></i>
                                <strong>Kuota:</strong>
                                <span class="ms-2">{{ $program->kuota_tersedia }}/{{ $program->kuota }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-money-bill-wave text-success me-2"></i>
                                <strong>Biaya:</strong>
                                <span class="ms-2">Rp {{ number_format($program->biaya, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-circle me-2 text-{{ $program->kuota_tersedia > 0 ? 'success' : 'danger' }}"></i>
                                <strong>Status:</strong>
                                <span class="badge bg-{{ $program->kuota_tersedia > 0 ? 'success' : 'danger' }} ms-2">
                                    {{ $program->kuota_tersedia > 0 ? 'Tersedia' : 'Penuh' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Progress Bar Kuota -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <small>Kuota Terisi</small>
                            <small>{{ $program->kuota - $program->kuota_tersedia }} / {{ $program->kuota }}</small>
                        </div>
                        <div class="progress" style="height: 8px;">
                            @php
                                $percentage = (($program->kuota - $program->kuota_tersedia) / $program->kuota) * 100;
                            @endphp
                            <div class="progress-bar bg-{{ $percentage >= 90 ? 'danger' : ($percentage >= 70 ? 'warning' : 'success') }}" 
                                 role="progressbar" 
                                 style="width: {{ $percentage }}%"
                                 aria-valuenow="{{ $percentage }}" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100">
                            </div>
                        </div>
                    </div>

                    <!-- Daftar Kelas -->
                    <h6 class="font-weight-bold text-dark mb-3">
                        <i class="fas fa-chalkboard me-2"></i>Daftar Kelas
                    </h6>
                    
                    @if($program->kelas->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered table-hover">
                                <thead class="bg-light">
                                    <tr>
                                        <th width="40%">Nama Kelas</th>
                                        <th width="20%">Kuota</th>
                                        <th width="20%">Sisa</th>
                                        <th width="20%">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($program->kelas as $kelas)
                                    @php
                                        $terdaftar = \App\Models\PendaftaranProgram::where('kelas_id', $kelas->id)->count();
                                        $sisa = $kelas->kuota - $terdaftar;
                                        $kelasPercentage = ($terdaftar / $kelas->kuota) * 100;
                                    @endphp
                                    <tr>
                                        <td>
                                            <i class="fas fa-chalkboard-teacher text-primary me-2"></i>
                                            <strong>{{ $kelas->nama_kelas }}</strong>
                                        </td>
                                        <td>{{ $kelas->kuota }}</td>
                                        <td>
                                            <span class="fw-bold {{ $sisa <= 0 ? 'text-danger' : 'text-success' }}">
                                                {{ $sisa }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($sisa > 0)
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check me-1"></i>Tersedia
                                                </span>
                                            @else
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-times me-1"></i>Penuh
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-warning d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle me-3 fa-lg"></i>
                            <div>
                                <strong>Belum ada kelas!</strong><br>
                                <small>Tambahkan kelas untuk program ini dengan menekan tombol "Tambah Kelas"</small>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="card-footer bg-transparent">
                    <small class="text-muted">
                        <i class="fas fa-clock me-1"></i>
                        Dibuat: {{ $program->created_at->format('d M Y H:i') }}
                    </small>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if($programs->count() == 0)
    <div class="text-center py-5">
        <div class="py-5">
            <i class="fas fa-book fa-4x text-muted mb-3"></i>
            <h4 class="text-muted">Belum ada program</h4>
            <p class="text-muted">Mulai dengan menambahkan program pertama Anda</p>
            <a href="{{ route('admin.program.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tambah Program Pertama
            </a>
        </div>
    </div>
    @endif
</div>

<style>
.progress {
    border-radius: 10px;
}
.progress-bar {
    border-radius: 10px;
    transition: width 0.6s ease;
}
.card {
    border-radius: 10px;
    border: none;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    transition: all 0.3s;
}
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 2rem 0 rgba(58, 59, 69, 0.2);
}
.table-hover tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.05);
}
</style>
@endsection