@extends('layouts.admin')

@section('title', 'Tambah Kelas - ' . $program->nama_program)

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Kelas Baru</h1>
        <a href="{{ route('admin.program') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Program
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Tambah Kelas - {{ $program->nama_program }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.kelas.store', $program->id) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama_kelas" class="form-label">Nama Kelas *</label>
                            <input type="text" class="form-control" id="nama_kelas" name="nama_kelas" required placeholder="Contoh: Kelas A, Kelas 1, dll.">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="kuota" class="form-label">Kuota Maksimal *</label>
                            <input type="number" class="form-control" id="kuota" name="kuota" value="25" required>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Kelas ini akan ditambahkan ke program <strong>{{ $program->nama_program }}</strong> 
                        untuk <strong>{{ $program->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</strong>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Simpan Kelas
                </button>
            </form>
        </div>
    </div>

    <!-- Daftar Kelas yang Sudah Ada -->
    @if($program->kelas->count() > 0)
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Kelas yang Sudah Ada</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Kelas</th>
                            <th>Kuota</th>
                            <th>Sisa Kuota</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($program->kelas as $kelas)
                        <tr>
                            <td>{{ $kelas->nama_kelas }}</td>
                            <td>{{ $kelas->kuota }}</td>
                            <td>
                                @php
                                    $terdaftar = \App\Models\PendaftaranProgram::where('kelas_id', $kelas->id)->count();
                                    $sisa = $kelas->kuota - $terdaftar;
                                @endphp
                                {{ $sisa }}
                            </td>
                            <td>
                                @if($sisa > 0)
                                    <span class="badge bg-success">Tersedia</span>
                                @else
                                    <span class="badge bg-danger">Penuh</span>
                                @endif
                            </td>
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