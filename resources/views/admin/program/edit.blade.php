@extends('layouts.admin')

@section('title', 'Edit Program - ' . $program->nama_program)

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Program</h1>
        <a href="{{ route('admin.program') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit Program</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.program.update', $program->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama_program" class="form-label">Nama Program *</label>
                            <input type="text" class="form-control" id="nama_program" name="nama_program" value="{{ $program->nama_program }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin *</label>
                            <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                                <option value="L" {{ $program->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ $program->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="kuota" class="form-label">Kuota Maksimal *</label>
                            <input type="number" class="form-control" id="kuota" name="kuota" value="{{ $program->kuota }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="biaya" class="form-label">Biaya Program *</label>
                            <input type="number" class="form-control" id="biaya" name="biaya" value="{{ $program->biaya }}" required>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Update Program
                </button>
            </form>
        </div>
    </div>
</div>
@endsection