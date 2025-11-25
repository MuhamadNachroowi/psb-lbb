<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthController; // PERBAIKI NAMESPACE INI

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profil', [HomeController::class, 'profil'])->name('profil');
Route::get('/pengumuman', [HomeController::class, 'pengumuman'])->name('pengumuman');

// Pendaftaran Routes
Route::get('/pendaftaran', [PendaftaranController::class, 'create'])->name('pendaftaran.create');
Route::post('/pendaftaran', [PendaftaranController::class, 'store'])->name('pendaftaran.store');
Route::get('/pendaftaran/success/{no_pendaftaran}', [PendaftaranController::class, 'success'])->name('pendaftaran.success');
Route::get('/pendaftaran/cetak/{no_pendaftaran}', [PendaftaranController::class, 'cetakBukti'])->name('pendaftaran.cetak');

// Auth Routes - PERBAIKI INI
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// API Routes
Route::get('/api/kelas/{programId}', function ($programId) {
    $kelas = \App\Models\Kelas::where('program_id', $programId)->get();
    return response()->json($kelas);
});

// Route untuk data calon siswa
Route::get('/admin/calon-siswa', [AdminController::class, 'calonSiswa'])->name('admin.calon-siswa');
Route::get('/admin/calon-siswa/{id}', [AdminController::class, 'showCalonSiswa'])->name('admin.calon-siswa.show');
Route::post('/admin/calon-siswa/export', [AdminController::class, 'exportSiswa'])->name('admin.calon-siswa.export');

// Admin Routes
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Calon Siswa Routes (Operator)
    Route::middleware(['can:operator'])->group(function () {
        Route::get('/calon-siswa', [AdminController::class, 'calonSiswa'])->name('admin.calon-siswa');
        Route::get('/calon-siswa/{id}', [AdminController::class, 'showCalonSiswa'])->name('admin.calon-siswa.show');
        Route::post('/calon-siswa/{id}/status-pembayaran', [AdminController::class, 'updateStatusPembayaran'])->name('admin.calon-siswa.status');

        // Program Routes
        Route::get('/program', [AdminController::class, 'program'])->name('admin.program');
        Route::get('/program/create', [AdminController::class, 'createProgram'])->name('admin.program.create');
        Route::post('/program', [AdminController::class, 'storeProgram'])->name('admin.program.store');
        Route::get('/program/{id}/edit', [AdminController::class, 'editProgram'])->name('admin.program.edit');
        Route::put('/program/{id}', [AdminController::class, 'updateProgram'])->name('admin.program.update');

        // Kelas Routes
        Route::get('/program/{programId}/kelas/create', [AdminController::class, 'createKelas'])->name('admin.kelas.create');
        Route::post('/program/{programId}/kelas', [AdminController::class, 'storeKelas'])->name('admin.kelas.store');

        // Artikel Routes
        Route::get('/articles', [AdminController::class, 'articles'])->name('admin.articles');
        Route::get('/articles/create', [AdminController::class, 'createArticle'])->name('admin.articles.create');
        Route::post('/articles', [AdminController::class, 'storeArticle'])->name('admin.articles.store');
        Route::get('/articles/{id}/edit', [AdminController::class, 'editArticle'])->name('admin.articles.edit');
        Route::put('/articles/{id}', [AdminController::class, 'updateArticle'])->name('admin.articles.update');
        Route::delete('/articles/{id}', [AdminController::class, 'destroyArticle'])->name('admin.articles.destroy');

        // Promo Routes
        Route::get('/promo', [AdminController::class, 'promo'])->name('admin.promo');
        Route::get('/promo/create', [AdminController::class, 'createPromo'])->name('admin.promo.create');
        Route::post('/promo', [AdminController::class, 'storePromo'])->name('admin.promo.store');
    });

    // Keuangan Routes
    Route::middleware(['can:keuangan'])->group(function () {
        Route::get('/pembayaran', [AdminController::class, 'pembayaran'])->name('admin.pembayaran');
        Route::post('/pembayaran/{id}/status', [AdminController::class, 'updateStatusPembayaranDetail'])->name('admin.pembayaran.status');
        Route::get('/laporan', [AdminController::class, 'laporan'])->name('admin.laporan');
    });
});
