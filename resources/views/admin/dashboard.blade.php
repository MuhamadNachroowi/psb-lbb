<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - LBB Darul Ulum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar Admin -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="/admin/dashboard">
                <i class="fas fa-graduation-cap"></i> LBB Darul Ulum Admin
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/dashboard">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    @can('operator')
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/calon-siswa">
                            <i class="fas fa-users"></i> Calon Siswa
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/program">
                            <i class="fas fa-book"></i> Program & Kelas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/articles">
                            <i class="fas fa-newspaper"></i> Artikel
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/promo">
                            <i class="fas fa-tag"></i> Promo
                        </a>
                    </li>
                    @endcan
                    @can('keuangan')
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/pembayaran">
                            <i class="fas fa-money-bill-wave"></i> Pembayaran
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/laporan">
                            <i class="fas fa-chart-bar"></i> Laporan
                        </a>
                    </li>
                    @endcan
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle"></i> {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog"></i> Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Statistik -->
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Calon Siswa</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_siswa'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
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
                                    Siswa Bulan Ini</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['siswa_baru_bulan_ini'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-plus fa-2x text-gray-300"></i>
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
                                    Total Program</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_program'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-book fa-2x text-gray-300"></i>
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
                                    Pembayaran Pending</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['pembayaran_pending'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grafik dan Quick Actions -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Statistik Pendaftaran Bulanan</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="pendaftaranChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                    </div>
                    <div class="card-body">
                        @can('operator')
                        <div class="d-grid gap-2">
                            <a href="/admin/calon-siswa" class="btn btn-primary btn-block">
                                <i class="fas fa-users me-2"></i>Kelola Calon Siswa
                            </a>
                            <a href="/admin/program" class="btn btn-success btn-block">
                                <i class="fas fa-book me-2"></i>Kelola Program
                            </a>
                            <a href="/admin/articles/create" class="btn btn-info btn-block">
                                <i class="fas fa-plus me-2"></i>Tambah Artikel
                            </a>
                            <a href="/admin/promo/create" class="btn btn-warning btn-block">
                                <i class="fas fa-tag me-2"></i>Buat Promo
                            </a>
                        </div>
                        @endcan
                        @can('keuangan')
                        <div class="d-grid gap-2">
                            <a href="/admin/pembayaran" class="btn btn-primary btn-block">
                                <i class="fas fa-money-bill-wave me-2"></i>Kelola Pembayaran
                            </a>
                            <a href="/admin/laporan" class="btn btn-success btn-block">
                                <i class="fas fa-chart-bar me-2"></i>Lihat Laporan
                            </a>
                        </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Grafik pendaftaran
        const ctx = document.getElementById('pendaftaranChart').getContext('2d');
        const pendaftaranChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Jumlah Pendaftaran',
                    data: [
                        {{ $siswaPerBulan->where('bulan', 1)->first()->total ?? 0 }},
                        {{ $siswaPerBulan->where('bulan', 2)->first()->total ?? 0 }},
                        {{ $siswaPerBulan->where('bulan', 3)->first()->total ?? 0 }},
                        {{ $siswaPerBulan->where('bulan', 4)->first()->total ?? 0 }},
                        {{ $siswaPerBulan->where('bulan', 5)->first()->total ?? 0 }},
                        {{ $siswaPerBulan->where('bulan', 6)->first()->total ?? 0 }},
                        {{ $siswaPerBulan->where('bulan', 7)->first()->total ?? 0 }},
                        {{ $siswaPerBulan->where('bulan', 8)->first()->total ?? 0 }},
                        {{ $siswaPerBulan->where('bulan', 9)->first()->total ?? 0 }},
                        {{ $siswaPerBulan->where('bulan', 10)->first()->total ?? 0 }},
                        {{ $siswaPerBulan->where('bulan', 11)->first()->total ?? 0 }},
                        {{ $siswaPerBulan->where('bulan', 12)->first()->total ?? 0 }}
                    ],
                    borderColor: '#4e73df',
                    backgroundColor: 'rgba(78, 115, 223, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    }
                }
            }
        });
    </script>
</body>
</html>